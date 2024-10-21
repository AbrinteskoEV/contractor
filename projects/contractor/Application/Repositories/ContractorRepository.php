<?php

namespace Application\Repositories;

use Application\Models\ContractorModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method null|ContractorModel findOneBy(array $criteria)
 * @method Collection<ContractorModel> findBy(array $criteria)
 * @method ContractorModel getOneBy(array $criteria)
 */
class ContractorRepository
{
    use RepositoryTrait;

    private function getModelQueryBuilder(): Builder
    {
        return ContractorModel::query();
    }
}
