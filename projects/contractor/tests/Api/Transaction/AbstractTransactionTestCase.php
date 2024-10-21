<?php

namespace Tests\Api\Transaction;

use Application\Models\ContractorModel;
use Application\Models\TransactionModel;
use Tests\Api\AbstractApiTestCase;

class AbstractTransactionTestCase extends AbstractApiTestCase
{
    protected const TRANSACTION_TABLE_NAME = 'transaction';

    protected function assertTransactionFormat(array $response): void
    {
        $attributeList = [
            'id',
            'amount',
            'contractorId',
        ];

        foreach($attributeList as $attribute) {
            self::assertArrayHasKey($attribute, $response);
        }

        self::assertIsUuid($response['id']);
        self::assertIsNumeric($response['amount']);
        self::assertIsUuid($response['contractorId']);
    }

    protected function assertTransactionListFormat(array $response): void
    {
        self::assertArrayHasKey('transactions', $response);
        $transactionList = $response['transactions'];
        self::assertIsArray($transactionList);

        foreach ($transactionList as $transaction) {
            self::assertIsArray($transaction);
            $this->assertTransactionFormat($transaction);
        }
    }
}
