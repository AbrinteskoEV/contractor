<?php

namespace Application\Http\Requests;

interface RequestRulesInterface
{
    /**
     * @return array
     */
    public function rules(): array;
}
