<?php

namespace Tests\Api\Transaction;

class TransactionUpdatingTest extends AbstractTransactionTestCase
{
    protected const METHOD = 'POST';
    protected const URI = '/v1/transaction/update';

    public function testPositive(): void
    {
        $transactionModel = $this->createTransaction();
        $requestParams = $this->getRequestParamsWithoutId();
        $requestParams['id'] = $transactionModel->getId();
        $response = $this->positiveRequest(self::METHOD, self::URI, $requestParams);

        self::assertIsArray($response);
        $this->assertTransactionFormat($response);

        foreach ($requestParams as $key => $value) {
            self::assertEquals($value, $response[$key]);
        }
    }

    public function testNegative(): void
    {
        $this->negativeRequest(self::METHOD, self::URI, []);

        $this->assertValidationException();
    }

    public function testNotFound(): void
    {
        $requestParams = $this->getRequestParamsWithoutId();
        $requestParams['id'] = $this->faker->uuid;

        $this->negativeRequest(self::METHOD, self::URI, ['id' => $requestParams]);
        $this->assertValidationException();
    }

    protected function getRequestParamsWithoutId(): array
    {
        return [
            'amount' => $this->faker->randomFloat(),
        ];
    }
}
