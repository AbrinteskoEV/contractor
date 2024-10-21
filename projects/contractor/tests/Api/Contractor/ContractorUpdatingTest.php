<?php

namespace Tests\Api\Contractor;

class ContractorUpdatingTest extends AbstractContractorTestCase
{
    protected const METHOD = 'POST';
    protected const URI = '/v1/contractor/update';

    public function testPositive(): void
    {
        $contractorModel = $this->createContractor();
        $requestParams = $this->getRequestParamsWithoutId();
        $requestParams['id'] = $contractorModel->getId();
        $response = $this->positiveRequest(self::METHOD, self::URI, $requestParams);

        self::assertIsArray($response);
        $this->assertContractorFormat($response);

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
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'middleName' => $this->faker->word,
            'birthDate' => $this->faker->date,
        ];
    }
}
