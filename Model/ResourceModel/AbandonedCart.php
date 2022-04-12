<?php
declare(strict_types=1);

namespace OH\AbandonedCart\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class AbandonedCart
 * @package OH\AbandonedCart\Model\ResourceModel
 */
class AbandonedCart extends AbstractDb
{
    const TABLE_NAME = 'oh_abandoned_cart';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'id');
    }

    public function fetchByQuoteId($quoteId)
    {
        $select = $this->getConnection()->select()->from($this->getMainTable());
        $select->where('quote_id = ?', $quoteId);
        return $this->getConnection()->fetchOne($select);
    }

    public function fetchByCustomerEmail($email)
    {
        $select = $this->getConnection()->select()->from($this->getMainTable());
        $select->where('customer_email = ?', $email);
        return $this->getConnection()->fetchOne($select);
    }
}
