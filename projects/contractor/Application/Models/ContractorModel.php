<?php

namespace Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 * @property string $birth_date
 */
class ContractorModel extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'public.contractor';

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
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $firstName
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->first_name = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $lastName
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->last_name = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birth_date;
    }

    /**
     * @param string $birthDate
     * @return self
     */
    public function setBirthDate(string $birthDate): self
    {
        $this->birth_date = $birthDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    /**
     * @param string|null $middleName
     * @return self
     */
    public function setMiddleName(?string $middleName): self
    {
        $this->middle_name = $middleName;
        return $this;
    }
}
