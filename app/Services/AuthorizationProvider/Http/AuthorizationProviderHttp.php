<?php
/**
 * Classe Authorization Provider
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Services\AuthorizationProvider\Http;

use App\Models\Transaction;
use App\Providers\Http\AdapterProviderInterface;
use App\Services\AuthorizationProvider\AuthorizationProviderInterface;

/**
 * Classe AuthorizationProviderHttp
 * @package App\Services\AuthorizationProvider\Http
 */
class AuthorizationProviderHttp implements AuthorizationProviderInterface
{
    /**
     * Array with settings to connection
     * @var array
     */
    private $settings;

    /**
     * Adapter
     * @var AdapterProviderInterface
     */
    private $adapter;

    /**
     * Method construct
     * @param AdapterProviderInterface $adapter Adapter to connection
     */
    public function __construct (AdapterProviderInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Settings configuration
     * @param array $settings Settings
     */
    public function setSettings(array $settings) : void
    {
        $this->settings = $settings;
    }

    /**
     * Check authorization
     * @param  Transaction $transaction Transaction
     * @return Array
     */
    public function checkAuthorization(Transaction $transaction) : array
    {
        $data = $this->prepareData($transaction);
        $result = $this->adapter->send($data);

        if (empty($result)) {
            return [];
        }

        return [];
    }

    /**
     * Prepare data to request
     * @param  Transaction $transaction Transaction
     * @return array
     */
    protected function prepareData(Transaction $transaction) : array
    {
        return [
            'value' => $transaction->getValue(),
        ];
    }

    /**
     * Get settings
     * @param  string $key Key to settings
     * @return mixed
     */
    public function getSettings(string $key)
    {
        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        }

        return null;
    }
}
