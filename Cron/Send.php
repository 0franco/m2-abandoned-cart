<?php

declare(strict_types=1);

namespace OH\AbandonedCart\Cron;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Quote\Model\ResourceModel\Quote\CollectionFactory;
use OH\AbandonedCart\Api\Data\AbandonedCartInterface;
use OH\AbandonedCart\Model\ACartManagement;
use OH\AbandonedCart\Model\ConfigProvider;
use OH\AbandonedCart\Model\Notifier;
use OH\AbandonedCart\Model\ResourceModel\Collection\AbandonedCartFactory;
use OH\AbandonedCart\Model\Status;

class Send
{
    /**
     * @var ConfigProvider
     */
    private ConfigProvider $configProvider;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var AbandonedCartFactory
     */
    private AbandonedCartFactory $acCollectionFactory;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $quoteCollectionFactory;

    /**
     * @var Notifier
     */
    private Notifier $notifier;

    /**
     * @var ACartManagement
     */
    private ACartManagement $acManagement;

    public function __construct(
        ACartManagement $acManagement,
        Notifier $notifier,
        CollectionFactory $quoteCollectionFactory,
        AbandonedCartFactory $acCollectionFactory,
        SerializerInterface $serializer,
        ConfigProvider $configProvider
    ) {
        $this->acManagement = $acManagement;
        $this->notifier = $notifier;
        $this->quoteCollectionFactory = $quoteCollectionFactory;
        $this->serializer = $serializer;
        $this->configProvider = $configProvider;
        $this->acCollectionFactory = $acCollectionFactory;
    }

    /**
     * Send cart reminder
     *
     * @return $this|void
     */
    public function execute()
    {
        if (!$this->configProvider->isEnable()) {
            return $this;
        }

        $isSecondEnabled = $this->configProvider->isEnable(2);
        $isThirdEnabled = $this->configProvider->isEnable(3);

        $carts = $this->acCollectionFactory
            ->create()
            ->addFieldToFilter(AbandonedCartInterface::STATUS, ['neq' => Status::SENT_3]);

        foreach ($carts as $cart) {
            $cartData = $this->serializer->unserialize($cart->getCartData());
            $quote = $this->quoteCollectionFactory
                ->create()
                ->addFieldToSelect('entity_id')
                ->addFieldToSelect('is_active')
                ->addFieldToFilter('entity_id', $cartData['entity_id'])
                ->getFirstItem();

            //skip non-exising cart or no active
            if (!$quote->getId() || !$quote->getIsActive()) {
                continue;
            }

            switch ($cart->getStatus()) {
                case Status::SENT_1:
                    if ($isSecondEnabled) {
                        $this->notifier->send($cart, 2);
                    }
                    break;
                case Status::SENT_2:
                    if ($isThirdEnabled) {
                        $this->notifier->send($cart, 3);
                    }
                    break;
                default:
                    $this->notifier->send($cart);
            }

            $this->acManagement->changeStatus($cart, $cart->getStatus() + 1);
        }
    }
}