<?php

namespace Tests\Api\Transaction;

class TransactionCreationTest extends AbstractTransactionTestCase
{
    protected const METHOD = 'POST';
    protected const URI = '/v1/transaction/create';

    public function testPositive(): void
    {
        $requestParams = $this->getRequestParams();
        $response = $this->positiveRequest(self::METHOD, self::URI, $requestParams);

        self::assertIsArray($response);
        $this->assertTransactionFormat($response);

        foreach ($requestParams as $key => $value) {
            self::assertEquals($value, $response[$key]);
        }
    }

    public function testNegative(): void
    {
        $requestParams = $this->getRequestParams();
        unset($requestParams['amount']);

        $this->negativeRequest(self::METHOD, self::URI, $requestParams);

        $this->assertValidationException();
    }

    public function testNotExistContractor(): void
    {
        $requestParams = $this->getRequestParams();
        $requestParams['contractorId'] = $this->faker->uuid;

        $this->negativeRequest(self::METHOD, self::URI, $requestParams);

        $this->assertValidationException();
    }

    protected function getRequestParams(): array
    {
        $contractorModel = $this->createContractor();

        return [
            'amount' => $this->faker->randomFloat(),
            'contractorId' => $contractorModel->getId(),
        ];
    }
}
