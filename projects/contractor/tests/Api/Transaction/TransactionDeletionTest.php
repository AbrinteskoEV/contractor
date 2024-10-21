<?php

namespace Tests\Api\Transaction;

class TransactionDeletionTest extends AbstractTransactionTestCase
{
    protected const METHOD = 'POST';
    protected const URI = '/v1/transaction/delete';

    public function testPositive(): void
    {
        $transactionModel = $this->createTransaction();
        $response = $this->positiveRequest(self::METHOD, self::URI, ['id' => $transactionModel->getId()]);

        self::assertIsArray($response);
        self::assertArrayHasKey('isDeleted', $response);
        self::assertTrue($response['isDeleted']);

        $this->notSeeInDatabase(self::TRANSACTION_TABLE_NAME, [
            'id' => $transactionModel->getId(),
            'deleted_at' => null,
        ]);

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
