<?php
/**
 * Classe Input
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Http\Inputs;

/**
 * Classe TransactionCreditInput
 * @package App\Http\Controllers\Inputs
 */
class TransactionCreditInput extends InputAbstract
{
    /**
     * Get rules to validation
     * @return array
     */
    public function rules() : array
    {
        return [
            'value' => 'required|numeric',
            'payer' => 'required|int',
        ];
    }
}
