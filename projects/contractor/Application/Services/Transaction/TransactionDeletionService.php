<?php

namespace Application\Services\Transaction;

use Application\Repositories\TransactionRepository;
use Ramsey\Uuid\UuidInterface;

class TransactionDeletionService
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function delete(UuidInterface $id): bool
    {
        $transactionModel = $this->transactionRepository->getOneBy(['id' => $id->toString()]);
        $transactionModel->delete();

        if (!$transactionModel->save()) {
            throw new \RuntimeException('Transaction was not deleted');
        }

        return true;
    }
}
