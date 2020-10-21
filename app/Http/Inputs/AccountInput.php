<?php

namespace App\Http\Inputs;

use Illuminate\Http\Request;

class AccountInput extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'cpf' => 'required|unique:user',
            'email' => 'required|unique:user',
        ];
    }
}
