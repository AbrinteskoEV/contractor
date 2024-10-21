<?php

namespace Tests\Api\Transaction;

class TransactionsFindByContractorNameStartsWithATest extends AbstractTransactionTestCase
{
    protected const METHOD = 'GET';
    protected const URI = '/v1/transaction/findByContractorNameStartsWithA';

    public function testPositive(): void
    {
        $expectedTransactionCount = $this->preparePositiveTestEnvironment();
        $response = $this->positiveRequest(self::METHOD, self::URI);

        self::assertIsArray($response);
        $this->assertTransactionListFormat($response);

        self::assertEquals($expectedTransactionCount, count($response['transactions']));
    }

    protected function preparePositiveTestEnvironment(): int
    {
        $suitableContractor = $this->createContractor(['firstName' => 'A' . $this->faker->firstName()]);
        $unsuitableContractor = $this->createContractor(['firstName' => 'F' . $this->faker->firstName()]);

        for ($i = 0; $i < random_int(4, 5); $i++) {
            $this->createTransaction(['contractor' => $unsuitableContractor]);
        }

        $expectedTransactionCount = random_int(2, 3);
        for ($i = 0; $i < $expectedTransactionCount; $i++) {
            $this->createTransaction(['contractor' => $suitableContractor]);
        }

        return $expectedTransactionCount;
    }
}
