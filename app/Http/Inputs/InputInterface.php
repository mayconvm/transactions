<?php
/**
 * Classe Input
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Http\Inputs;

use Illuminate\Validation\Validator;

/**
 * Classe InputInterface
 * @package App\Http\Controllers\Inputs
 */
interface InputInterface
{
    /**
     * Create validator to data request
     * @return Validator
     */
    public function validator() : Validator;

    /**
     * Check if all input send
     * @return bool
     */
    public function requiredInputValid() : bool;

    /**
     * Get erros validation input
     * @return array
     */
    public function getErros() : array;

    /**
     * Get rules to validation
     * @return array
     */
    public function rules() : array;
}
