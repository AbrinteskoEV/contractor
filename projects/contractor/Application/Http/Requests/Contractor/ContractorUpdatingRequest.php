<?php

namespace Application\Http\Requests\Contractor;

use Application\Dto\Contractor\ContractorUpdatingDto;
use Application\Http\Requests\BaseRequest;
use Ramsey\Uuid\Uuid;

class ContractorUpdatingRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|uuid',
            'firstName' => 'string',
            'lastName' => 'string',
            'middleName' => 'string',
            'birthDate' => 'date'
        ];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->post('id');
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->post('firstName');
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->post('lastName');
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->post('middleName');
    }

    /**
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        return $this->post('birthDate');
    }

    public function getUpdatingDto(): ContractorUpdatingDto
    {
        $updatingDto = new ContractorUpdatingDto(Uuid::fromString($this->getId()));

        if ($this->getFirstName()) {
            $updatingDto->setFirstName($this->getFirstName());
        }

        if ($this->getLastName()) {
            $updatingDto->setLastName($this->getLastName());
        }

        if ($this->getBirthDate()) {
            $updatingDto->setBirthDate(new \DateTime($this->getBirthDate()));
        }

        if ($this->getMiddleName()) {
            $updatingDto->setMiddleName($this->getMiddleName());
        }

        return $updatingDto;
    }
}
