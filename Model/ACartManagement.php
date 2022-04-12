<?php

declare(strict_types=1);

namespace OH\AbandonedCart\Model;

use OH\AbandonedCart\Api\AbandonedCartRepositoryInterface;

class ACartManagement
{
    /**
     * @var AbandonedCartFactory
     */
    private AbandonedCartFactory $abadonedCartFactory;

    /**
     * @var AbandonedCartRepositoryInterface
     */
    private AbandonedCartRepositoryInterface $aCRepository;

    public function __construct(
        AbandonedCartRepositoryInterface $aCRepository,
        AbandonedCartFactory $abadonedCartFactory
    ) {
        $this->abadonedCartFactory = $abadonedCartFactory;
        $this->aCRepository = $aCRepository;
    }

    /**
     * Get cart data by quote id
     *
     * @param $quoteId
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCartDataByQuoteId($quoteId): string
    {
        return $this->aCRepository
            ->getByQuoteId($quoteId)
            ->getCartData();
    }

    public function save($email, $quoteId, $data)
    {
        $aC = $this->aCRepository->getByQuoteId($quoteId);

        if ($aC) {
            //if email changed update it, also update data
            if ($this->isEmailChanged($aC->getCustomerEmail(), $email)) {
                $aC->setCustomerEmail($email);
                $aC->setCartData($data);
            }
        } else {
            $aC = $this->abadonedCartFactory
                ->create()
                ->setQuoteId($quoteId)
                ->setCustomerEmail($email)
                ->setStatus(Status::PENDING)
                ->setCartData($data);
        }

        $this->aCRepository->save($aC);
        return $aC;
    }

    public function deleteById($entityId): bool
    {
        try {
            $this->aCRepository->deleteById($entityId);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function changeStatus($ac, $status)
    {
        $ac->setStatus($status);
        $this->aCRepository->save($ac);
    }

    private function isEmailChanged($old, $new): bool
    {
        return $old != $new;
    }
}