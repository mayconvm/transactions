<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\ParameterBag;
use App\Repository\TransactionRepository;
use App\Business\Transaction as TransactionBusiness;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Wallet;

class TransactionService
{
    private $transactionBusiness;
    private $transactionRepository;
    private $accountService;
    private $walletService;

    public function __construct(
        TransactionRepository $transactionRepository,
        AccountService $accountService,
        WalletService $walletService,
        TransactionBusiness $transactionBusiness
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->accountService = $accountService;
        $this->walletService = $walletService;
        $this->transactionBusiness = $transactionBusiness;
    }

    public function executeTransaction(ParameterBag $input)
    {
        $transaction = $this->prepareTransaction(
            $this->getTransaction($input)
        );

        if ($transaction->getStatus()) {
            $this->transactionBusiness->execute($transaction);
        }

        try {
            // dd($transaction);
            // save
            if (!$this->transactionRepository->save($transaction)) {
                throw new \Exception("Error to save data about user.", 1);
            }

        } catch (\Exception $e) {
            die("Morri" . $e->getMessage());
        }


        // update wallet
        $this->walletService->updateAmountToWallets($transaction);

        return $transaction;
    }

    protected function prepareTransaction(Transaction $transaction) : Transaction
    {
        // type
        $transaction->setType(Transaction::TYPE_CREDIT);

        // check availability
        if (!$this->transactionBusiness->validateAvailability($transaction)) {
            $transaction->setStatus(false);

            return $transaction;
        }

        // TODO: check autorization
        // if (!$this->transactionBusiness->validateAuthorization($dataAuthorization)) {
        //     $transaction->setState(false);
        // }

        return $transaction;
    }

    protected function getTransaction(ParameterBag $input) : Transaction
    {
        $payer = $this->getWalletAccount($input->get('payer'));
        $payee = $this->getWalletAccount($input->get('payee'));


        $transaction = new Transaction();
        $transaction->setWalletPayee($payee);
        $transaction->setWalletPayer($payer);
        $transaction->setValue($input->get('value'));

        return $transaction;
    }

    protected function getWalletAccount(string $account) : Wallet
    {
        return $this->walletService->getAccountWallet(
            $this->getAccount($account)
        );
    }

    protected function getAccount(string $account) : Account
    {
        return $this->accountService->getAccount($account);
    }

    public function retrieveTransaction()
    {
    }
}
