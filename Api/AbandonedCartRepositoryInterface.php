<?php

declare(strict_types=1);

namespace OH\AbandonedCart\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use OH\AbandonedCart\Api\Data\AbandonedCartInterface;
use OH\AbandonedCart\Api\Data\AbandonedCartSearchResultInterface;

interface AbandonedCartRepositoryInterface
{
    /**
     * Save cart
     *
     * @param AbandonedCartInterface $cart
     * @return AbandonedCartInterface
     * @throws LocalizedException
     */
    public function save(AbandonedCartInterface $cart);

    /**
     * Retrieve cart
     *
     * @param int $cartId
     * @return AbandonedCartInterface
     * @throws NoSuchEntityException
     */
    public function get($cartId);

    /**
     * Retrieve cart by quote id
     *
     * @param int $quoteId
     * @return AbandonedCartInterface
     * @throws NoSuchEntityException
     */
    public function getByQuoteId($quoteId);

    /**
     * Retrieve cart by criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AbandonedCartSearchResultInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete cart
     *
     * @param AbandonedCartInterface $cart
     * @return bool
     * @throws NoSuchEntityException
     */
    public function delete(AbandonedCartInterface $cart);

    /**
     * Delete by id
     *
     * @param int $entityId
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById($entityId);
}