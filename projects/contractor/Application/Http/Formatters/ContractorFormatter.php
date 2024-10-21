<?php

namespace Application\Http\Formatters;

use Application\Models\ContractorModel;

class ContractorFormatter
{
    public function format(ContractorModel $contractorModel): array
    {
        return [
            'id' => $contractorModel->getId(),
            'firstName' => $contractorModel->getFirstName(),
            'middleName' => $contractorModel->getMiddleName(),
            'lastName' => $contractorModel->getLastName(),
            'birthDate' => (new \DateTime($contractorModel->getBirthDate()))->format('Y-m-d'),
        ];
    }
}
