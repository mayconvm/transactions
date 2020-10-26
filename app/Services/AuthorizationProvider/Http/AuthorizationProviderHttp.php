<?php
/**
 * Classe Authorization Provider
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Services\AuthorizationProvider\Http;

use App\Services\AuthorizationProvider\AuthorizationProviderInterface;
use App\Models\Transaction;

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
     * Method construct
     * @param array $settings Array with settings
     */
    public function __construct (array $settings)
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
        $result = json_decode($this->sendRequest($transaction), true);

        if (empty($result)) {
            return [];
        }

        return [];
    }

    /**
     * Send request
     * @param  Transaction $transaction Transaction
     * @return string
     */
    protected function sendRequest(Transaction $transaction) : string
    {
        if (!($url = $this->getUrl())) {
            return null;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->prepareData($transaction));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
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
     * Get url to service
     * @return string
     */
    protected function getUrl() : ?string
    {
        if (isset($this->settings['url_authorization_transaction'])) {
            return $this->settings['url_authorization_transaction'];
        }

        return null;
    }
}
