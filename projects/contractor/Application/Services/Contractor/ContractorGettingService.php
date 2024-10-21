<?php

namespace Application\Services\Contractor;

use Application\Exceptions\ApplicationException;
use Application\Exceptions\EntityNotFoundException;
use Application\Models\ContractorModel;
use Application\Repositories\ContractorRepository;
use Ramsey\Uuid\UuidInterface;

class ContractorGettingService
{
    private ContractorRepository $contractorRepository;

    public function __construct(ContractorRepository $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }

    /**
     * @param UuidInterface $id
     *
     * @return ContractorModel
     *
     * @throws ApplicationException
     */
    public function getById(UuidInterface $id): ContractorModel
    {
        try {
            return $this->contractorRepository->getOneBy(['id' => $id->toString()]);
        } catch (EntityNotFoundException) {
            throw new ApplicationException("Контрагент не найден", ['id' => $id->toString()]);
        }
    }
}
