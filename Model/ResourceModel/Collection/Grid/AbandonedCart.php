<?php
declare(strict_types=1);

namespace OH\AbandonedCart\Model\ResourceModel\Collection\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Class Log
 * @package OH\AbandonedCart\Model\ResourceModel\Collection\Grid
 */
class AbandonedCart extends \OH\AbandonedCart\Model\ResourceModel\Collection\AbandonedCart implements SearchResultInterface
{
    protected $aggregations;

    public function getAggregations()
    {
        return $this->aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    public function getSearchCriteria()
    {
        return null;
    }

    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    public function setItems(array $items = null)
    {
        return $this;
    }
}







