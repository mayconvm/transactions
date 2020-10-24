<?php
/**
 * interface Authorization Provider
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Services\AuthorizationProvider;

use App\Models\Transaction;

/**
 * Classe AuthorizationProviderInterface
 * @package App\Services\AuthorizationProvider
 */
interface AuthorizationProviderInterface
{
    /**
     * Method construct
     * @param array $settings Array with settings
     */
    public function __construct (array $settings);

    /**
     * Check authorization
     * @param  Transaction $transaction Transaction
     * @return Array
     */
    public function checkAuthorization(Transaction $transaction) : array;
}
