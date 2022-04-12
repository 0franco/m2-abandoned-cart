<?php
declare(strict_types=1);

namespace OH\AbandonedCart\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface AbandonedCartInterface extends ExtensibleDataInterface
{
    const ID = 'id';
    const QUOTE_ID = 'quote_id';
    const STATUS = 'status';
    const CUSTOMER_EMAIL = 'customer_email';
    const CART_DATA = 'cart_data';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get cart ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set cart ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get quote ID
     *
     * @return int|null
     */
    public function getQuoteId();

    /**
     * Set quote ID
     *
     * @param int $id
     * @return $this
     */
    public function setQuoteId($id);

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param $status $id
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get customer email
     *
     * @return string
     */
    public function getCustomerEmail();

    /**
     * Set customer email
     *
     * @param string $email
     * @return $this
     */
    public function setCustomerEmail($email);

    /**
     * Get cart data (serialized)
     *
     * @return string
     */
    public function getCartData();

    /**
     * Set cart data (serialized)
     *
     * @param string $cartData
     * @return $this
     */
    public function setCartData($cartData);

    /**
     * Get created at time
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at time
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
