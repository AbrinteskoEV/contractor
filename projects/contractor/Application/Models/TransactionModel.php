<?php

namespace Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property float $amount
 * @property string $contractor_id
 */
class TransactionModel extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'public.transaction';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return self
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getContractorId(): string
    {
        return $this->contractor_id;
    }

    /**
     * @param string $contractor_id
     * @return self
     */
    public function setContractorId(string $contractor_id): self
    {
        $this->contractor_id = $contractor_id;
        return $this;
    }

    /**
     * @return ContractorModel
     */
    public function getContactor(): ContractorModel
    {
        return $this->hasOne(ContractorModel::class, 'id', 'contractor_id')->get()->first();
    }
}
