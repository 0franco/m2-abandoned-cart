<?php
declare(strict_types=1);

namespace OH\AbandonedCart\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface AbandonedCartSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get cart list
     *
     * @return \OH\AbandonedCart\Api\Data\AbandonedCartInterface[]
     */
    public function getItems();

    /**
     * Set cart list
     *
     * @param \OH\AbandonedCart\Api\Data\AbandonedCartInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
