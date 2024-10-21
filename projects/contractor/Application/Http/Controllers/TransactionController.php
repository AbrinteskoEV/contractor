<?php

namespace Application\Http\Controllers;

use Application\Http\Formatters\TransactionResponseFormatter;
use Application\Http\Requests\ByIdRequest;
use Application\Http\Requests\Transaction\TransactionCreationRequest;
use Application\Http\Requests\Transaction\TransactionUpdatingRequest;
use Application\Models\TransactionModel;
use Application\Repositories\TransactionRepository;
use Application\Services\Transaction\TransactionCreationService;
use Application\Services\Transaction\TransactionDeletionService;
use Application\Services\Transaction\TransactionGettingService;
use Application\Services\Transaction\TransactionUpdatingService;

class TransactionController
{
    public function findByContractorNameStartsWithA(
        TransactionRepository $transactionRepository,
        TransactionResponseFormatter $transactionFormatter
    ): array {
        $transactionCollection = $transactionRepository->findByContractorNameStartsWithA();

        return $transactionFormatter->formatCollection($transactionCollection);
    }
    public function findLowerPriceTransactionsByMonth(
        TransactionRepository $transactionRepository,
        TransactionResponseFormatter $transactionFormatter
    ): array {
        $transactionCollection = $transactionRepository->findLowerPriceTransactionsByMonth();

        return $transactionFormatter->formatCollection($transactionCollection);
    }

    public function create(
        TransactionCreationRequest $request,
        TransactionCreationService $creationService,
        TransactionResponseFormatter $transactionFormatter
    ): array {
        $contractorModel = $creationService->create($request->getCreationDto());

        return $transactionFormatter->format($contractorModel);
    }

    public function get(
        ByIdRequest $request,
        TransactionGettingService $gettingService,
        TransactionResponseFormatter $transactionFormatter
    ): array {
        $contractorModel = $gettingService->getById($request->getId());

        return $transactionFormatter->format($contractorModel);
    }

    public function update(
        TransactionUpdatingRequest $request,
        TransactionUpdatingService $updatingService,
        TransactionResponseFormatter $transactionFormatter
    ): array {
        $contractorModel = $updatingService->update($request->getUpdatingDto());

        return $transactionFormatter->format($contractorModel);
    }

    public function delete(
        ByIdRequest $request,
        TransactionDeletionService $deletionService
    ): array {
        $isDeleted = $deletionService->delete($request->getId());

        return ['isDeleted' => $isDeleted];
    }
}
