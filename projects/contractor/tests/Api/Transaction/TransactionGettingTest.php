<?php

namespace Tests\Api\Transaction;

class TransactionGettingTest extends AbstractTransactionTestCase
{
    protected const METHOD = 'GET';
    protected const URI = '/v1/transaction';

    public function testPositive(): void
    {
        $transactionModel = $this->createTransaction();
        $response = $this->positiveRequest(self::METHOD, self::URI, ['id' => $transactionModel->getId()]);

        self::assertIsArray($response);
        $this->assertTransactionFormat($response);
    }

    public function testNegative(): void
    {
        $this->negativeRequest(self::METHOD, self::URI, []);

        $this->assertValidationException();
    }

    public function testNotFound(): void
    {
        $this->negativeRequest(self::METHOD, self::URI, ['id' => $this->faker->uuid]);
    }
}
