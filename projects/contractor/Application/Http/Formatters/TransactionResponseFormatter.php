<?php

namespace Application\Http\Formatters;

use Application\Models\TransactionModel;
use Illuminate\Database\Eloquent\Collection;

class TransactionResponseFormatter
{
    public function format(TransactionModel $transactionModel): array
    {
        return [
            'id' => $transactionModel->getId(),
            'amount' => $transactionModel->getAmount(),
            'contractorId' => $transactionModel->getContractorId(),
        ];
    }

    /**
     * @param Collection<TransactionModel> $collection
     *
     * @return array
     */
    public function formatCollection(Collection $collection): array
    {
        $formattedCollection = [];

        foreach ($collection as $transaction) {
            $formattedCollection[] = $this->format($transaction);
        }

        return ['transactions' => $formattedCollection];
    }
}
