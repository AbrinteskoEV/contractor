<?php

namespace Application\Services\Transaction;

use Application\Exceptions\ApplicationException;
use Application\Exceptions\EntityNotFoundException;
use Application\Models\TransactionModel;
use Application\Repositories\TransactionRepository;
use Ramsey\Uuid\UuidInterface;

class TransactionGettingService
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param UuidInterface $id
     *
     * @return TransactionModel
     *
     * @throws ApplicationException
     */
    public function getById(UuidInterface $id): TransactionModel
    {
        try {
            return $this->transactionRepository->getOneBy(['id' => $id->toString()]);
        } catch (EntityNotFoundException) {
            throw new ApplicationException("Транзакция не найдена", ['id' => $id->toString()]);
        }
    }
}
