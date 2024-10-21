<?php

namespace Tests\Api;

use Tests\AbstractTestCase;

abstract class AbstractApiTestCase extends AbstractTestCase
{
    protected function positiveRequest(string $method, string $uri, array $parameters = [])
    {
        $this->call($method, $uri, $parameters);

        $responseContent = $this->assertResponse();
        self::assertTrue($responseContent['success']);

        return $responseContent['data'];
    }

    protected function negativeRequest(string $method, string $uri, array $parameters = [])
    {
        $this->call($method, $uri, $parameters);

        $responseContent = $this->assertResponse();
        self::assertFalse($responseContent['success']);

        return $responseContent['data'];
    }

    protected function assertResponse(): array
    {
        self::assertFalse(
            $this->response->isServerError(),
            "Server error:\n{$this->response->getContent()}"
        );
        $this->assertResponseOk();

        $responseContent = json_decode(
            $this->response->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        self::assertNotNull($responseContent, "Response is not a valid JSON");
        self::assertIsArray($responseContent, "Somehow decoded JSON is not an array");
        $responseAttributeList = [
            'success',
            'code',
            'time',
            'executionTime',
            'data'
        ];

        foreach ($responseAttributeList as $attribute) {
            self::assertArrayHasKey(
                $attribute,
                $responseContent,
                "Missing '$attribute' attribute in response format"
            );
        }

        return $responseContent;
    }

    protected function assertValidationException(): void
    {
        $responseContent = json_decode(
            $this->response->content(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        self::assertEquals($responseContent['data']['message'], 'Validation exception');
    }
}
