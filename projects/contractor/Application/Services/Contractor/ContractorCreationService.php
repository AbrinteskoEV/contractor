<?php

namespace Application\Services\Contractor;

use Application\Dto\Contractor\ContractorCreationDto;
use Application\Models\ContractorModel;

class ContractorCreationService
{
    /**
     * @param ContractorCreationDto $creationDto
     *
     * @return ContractorModel
     */
    public function create(ContractorCreationDto $creationDto): ContractorModel
    {
        $contractorModel = new ContractorModel();
        $contractorModel->setFirstName($creationDto->getFirstName())
            ->setLastName($creationDto->getLastName())
            ->setBirthDate($creationDto->getBirthDate()->format('Y-m-d'));

        if ($creationDto->getMiddleName()) {
            $contractorModel->setMiddleName($creationDto->getMiddleName());
        }

        if (!$contractorModel->save()) {
            throw new \RuntimeException('Contractor was not created');
        }

        return $contractorModel;
    }

}
