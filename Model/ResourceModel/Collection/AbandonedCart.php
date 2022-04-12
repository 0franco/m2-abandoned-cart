<?php
declare(strict_types=1);

namespace OH\AbandonedCart\Model\ResourceModel\Collection;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class AbandonedCart
 * @package OH\AbandonedCart\Model\ResourceModel\Collection
 */
class AbandonedCart extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(\OH\AbandonedCart\Model\AbandonedCart::class, \OH\AbandonedCart\Model\ResourceModel\AbandonedCart::class);
    }
}
