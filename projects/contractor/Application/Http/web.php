<?php

declare(strict_types=1);

/** @var Router $router */

use Application\Http\Controllers\ContractorController;
use Application\Http\Controllers\TransactionController;
use Laravel\Lumen\Routing\Router;

$router->get('', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->group(['prefix' => 'contractor'], function () use ($router) {
        $router->post('create', ContractorController::class . '@create');
        $router->post('update', ContractorController::class . '@update');
        $router->post('delete', ContractorController::class . '@delete');
        $router->get('', ContractorController::class . '@get');
    });
    $router->group(['prefix' => 'transaction'], function () use ($router) {
        $router->post('create', TransactionController::class . '@create');
        $router->post('update', TransactionController::class . '@update');
        $router->post('delete', TransactionController::class . '@delete');
        $router->get('', TransactionController::class . '@get');
        $router->get('findByContractorNameStartsWithA', TransactionController::class . '@findByContractorNameStartsWithA');
        $router->get('findLowerPriceTransactionsByMonth', TransactionController::class . '@findLowerPriceTransactionsByMonth');
    });
});
