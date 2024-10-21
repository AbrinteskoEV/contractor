<?php

namespace Application\Services\Contractor;

use Application\Dto\Contractor\ContractorUpdatingDto;
use Application\Exceptions\ApplicationException;
use Application\Models\ContractorModel;

class ContractorUpdatingService
{
    private ContractorGettingService $contractorGettingService;

    public function __construct(ContractorGettingService $contractorGettingService)
    {
        $this->contractorGettingService = $contractorGettingService;
    }

    /**
     * @param ContractorUpdatingDto $updatingDto
     *
     * @return ContractorModel
     *
     * @throws ApplicationException
     */
    public function update(ContractorUpdatingDto $updatingDto): ContractorModel
    {
        $contractorModel = $this->contractorGettingService->getById($updatingDto->getId());

        if ($updatingDto->getFirstName()) {
            $contractorModel->setFirstName($updatingDto->getFirstName());
        }

        if ($updatingDto->getLastName()) {
            $contractorModel->setLastName($updatingDto->getLastName());
        }

        if ($updatingDto->getBirthDate()) {
            $contractorModel->setBirthDate($updatingDto->getBirthDate()->format('Y-m-d'));
        }

        $contractorModel->setMiddleName($updatingDto->getMiddleName());

        if (!$contractorModel->save()) {
            throw new \RuntimeException('Contractor was not updated');
        }

        return $contractorModel;
    }

}
