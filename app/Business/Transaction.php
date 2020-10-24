<?php
/**
 * Classe Business
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Business;

use App\Business\Model\AccountInterface;
use App\Business\Model\TransactionInterface;
use App\Business\Model\AuthorizationInterface;

/**
 * Classe Transaction
 * @package App\Business
 */
class Transaction
{
    /**
     * Transaction
     * @var TransactionInterface
     */
    private $transaction;

    /**
     * Execute Transaction
     * @param  TransactionInterface $transaction Transaction
     * @return TransactionInterface
     */
    public function execute(TransactionInterface $transaction) : TransactionInterface
    {
        if (!$transaction->getStatus()) {
            return $transaction;
        }

        return $transaction;
    }

    /**
     * Validate availability to transaction
     * @param  TransactionInterface $transaction Transaction
     * @return bool
     */
    public function validateAvailability(TransactionInterface $transaction) : bool
    {
        $payer = $transaction->getWalletPayer();
        $payee = $transaction->getWalletPayee();

        if (!$this->checkAllowTypeAccount($transaction)) {
            return false;
        }

        if (!$this->checkAmoutAvailable($transaction)) {
            return false;
        }

        return true;
    }

    /**
     * Validate Authorization
     * @param  AuthorizationInterface $authorization Authorization
     * @return bool
     */
    public function validateAuthorization(AuthorizationInterface $authorization) : bool
    {
        return $authorization->allow();
    }

    /**
     * Check if amout available
     * @param  TransactionInterface $transaction Transaction
     * @return bool
     */
    protected function checkAmoutAvailable(TransactionInterface $transaction) : bool
    {
        $payer = $transaction->getWalletPayer();
        return $payer->getAmount() > $transaction->getValue();
    }

    /**
     * Check type account is allow to transaction
     * @param  TransactionInterface $transaction Transaction
     * @return bool
     */
    protected function checkAllowTypeAccount(TransactionInterface $transaction) : bool
    {
        $account = $transaction
            ->getWalletPayer()
            ->getAccount()
        ;

        return $account->getType() !== Account::TYPE_BUSINESS;
    }


    public function retrieve()
    {
    }
}
