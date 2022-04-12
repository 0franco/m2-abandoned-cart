<?php
declare(strict_types=1);

namespace OH\AbandonedCart\Model;

use Magento\Framework\Model\AbstractModel;
use OH\AbandonedCart\Api\Data\AbandonedCartInterface;

/**
 * Class AbandonedCart
 * @package OH\AbandonedCart\Model
 */
class AbandonedCart extends AbstractModel implements AbandonedCartInterface
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\AbandonedCart::class);
    }

    public function getCustomerEmail()
    {
        return $this->_getData(self::CUSTOMER_EMAIL);
    }

    public function setCustomerEmail($email)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $email);
    }

    public function getCartData()
    {
        return $this->_getData(self::CART_DATA);
    }

    public function setCartData($cartData)
    {
        return $this->setData(self::CART_DATA, $cartData);
    }

    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getUpdatedAt()
    {
        return $this->_getData(self::UPDATED_AT);
    }

    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function getQuoteId()
    {
        return $this->_getData(self::QUOTE_ID);
    }

    public function setQuoteId($id)
    {
        return $this->setData(self::QUOTE_ID, $id);
    }

    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}
