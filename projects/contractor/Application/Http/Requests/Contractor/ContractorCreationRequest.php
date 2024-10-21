<?php

namespace Application\Http\Requests\Contractor;

use Application\Dto\Contractor\ContractorCreationDto;
use Application\Http\Requests\BaseRequest;

class ContractorCreationRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'middleName' => 'string|nullable',
            'birthDate' => 'required|date'
        ];
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->post('firstName');
    }

    /**
     * @return string
     */
    public function getLastName(): string
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
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->post('birthDate');
    }

    public function getCreationDto(): ContractorCreationDto
    {
        $creationDto = new ContractorCreationDto(
            $this->getFirstName(),
            $this->getLastName(),
            new \DateTime($this->getBirthDate())
        );

        if ($this->getMiddleName()) {
            $creationDto->setMiddleName($this->getMiddleName());
        }

        return $creationDto;
    }
}
