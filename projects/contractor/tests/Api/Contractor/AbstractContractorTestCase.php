<?php

namespace Tests\Api\Contractor;

use Application\Models\ContractorModel;
use Tests\Api\AbstractApiTestCase;

class AbstractContractorTestCase extends AbstractApiTestCase
{
    protected const CONTRACTOR_TABLE_NAME = 'contractor';

    protected function assertContractorFormat(array $response): void
    {
        $attributeList = [
            'id',
            'firstName',
            'middleName',
            'lastName',
            'birthDate',
        ];

        foreach($attributeList as $attribute) {
            self::assertArrayHasKey($attribute, $response);
        }

        self::assertIsUuid($response['id']);
        self::assertIsString($response['firstName']);
        self::assertIsNullableString($response['middleName']);
        self::assertIsString($response['lastName']);
        self::assertDateFormat($response['birthDate'], 'Y-m-d');
    }
}
