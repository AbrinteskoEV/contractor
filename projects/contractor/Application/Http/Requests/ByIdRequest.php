<?php

namespace Application\Http\Requests;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ByIdRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|uuid',
        ];
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return Uuid::fromString($this->input('id'));
    }

}
