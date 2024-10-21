<?php

namespace Application\Dto\Transaction;

use Ramsey\Uuid\UuidInterface;

class TransactionUpdatingDto
{
    private UuidInterface $id;
    private ?float $amount = null;
    private ?UuidInterface $contractorId = null;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return self
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return UuidInterface|null
     */
    public function getContractorId(): ?UuidInterface
    {
        return $this->contractorId;
    }

    /**
     * @param UuidInterface $contractorId
     * @return self
     */
    public function setContractorId(UuidInterface $contractorId): self
    {
        $this->contractorId = $contractorId;
        return $this;
    }
}
