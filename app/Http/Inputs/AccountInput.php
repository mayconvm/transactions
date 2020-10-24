<?php
/**
 * Classe Input
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Http\Inputs;

/**
 * Classe AccountInput
 * @package App\Http\Controllers\Inputs
 */
class AccountInput extends InputAbstract
{
    /**
     * Get rules to validation
     * @return array
     */
    public function rules() : array
    {
        return [
            'name' => 'required',
            'document' => 'required|unique:accounts',
            'email' => 'required|unique:accounts',
        ];
    }
}
