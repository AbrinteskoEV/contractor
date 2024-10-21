<?php

namespace Application\Http\Requests\Transaction;

use Application\Dto\Transaction\TransactionUpdatingDto;
use Application\Http\Requests\BaseRequest;
use Ramsey\Uuid\Uuid;

class TransactionUpdatingRequest extends BaseRequest
{
    public function rules(): array
    {
        $connection = config('database.default');
        return [
            'id' => 'required|uuid',
            'amount' => 'nullable|numeric',
            'contractorId' => "nullable|exists:$connection.public.contractor,id",
        ];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->post('id');
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        $amount = $this->post('amount');
        return $amount ? (float) $amount : null;
    }

    /**
     * @return string|null
     */
    public function getContractorId(): ?string
    {
        return $this->post('contractorId');
    }

    public function getUpdatingDto(): TransactionUpdatingDto
    {
        $updatingDto = new TransactionUpdatingDto(Uuid::fromString($this->getId()));

        if ($this->getAmount()) {
            $updatingDto->setAmount($this->getAmount());
        }

        if ($this->getContractorId()) {
            $updatingDto->setContractorId(Uuid::fromString($this->getContractorId()));
        }

        return $updatingDto;
    }
}
