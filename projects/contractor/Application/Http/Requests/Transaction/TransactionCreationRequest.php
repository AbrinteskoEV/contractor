<?php

namespace Application\Http\Requests\Transaction;

use Application\Dto\Transaction\TransactionCreationDto;
use Application\Http\Requests\BaseRequest;
use Ramsey\Uuid\Uuid;

class TransactionCreationRequest extends BaseRequest
{
    public function rules(): array
    {
        $connection = config('database.default');
        return [
            'amount' => 'required|numeric',
            'contractorId' => "required|exists:$connection.public.contractor,id,deleted_at,NULL",
        ];
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return (float) $this->post('amount');
    }

    /**
     * @return string
     */
    public function getContractorId(): string
    {
        return $this->post('contractorId');
    }

    public function getCreationDto(): TransactionCreationDto
    {
        return new TransactionCreationDto(
            $this->getAmount(),
            Uuid::fromString($this->getContractorId())
        );
    }
}
