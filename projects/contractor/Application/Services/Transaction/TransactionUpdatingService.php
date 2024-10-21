<?php

namespace Application\Services\Transaction;

use Application\Dto\Transaction\TransactionUpdatingDto;
use Application\Exceptions\ApplicationException;
use Application\Models\TransactionModel;

class TransactionUpdatingService
{
    private TransactionGettingService $transactionGettingService;

    public function __construct(TransactionGettingService $transactionGettingService)
    {
        $this->transactionGettingService = $transactionGettingService;
    }

    /**
     * @param TransactionUpdatingDto $updatingDto
     *
     * @return TransactionModel
     *
     * @throws ApplicationException
     */
    public function update(TransactionUpdatingDto $updatingDto): TransactionModel
    {
        $transactionModel = $this->transactionGettingService->getById($updatingDto->getId());

        if ($updatingDto->getAmount()) {
            $transactionModel->setAmount($updatingDto->getAmount());
        }

        if ($updatingDto->getContractorId()) {
            $transactionModel->setContractorId($updatingDto->getContractorId()->toString());
        }

        if (!$transactionModel->save()) {
            throw new \RuntimeException('Transaction was not updated');
        }

        return $transactionModel;
    }

}
