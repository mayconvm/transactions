<?php

namespace App\Services\AuthorizationProvider\Http;

use App\Services\AuthorizationProvider\AuthorizationProviderInterface;
use App\Models\Transaction;

class AuthorizationProviderHttp implements AuthorizationProviderInterface
{
    private $settings;

    public function __construct (array $settings)
    {
        $this->settings = $settings;
    }

    public function checkAuthorization(Transaction $transaction) : array
    {
        $result = json_decode($this->sendRequest($transaction), true);

        if (empty($result)) {
            return [];
        }

        return $result;
    }

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
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->prepareData($transaction));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    protected function prepareData(Transaction $transaction) : array
    {
        return [
            'value' => $transaction->getValue(),
            'payer' => $transaction->getPayer(),
            'payee' => $transaction->getPayee(),
        ];
    }

    protected function getUrl() : ?string
    {
        if (isset($this->settings['url_authorization_transaction'])) {
            return $this->settings['url_authorization_transaction'];
        }

        return null;
    }
}
