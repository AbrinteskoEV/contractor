<?php

namespace Application\Dto\Transaction;

use Ramsey\Uuid\UuidInterface;

class TransactionCreationDto
{
    private float $amount;
    private UuidInterface $contractorId;

    public function __construct(
        float $amount,
        UuidInterface $contractorId
    ) {
        $this->amount = $amount;
        $this->contractorId = $contractorId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return UuidInterface
     */
    public function getContractorId(): UuidInterface
    {
        return $this->contractorId;
    }
}
