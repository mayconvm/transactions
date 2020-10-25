<?php
/**
 * Classe Input
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Http\Inputs;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator as Validate;

/**
 * Classe InputAbstract
 * @package App\Http\Controllers\Inputs
 */
class InputAbstract extends Request implements InputInterface
{
    /**
     * Validator
     * @var Validator
     */
    protected $validator;

    /**
     * Create validator to data request
     * @return Validate
     */
    public function validator() : Validate
    {
        $this->validator = Validator::make(
            $this->json()->all(),
            $this->rules()
        );

        return $this->validator;
    }

    /**
     * Check if all input send
     * @return bool
     */
    public function valid() : bool
    {
        if (empty($this->validator)) {
            $this->validator();
        }

        return !$this->validator->fails();
    }

    /**
     * Get erros validation input
     * @return array
     */
    public function getErrors() : array
    {
        return $this->validator
            ->errors()
            ->messages()
        ;
    }

    /**
     * Get rules to validation
     * @return array
     */
    public function rules() : array
    {
        return [];
    }
}
