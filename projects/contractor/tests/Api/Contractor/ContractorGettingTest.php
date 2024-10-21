<?php

namespace Tests\Api\Contractor;

class ContractorGettingTest extends AbstractContractorTestCase
{
    protected const METHOD = 'GET';
    protected const URI = '/v1/contractor';

    public function testPositive(): void
    {
        $contractorModel = $this->createContractor();
        $response = $this->positiveRequest(self::METHOD, self::URI, ['id' => $contractorModel->getId()]);

        self::assertIsArray($response);
        $this->assertContractorFormat($response);
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
