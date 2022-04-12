<?php
declare(strict_types=1);

namespace OH\AbandonedCart\Model;

use Magento\Framework\Api\Search\SearchResult;
use OH\AbandonedCart\Api\Data\AbandonedCartSearchResultInterface;

/**
 * Class ACSearchResult
 * @package OH\AbandonedCart\Model
 */
class ACSearchResult extends SearchResult implements AbandonedCartSearchResultInterface
{
}