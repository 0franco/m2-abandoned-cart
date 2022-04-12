<?php

declare(strict_types=1);

namespace OH\AbandonedCart\Plugin\Customer;

use Magento\Checkout\Model\Session;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use OH\AbandonedCart\Model\ACartManagement;
use OH\AbandonedCart\Model\ConfigProvider;

class AccountManagementPlugin
{
    /**
     * @var Session
     */
    private Session $checkoutSession;

    /**
     * @var ConfigProvider
     */
    private ConfigProvider $configProvider;

    /**
     * @var ACartManagement
     */
    private ACartManagement $acManagement;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer,
        ACartManagement $acManagement,
        ConfigProvider $configProvider,
        Session $checkoutSession
    ) {
        $this->serializer = $serializer;
        $this->checkoutSession = $checkoutSession;
        $this->configProvider = $configProvider;
        $this->acManagement = $acManagement;
    }

    /**
     * Save guest email
     *
     * @param AccountManagementInterface $subject
     * @param $customerEmail
     * @param null $websiteId
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function beforeIsEmailAvailable(AccountManagementInterface $subject, $customerEmail, $websiteId = null)
    {
        if ($this->configProvider->isEnable() &&
            $quote = $this->checkoutSession->getQuote()) {
            $quoteId = $quote->getEntityId();
            $cartData = array_merge(
                $quote->getData(),
                [
                    'customer_email' => $customerEmail,
                    'quote_id' => $quoteId
                ]
            );

            if ($quote->hasItems()) {
                $this->acManagement->save(
                    $customerEmail,
                    $quoteId,
                    $this->serializer->serialize($this->getPreparedCartData($cartData))
                );
            }
        }
    }


    /**
     * Get prepared cart data
     *
     * @param array $data
     * @return array
     */
    private function getPreparedCartData(array $data): array
    {
        $items = [];

        foreach ($data['items'] as $itemKey => $item) {
            $qtyOpts = [];
            $itemData = $item->getData();

            foreach ($item->getQtyOptions() as $optKey => $opt) {
                $qtyOpts[$optKey] = $opt->getData();
            }

            $itemData['qty_options'] = $qtyOpts;
            $itemData['product'] = $item->getProduct()->getData();
            $items[$itemKey] = $itemData;
        }

        $data['items'] = $items;
        return $data;
    }
}