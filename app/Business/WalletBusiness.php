<?php
/**
 * Classe Business
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Business;

use App\Business\Model\AccountInterface;
use App\Business\Model\WalletInterface;

/**
 * Classe WalletBusiness
 * @package App\Business
 */
class WalletBusiness
{
    /**
     * Create wallet to account
     * @param  AccountInterface $account Account that give new wallet
     * @param  WalletInterface  $wallet  Wallet
     * @return WalletInterface
     */
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
