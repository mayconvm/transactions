<?php

namespace App\Http\Inputs;

use Validator;
use Illuminate\Validation\Validator as Validate;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AccountInput extends Request
{
    private $validator;

    public function validator() : Validate
    {
        $this->validator = Validator::make(
            $this->json()->all(),
            $this->rules()
        );

        return $this->validator;
    }

    public function requiredInputValid() : bool
    {
        if (empty($this->validator)) {
            $this->validator();
        }

        return $this->validator->fails();
    }

    public function getErros()
    {
        return $this->validator->errors();
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'document' => 'required|unique:accounts',
            'email' => 'required|unique:accounts',
        ];
    }
}
