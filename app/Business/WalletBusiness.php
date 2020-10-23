<?php

namespace App\Business;

use App\Business\Model\AccountInterface;
use App\Business\Model\WalletInterface;

class WalletBusiness
{
    public function create(AccountInterface $account, WalletInterface $wallet) : WalletInterface
    {
        $wallet->setAccountId($account->getId());
        $wallet->setAmount(0);
        $wallet->setStatus(true);

        return $wallet;
    }

    public function update(AccountInterface $entity) : WalletInterface
    {
    }
}
