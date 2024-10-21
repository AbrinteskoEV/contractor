<?php

namespace Application\Repositories;

use Application\Models\TransactionModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @method null|TransactionModel findOneBy(array $criteria)
 * @method Collection<TransactionModel> findBy(array $criteria)
 * @method TransactionModel getOneBy(array $criteria)
 */
class TransactionRepository
{
    use RepositoryTrait;

    private const LATIN_LETTER_A = 'A';
    private const CYRILLIC_LETTER_A = 'А';
    private const LOWER_PRICE_MULTIPLIER = 0.8;

    public function findByContractorNameStartsWithA(): Collection
    {
        return $this->getModelQueryBuilder()
            ->select('transaction.*')
            ->join('contractor', function($join) {
                $join->on(
                    'transaction.contractor_id',
                    '=',
                    'contractor.id'
                );
                $join->on(function($query) {
                    $cyrillicLikeQuery = self::CYRILLIC_LETTER_A . '%';
                    $query->on(
                        'contractor.first_name',
                        'LIKE',
                        DB::raw("'$cyrillicLikeQuery'")
                    );
                    $latinLikeQuery = self::LATIN_LETTER_A . '%';
                    $query->orOn(
                        'contractor.first_name',
                        'LIKE',
                        DB::raw("'$latinLikeQuery'")
                    );
                });
            })
            ->get();
    }

    public function findLowerPriceTransactionsByMonth(): Collection
    {
        $startMonthDateTime = (new \DateTime('first day of this month 00:00:00'))->format(DATE_ATOM);
        $currentMonthTransactionQuery = $this->getModelQueryBuilder()
            ->where('created_at', '>=', $startMonthDateTime);

        $maxAmount = $currentMonthTransactionQuery
            ->selectRaw('MAX(amount) as max_amount')
            ->get()
            ->first
            ->toArray()['max_amount'] ?? null;

        if (!$maxAmount) {
            return new Collection();
        }

        $lowerAmount = $maxAmount * self::LOWER_PRICE_MULTIPLIER;

        return $currentMonthTransactionQuery->select('transaction.*')
            ->where('amount', '<=', $lowerAmount)
            ->get();
    }

    private function getModelQueryBuilder(): Builder
    {
        return TransactionModel::query();
    }
}
