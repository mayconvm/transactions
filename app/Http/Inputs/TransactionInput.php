<?php

namespace App\Http\Inputs;

use Validator;
use Illuminate\Validation\Validator as Validate;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransactionInput extends Request
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
        // die(var_dump( app()));
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
            'value' => 'required:float',
            'payer' => 'required|int',
            'payee' => 'required|int',
        ];
    }
}
