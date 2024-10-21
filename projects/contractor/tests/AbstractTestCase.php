<?php

namespace Tests;

use Application\Models\ContractorModel;
use Application\Models\TransactionModel;
use Carbon\Carbon;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Facades\Artisan;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase;
use Ramsey\Uuid\Uuid;

abstract class AbstractTestCase extends TestCase
{
    protected const TESTING_DATABASE = 'contractor_testing';
    /**
     * @var Generator
     */
    protected Generator $faker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->faker = Factory::create('ru_RU');
    }

    protected function createContractor(array $params = []): ContractorModel
    {
        $contractorModel = new ContractorModel();

        if (isset($params['firstName'])) {
            $contractorModel->setFirstName($params['firstName']);
        } else {
            $contractorModel->setFirstName($this->faker->firstName);
        }

        $contractorModel
            ->setMiddleName($this->faker->word)
            ->setLastName($this->faker->lastName)
            ->setBirthDate($this->faker->date);
        $contractorModel->save();

        return $contractorModel;
    }

    protected function createTransaction(array $params = []): TransactionModel
    {
        if (isset($params['contractor']) && $params['contractor'] instanceof ContractorModel) {
            $contractorModel = $params['contractor'];
        } else {
            $contractorModel = $this->createContractor();
        }

        $transactionModel = new TransactionModel();

        if (isset($params['amount'])) {
            $transactionModel->setAmount($params['amount']);
        } else {
            $transactionModel->setAmount($this->faker->randomFloat());
        }

        if (isset($params['createdAt'])) {
            $transactionModel->setCreatedAt($params['createdAt']);
        }

        $transactionModel->setContractorId($contractorModel->getId());

        $transactionModel->save();

        return $transactionModel;
    }

    /**
     * Creates the application.
     *
     * @return Application
     * @throws Exception
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        static::recreateDatabase();

        return $app;
    }

    /**
     * Пересоздать БД для тестирования (Удалить, накатить миграции и засидить)
     * @throws Exception
     */
    protected static function recreateDatabase(): void
    {
        if (!app()->environment('testing')) {
            return;
        }

        if ((string) config('database.default') !== self::TESTING_DATABASE) {
            return;
        }

        Artisan::call('migrate:fresh', ['--database' => self::TESTING_DATABASE]);
    }

    protected static function assertIsUuid($value, string $message = ''): void
    {
        self::assertIsString($value);
        self::assertTrue(Uuid::isValid($value), $message);
    }

    protected static function assertIsNullableString($value, string $message = ''): void
    {
        self::assertTrue(is_null($value) || is_string($value), $message);
    }

    protected static function assertDateFormat($value, string $format)
    {
        self::assertIsString($value);
        self::assertTrue(Carbon::hasFormat($value, $format));
    }
}
