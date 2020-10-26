<?php
/**
 * Class service
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Services;

use App\Models\Wallet;
use App\Models\Account;
use App\Models\Transaction;
use App\Business\Wallet as WalletBusiness;
use App\Business\Transaction as TransactionBusiness;
use App\Repository\WalletRepository;

/**
 * Classe WalletService
 * @package App\Services
 */
class WalletService
{

    /**
     * Wallet repository
     * @var WalletRepository
     */
    private $walletRepository;

    /**
     * Wallet business
     * @var WalletBusiness
     */
    private $walletBusiness;

    /**
     * Method construct
     * @param WalletRepository $walletRepository Wallet repository
     * @param WalletBusiness   $walletBusiness   Wallet business
     */
    public function __construct(
        WalletRepository $walletRepository,
        WalletBusiness $walletBusiness
    ) {
        $this->walletRepository = $walletRepository;
        $this->walletBusiness = $walletBusiness;
    }

    /**
     * Create new wallet
     * @param  Account $account Account entity
     * @return Wallet
     */
    public function createWallet(Account $account) : Wallet
    {
        $wallet = $this->walletBusiness->create($account, new Wallet());

        if (!$this->save($wallet)) {
            throw new \Exception("Not possible salve wallet", 1);
        }

        return $wallet;
    }

    /**
     * Update amount in wallets
     * @param  Transaction $transaction Transaction
     * @return void
     */
    public function updateAmountToWallets(Transaction $transaction) : void
    {
        // validate
        if (!$transaction->getStatus()) {
            return;
        }

        $valueTransaction = $transaction->getValue();
        switch ($transaction->getType()) {
            case TransactionBusiness::TYPE_TRANSFER:
                $valueToPayer = $valueTransaction * -1;
                $valueToPayee = $valueTransaction;

                $this->setAmoutToWalletByType(
                    $transaction->getWalletPayee(),
                    $valueToPayee
                );
                break;

            case TransactionBusiness::TYPE_CREDIT:
                $valueToPayer = $valueTransaction;
                break;
        }

        $this->setAmoutToWalletByType(
            $transaction->getWalletPayer(),
            $valueToPayer
        );
    }

    /**
     * Set amout to wallet
     * @param Wallet $wallet Wallet
     * @param float  $value  Value to set
     */
    protected function setAmoutToWalletByType(Wallet $wallet, float $value)
    {
        $wallet->updateAmout($value);

        if (!$this->save($wallet)) {
            throw new \Exception("Not possible update wallet", 1);
        }
    }

    /**
     * Get wallet account
     * @param  Account $account Account entity
     * @return Wallet
     */
    public function getAccountWallet(Account $account) : Wallet
    {
        return $this->walletRepository->getWalletByAccountId(
            $account->getId()
        );
    }

    /**
     * Persist wallet
     * @param  Wallet $entity Wallet entity
     * @return bool
     */
    protected function save(Wallet $entity) : bool
    {
        return $this->walletRepository->save($entity);
    }
}
