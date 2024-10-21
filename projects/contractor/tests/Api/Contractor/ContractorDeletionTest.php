<?php

namespace Tests\Api\Contractor;

class ContractorDeletionTest extends AbstractContractorTestCase
{
    protected const METHOD = 'POST';
    protected const URI = '/v1/contractor/delete';

    public function testPositive(): void
    {
        $contractorModel = $this->createContractor();
        $response = $this->positiveRequest(self::METHOD, self::URI, ['id' => $contractorModel->getId()]);

        self::assertIsArray($response);
        self::assertArrayHasKey('isDeleted', $response);
        self::assertTrue($response['isDeleted']);

        $this->notSeeInDatabase(self::CONTRACTOR_TABLE_NAME, [
            'id' => $contractorModel->getId(),
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
