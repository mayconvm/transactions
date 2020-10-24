<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Account;
use App\Repository\WalletRepository;
use App\Business\WalletBusiness;

class WalletService
{
    private $walletRepository;

    public function __construct(
        WalletRepository $walletRepository,
        WalletBusiness $walletBusiness
    ) {
        $this->walletRepository = $walletRepository;
        $this->walletBusiness = $walletBusiness;
    }

    public function createWallet(Account $account) : Wallet
    {
        // TODO: use already wallet

        $wallet = $this->walletBusiness->create($account, new Wallet());

        if (!$this->save($wallet)) {
            throw new \Exception("Not possible salve wallet", 1);
        }

        return $wallet;
    }

    public function updateAmountToWallets(Transaction $transaction) : void
    {
        // validate
        if (!$transaction->getStatus()) {
            return;
        }

        $valueTransaction = $transaction->getValue();
        switch ($transaction->getType()) {
            case Transaction::TYPE_CREDIT:
                $valueToPayer = $valueTransaction * -1;
                $valueToPayee = $valueTransaction;
                break;

            case Transaction::TYPE_REVERT:
                $valueToPayer = $valueTransaction;
                $valueToPayee = $valueTransaction * -1;
                break;
        }

        $this->setAmoutToWalletByType(
            $transaction->getWalletPayer(),
            $valueToPayer
        );

        $this->setAmoutToWalletByType(
            $transaction->getWalletPayee(),
            $valueToPayee
        );
    }

    protected function setAmoutToWalletByType(Wallet $wallet, float $value)
    {
        $wallet->updateAmout($value);

        if (!$this->save($wallet)) {
            throw new \Exception("Not possible update wallet", 1);
        }
    }

    public function getAccountWallet(Account $account) : Wallet
    {
        return $this->walletRepository->getWalletByAccountId(
            $account->getId()
        );
    }

    protected function save(Wallet $entity)
    {
        return $entity->save();
    }
}
