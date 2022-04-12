<?php

declare(strict_types=1);

namespace OH\AbandonedCart\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchCriteriaInterface;
use OH\AbandonedCart\Api\AbandonedCartRepositoryInterface;
use OH\AbandonedCart\Api\Data\AbandonedCartInterface;
use OH\AbandonedCart\Api\Data\AbandonedCartSearchResultInterface;

class AbandonedCartRepository implements AbandonedCartRepositoryInterface
{
    /**
     * @var ResourceModel\AbandonedCart
     */
    private $resource;

    /**
     * @var AbandonedCartFactory
     */
    private $acFactory;

    /**
     * @var ResourceModel\Collection\AbandonedCartFactory
     */
    private $acCollectionFactory;

    /**
     * @var AbandonedCartSearchResultInterface
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        AbandonedCartSearchResultInterface $abandonedCartSearchResult,
        \OH\AbandonedCart\Model\ResourceModel\Collection\AbandonedCartFactory $acCollectionFactory,
        AbandonedCartFactory $acFactory,
        \OH\AbandonedCart\Model\ResourceModel\AbandonedCart $resource
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->resource = $resource;
        $this->acFactory = $acFactory;
        $this->acCollectionFactory = $acCollectionFactory;
        $this->searchResultsFactory = $abandonedCartSearchResult;
    }

    public function save(AbandonedCartInterface $cart)
    {
        try {
            $this->resource->save($cart);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $cart;
    }

    public function get($cartId)
    {
        $ac = $this->acFactory->create();
        $this->resource->load($ac, $cartId);

        if (!$ac->getId()) {
            throw new NoSuchEntityException(__('Cart was not found.', $ac));
        }

        return $ac;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->acCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var AbandonedCartSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete(AbandonedCartInterface $cart)
    {
        try {
            $this->resource->delete($cart);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById($entityId)
    {
        return $this->delete($this->get($entityId));
    }

    public function getByQuoteId($quoteId)
    {
        $ac = $this->acCollectionFactory->create()
            ->addFieldToFilter(AbandonedCartInterface::QUOTE_ID, $quoteId)
            ->getFirstItem();

        return $ac->getId() ? $ac : null;
    }
}