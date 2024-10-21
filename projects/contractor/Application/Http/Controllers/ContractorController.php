<?php

namespace Application\Http\Controllers;

use Application\Http\Formatters\ContractorFormatter;
use Application\Http\Requests\ByIdRequest;
use Application\Http\Requests\Contractor\ContractorCreationRequest;
use Application\Http\Requests\Contractor\ContractorUpdatingRequest;
use Application\Services\Contractor\ContractorCreationService;
use Application\Services\Contractor\ContractorDeletionService;
use Application\Services\Contractor\ContractorGettingService;
use Application\Services\Contractor\ContractorUpdatingService;

class ContractorController
{
    public function create(
        ContractorCreationRequest $request,
        ContractorCreationService $creationService,
        ContractorFormatter $contractorFormatter
    ): array {
        $contractorModel = $creationService->create($request->getCreationDto());

        return $contractorFormatter->format($contractorModel);
    }

    public function get(
        ByIdRequest $request,
        ContractorGettingService $gettingService,
        ContractorFormatter $contractorFormatter
    ): array {
        $contractorModel = $gettingService->getById($request->getId());

        return $contractorFormatter->format($contractorModel);
    }

    public function update(
        ContractorUpdatingRequest $request,
        ContractorUpdatingService $updatingService,
        ContractorFormatter $contractorFormatter
    ): array {
        $contractorModel = $updatingService->update($request->getUpdatingDto());

        return $contractorFormatter->format($contractorModel);
    }

    public function delete(
        ByIdRequest $request,
        ContractorDeletionService $deletionService
    ): array {
        $isDeleted = $deletionService->delete($request->getId());

        return ['isDeleted' => $isDeleted];
    }
}
