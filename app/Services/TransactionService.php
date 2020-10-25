<?php
/**
 * Class service
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Services;

use DB;
use App\Models\Account;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\ParameterBag;
use App\Business\Transaction as TransactionBusiness;

/**
 * Classe TransactionService
 * @package App\Services
 */
class TransactionService
{
    /**
     * Transaction repository
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * Account service
     * @var AccountService
     */
    private $accountService;

    /**
     * Wallet service
     * @var WalletService
     */
    private $walletService;

    /**
     * Authorization service
     * @var AuthorizationService
     */
    private $authorizationService;

    /**
     * Transaction business
     * @var TransactionBusiness
     */
    private $transactionBusiness;

    /**
     * Method construct
     * @param TransactionRepository $transactionRepository Trasanction repository
     * @param AccountService        $accountService        Account service
     * @param WalletService         $walletService         Wallet service
     * @param AuthorizationService  $authorizationService  Authorization service
     * @param TransactionBusiness   $transactionBusiness   Transaction business
     */
    public function __construct(
        TransactionRepository $transactionRepository,
        AccountService $accountService,
        WalletService $walletService,
        AuthorizationService $authorizationService,
        TransactionBusiness $transactionBusiness
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->accountService = $accountService;
        $this->walletService = $walletService;
        $this->authorizationService = $authorizationService;
        $this->transactionBusiness = $transactionBusiness;
    }

    /**
     * Execute transaction
     * @param  ParameterBag $input Data trquest to transaction
     * @return Transaction
     */
    public function executeTransaction(ParameterBag $input) : Transaction
    {
        $transaction = $this->prepareTransaction(
            $this->getNewTransaction($input)
        );

        if ($transaction->getStatus()) {
            $this->transactionBusiness->execute($transaction);
        }

        // transaction
        DB::beginTransaction();

        try {
            // save
            if (!$this->transactionRepository->save($transaction)) {
                throw new \Exception("Error to save data about user.", 1);
            }

            // save authorization
            $authorization = $transaction->getAuthorization();
            if ($authorization) {
                $authorization->setTransactionId($transaction->getId());
                if (!$this->authorizationService->saveAuthorization($authorization)) {
                    throw new \Exception("Error to save data about user.", 1);
                }
            }

            // update wallet
            $this->walletService->updateAmountToWallets($transaction);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }

        return $transaction;
    }

    /**
     * Prepare transaction to execute
     * @param  Transaction $transaction Transaction
     * @return Transaction
     */
    protected function prepareTransaction(Transaction $transaction) : Transaction
    {
        // type
        $transaction->setType(Transaction::TYPE_CREDIT);

        // check availability
        if (!$this->transactionBusiness->validateAvailability($transaction)) {
            $transaction->setStatus(false);

            return $transaction;
        }

        $authorization = $this->authorizationService->checkAuthorization($transaction);
        $transaction->setAuthorization($authorization);

        // check autorization
        if (!$this->transactionBusiness->validateAuthorization($authorization)) {
            $transaction->setStatus(false);
        }

        $transaction->setStatus(true);

        return $transaction;
    }

    /**
     * Get transaction
     * @param  ParameterBag $input Create new transaction
     * @return Transaction
     */
    protected function getNewTransaction(ParameterBag $input) : Transaction
    {
        $payer = $this->getWalletAccount($input->get('payer'));
        $payee = $this->getWalletAccount($input->get('payee'));


        $transaction = new Transaction();
        $transaction->setWalletPayee($payee);
        $transaction->setWalletPayer($payer);
        $transaction->setValue($input->get('value'));

        return $transaction;
    }

    /**
     * Get wallet by acount
     * @param  id $account Account id
     * @return Wallet
     */
    protected function getWalletAccount(int $account) : Wallet
    {
        return $this->walletService->getAccountWallet(
            $this->getAccount($account)
        );
    }

    /**
     * Get Account
     * @param  int    $account Account id
     * @return Account
     */
    protected function getAccount(int $account) : Account
    {
        return $this->accountService->getAccount($account);
    }

    public function retrieveTransaction()
    {
    }
}
