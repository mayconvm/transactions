<?php
/**
 * interface Authorization Provider
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Services\AuthorizationProvider;

use App\Models\Transaction;
use App\Providers\Http\AdapterProviderInterface;

/**
 * Classe AuthorizationProviderInterface
 * @package App\Services\AuthorizationProvider
 */
interface AuthorizationProviderInterface
{
    /**
     * Method construct
     * @param AdapterProvider $adapter Adapter to connection
     */
    public function __construct (AdapterProviderInterface $adapter);

    /**
     * Check authorization
     * @param  Transaction $transaction Transaction
     * @return Array
     */
    public function checkAuthorization(Transaction $transaction) : array;

    /**
     * Get settings
     * @param  string $key Key to settings
     * @return mixed
     */
    public function getSettings(string $key);

    /**
     * Settings configuration
     * @param array $settings Settings
     */
    public function setSettings(array $settings) : void;
}
