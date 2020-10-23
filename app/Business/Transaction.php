<?php

namespace App\Business;

use App\Business\Model\AccountInterface;
use App\Business\Model\TransactionInterface;

class Transaction
{
    private $transaction;

    public function __construct(TransactionInterface $transaction = null)
    {
        $this->transaction = $transaction;
    }

    public function execute(TransactionInterface $transaction) : TransactionInterface
    {
        if (!$transaction->getStatus()) {
            return $transaction;
        }

        return $transaction;
    }

    public function validateAvailability(TransactionInterface $transaction) : bool
    {
        $payer = $transaction->getWalletPayer();
        $payee = $transaction->getWalletPayee();

        if ($this->checkTypeAccount($transaction)) {
            return false;
        }

        if (!$this->checkAmoutAvailable($transaction)) {
            return false;
        }

        return true;
    }

    protected function checkAmoutAvailable(TransactionInterface $transaction)
    {
        $payer = $transaction->getWalletPayer();
        return $payer->getAmount() > $transaction->getValue();
    }

    protected function checkTypeAccount(TransactionInterface $transaction)
    {
        $account = $transaction
            ->getWalletPayer()
            ->getAccount()
        ;

        return $account->getType() == AccountInterface::TYPE_BUSINESS;
    }

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function retrieve()
    {
    }
}
