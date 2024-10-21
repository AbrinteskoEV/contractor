<?php

namespace Application\Repositories;

use Application\Exceptions\EntityNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait RepositoryTrait
{
    /**
     * @param array $criteria
     *
     * @return Model
     *
     * @throws EntityNotFoundException
     */
    public function getOneBy(array $criteria): Model
    {
        $model = $this->findOneBy($criteria);

        if (!$model instanceof Model) {
            throw new EntityNotFoundException('Entity was not found exception.');
        }

        return $model;
    }

    /**
     * @param array $criteria
     *
     * @return Model|null
     */
    public function findOneBy(array $criteria): ?Model
    {
        return $this->findBy($criteria)?->first();
    }

    /**
     * @param array $criteria
     *
     * @return Collection
     */
    public function findBy(array $criteria): Collection
    {
        $queryBuilder = $this->getModelQueryBuilder();

        foreach ($criteria as $attribute => $value) {
            if (is_array($value)) {
                $queryBuilder->whereIn($attribute, $value);
            } else {
                $queryBuilder->where($attribute, $value);
            }
        }

        return $queryBuilder->get();
    }

    /**
     * @return Builder
     */
    private function getModelQueryBuilder(): Builder
    {
        return Model::query();
    }
}
