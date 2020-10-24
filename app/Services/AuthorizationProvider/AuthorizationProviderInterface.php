<?php

namespace App\Services\AuthorizationProvider;

use App\Models\Transaction;

interface AuthorizationProviderInterface
{
    public function __construct (array $settings);
    public function checkAuthorization(Transaction $transaction) : array;
}
