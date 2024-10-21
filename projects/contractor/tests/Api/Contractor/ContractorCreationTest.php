<?php

namespace Tests\Api\Contractor;

class ContractorCreationTest extends AbstractContractorTestCase
{
    protected const METHOD = 'POST';
    protected const URI = '/v1/contractor/create';

    public function testPositive(): void
    {
        $requestParams = $this->getRequestParams();
        $response = $this->positiveRequest(self::METHOD, self::URI, $requestParams);

        self::assertIsArray($response);
        $this->assertContractorFormat($response);

        foreach ($requestParams as $key => $value) {
            self::assertEquals($value, $response[$key]);
        }
    }

    public function testNegative(): void
    {
        $requestParams = $this->getRequestParams();
        unset($requestParams['firstName']);

        $this->negativeRequest(self::METHOD, self::URI, $requestParams);

        $this->assertValidationException();
    }

    protected function getRequestParams(): array
    {
        return [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'middleName' => $this->faker->word,
            'birthDate' => $this->faker->date,
        ];
    }
}
