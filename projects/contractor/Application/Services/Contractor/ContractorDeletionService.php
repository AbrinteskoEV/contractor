<?php

namespace Application\Services\Contractor;

use Application\Repositories\ContractorRepository;
use Ramsey\Uuid\UuidInterface;

class ContractorDeletionService
{
    private ContractorRepository $contractorRepository;

    public function __construct(ContractorRepository $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }

    public function delete(UuidInterface $id): bool
    {
        $contractorModel = $this->contractorRepository->getOneBy(['id' => $id->toString()]);
        $contractorModel->delete();

        if (!$contractorModel->save()) {
            throw new \RuntimeException('Contractor was not deleted');
        }

        return true;
    }
}
