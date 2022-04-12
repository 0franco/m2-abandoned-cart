<?php

declare(strict_types=1);

namespace OH\AbandonedCart\Plugin;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Quote\Model\Quote;
use OH\AbandonedCart\Model\ACartManagement;
use OH\AbandonedCart\Model\ConfigProvider;

class QuotePlugin
{
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
        ConfigProvider $configProvider
    ) {
        $this->serializer = $serializer;
        $this->configProvider = $configProvider;
        $this->acManagement = $acManagement;
    }

    /**
     * Save cart data
     *
     * @param Quote $subject
     * @param Quote $result
     * @return Quote
     */
    public function afterAfterSave(Quote $subject, Quote $result)
    {
        if ($this->configProvider->isEnable() &&
            $result->getCustomerEmail() &&
            $result->hasItems()) {

            $customerEmail = $result->getCustomerEmail();
            $quoteId = $subject->getEntityId();
            $cartData = array_merge(
                $result->getData(),
                [
                    'customer_email' => $customerEmail,
                    'quote_id' => $quoteId
                ]
            );

            $this->acManagement->save(
                $customerEmail,
                $quoteId,
                $this->serializer->serialize($cartData)
            );
        }

        return $result;
    }
}