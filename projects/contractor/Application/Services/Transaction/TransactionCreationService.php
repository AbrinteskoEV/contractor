<?php

namespace Application\Services\Transaction;

use Application\Dto\Transaction\TransactionCreationDto;
use Application\Models\TransactionModel;

class TransactionCreationService
{
    /**
     * @param TransactionCreationDto $creationDto
     *
     * @return TransactionModel
     */
    public function create(TransactionCreationDto $creationDto): TransactionModel
    {
        $transactionModel = new TransactionModel();
        $transactionModel->setAmount($creationDto->getAmount())
            ->setContractorId($creationDto->getContractorId()->toString());

        if (!$transactionModel->save()) {
            throw new \RuntimeException('Transaction was not created');
        }

        return $transactionModel;
    }

}
