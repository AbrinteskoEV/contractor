<?php

namespace Tests\Api\Transaction;

use Application\Models\TransactionModel;

class TransactionsFindLowerPriceTransactionsByMonth extends AbstractTransactionTestCase
{
    protected const METHOD = 'GET';
    protected const URI = '/v1/transaction/findLowerPriceTransactionsByMonth';

    protected const PRICE_DIFFERENCE_THRESHOLD_MULTIPLIER = 0.8;

    public function testPositive(): void
    {
        $expectedTransactionCount = $this->preparePositiveTestEnvironment();
        $response = $this->positiveRequest(self::METHOD, self::URI);

        self::assertIsArray($response);

        $this->assertTransactionListFormat($response);

        self::assertEquals($expectedTransactionCount, count($response['transactions']));
    }

    public function testPositiveWithoutTransactions(): void
    {
        $response = $this->positiveRequest(self::METHOD, self::URI);

        self::assertIsArray($response);

        $this->assertTransactionListFormat($response);

        self::assertEmpty($response['transactions']);
    }

    protected function preparePositiveTestEnvironment(): int
    {
        $expectedTransactionCount = 0;

        $maxPrice = $this->faker->randomFloat();
        $previousMonthDateTime = new \DateTime('last day of previous month');
        $startOfMonthDateTime = new \DateTime('first day of this month');

        $this->createTransactionOverThenMaxAmount($maxPrice, $previousMonthDateTime);
        $this->createTransactionUnsuitableAmount($maxPrice, $previousMonthDateTime);

        $this->createTransactionMaxAmount($maxPrice, $startOfMonthDateTime);
        $this->createTransactionUnsuitableAmount($maxPrice, $startOfMonthDateTime);
        $this->createTransactionSuitableAmount($maxPrice, $startOfMonthDateTime);
        $expectedTransactionCount++;
        $this->createTransactionThresholdAmount($maxPrice, $startOfMonthDateTime);
        $expectedTransactionCount++;

        $this->createTransactionMaxAmount($maxPrice);
        $this->createTransactionUnsuitableAmount($maxPrice);
        $this->createTransactionSuitableAmount($maxPrice);
        $expectedTransactionCount++;
        $this->createTransactionThresholdAmount($maxPrice);
        $expectedTransactionCount++;

        return $expectedTransactionCount;
    }

    protected function createTransactionOverThenMaxAmount(
        float $maxPrice,
        ?\DateTime $createdAt = null
    ): TransactionModel {
        $params = ['amount' => $maxPrice * $this->faker->randomFloat(
            2,
            1.01,
            1 + self::PRICE_DIFFERENCE_THRESHOLD_MULTIPLIER
        )];

        if ($createdAt) {
            $params['createdAt'] = $createdAt;
        }

        return $this->createTransaction($params);
    }

    protected function createTransactionMaxAmount(
        float $maxPrice,
        ?\DateTime $createdAt = null
    ): TransactionModel {
        $params = ['amount' => $maxPrice];

        if ($createdAt) {
            $params['createdAt'] = $createdAt;
        }

        return $this->createTransaction($params);
    }

    protected function createTransactionUnsuitableAmount(
        float $maxPrice,
        ?\DateTime $createdAt = null
    ): TransactionModel {
        $params = ['amount' => $maxPrice * $this->faker->randomFloat(
                2,
                self::PRICE_DIFFERENCE_THRESHOLD_MULTIPLIER,
                1
            )];

        if ($createdAt) {
            $params['createdAt'] = $createdAt;
        }

        return $this->createTransaction($params);
    }

    protected function createTransactionSuitableAmount(
        float $maxPrice,
        ?\DateTime $createdAt = null
    ): TransactionModel {
        $params = ['amount' => $maxPrice * $this->faker->randomFloat(
                2,
                0.1,
                self::PRICE_DIFFERENCE_THRESHOLD_MULTIPLIER - 0.1
            )];

        if ($createdAt) {
            $params['createdAt'] = $createdAt;
        }

        return $this->createTransaction($params);
    }

    protected function createTransactionThresholdAmount(
        float $maxPrice,
        ?\DateTime $createdAt = null
    ): TransactionModel {
        $params = ['amount' => $maxPrice * self::PRICE_DIFFERENCE_THRESHOLD_MULTIPLIER];

        if ($createdAt) {
            $params['createdAt'] = $createdAt;
        }

        return $this->createTransaction($params);
    }
}
