<?php
/**
 * Class service
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Services;

use App\Models\Transaction;
use App\Models\Authorization;
use App\Repository\AuthorizationRepository;
use App\Services\AuthorizationProvider\AuthorizationProviderInterface;

/**
 * Classe AuthorizationService
 * @package App\Services
 */
class AuthorizationService
{
    /**
     * Authorization provider
     * @var AuthorizationProviderInterface
     */
    private $authorizationProvider;

    /**
     * Authorization repository
     * @var AuthorizationRepository
     */
    private $authorizationRepository;

    /**
     * Method construct
     * @param AuthorizationProviderInterface $authorizationProvider   Authorization provider
     * @param AuthorizationRepository        $authorizationRepository Authorization repository
     */
    public function __construct(
        AuthorizationProviderInterface $authorizationProvider,
        AuthorizationRepository $authorizationRepository
    ) {
        $this->authorizationProvider = $authorizationProvider;
        $this->authorizationRepository = $authorizationRepository;
    }

    /**
     * Check authorization to transaction
     * @param  Transaction $transaction Transaction
     * @return Authorization
     */
    public function checkAuthorization(Transaction $transaction) : Authorization
    {
        $result = $this->authorizationProvider->checkAuthorization($transaction);

        return new Authorization($result);
    }

    /**
     * Persist authorization
     * @param  Authorization $authorization Authorization transaction
     * @return bool
     */
    public function saveAuthorization(Authorization $authorization) : bool
    {
        return $this->authorizationRepository->save($authorization);
    }
}
