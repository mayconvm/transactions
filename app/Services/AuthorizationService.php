<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Authorization;
use App\Services\AuthorizationProvider\AuthorizationProviderInterface;
use App\Repository\AuthorizationRepository;

class AuthorizationService
{
    public function __construct(
        AuthorizationProviderInterface $authorizationProvider,
        AuthorizationRepository $authorizationRepository
    ) {
        $this->authorizationProvider = $authorizationProvider;
        $this->authorizationRepository = $authorizationRepository;
    }

    public function checkAuthorization(Transaction $transaction) : Authorization
    {
        $result = $this->authorizationProvider->checkAuthorization($transaction);

        return new Authorization($result);
    }

    public function saveAuthorization(Authorization $authorization) : bool
    {
        return $this->authorizationRepository->save($authorization);
    }
}
