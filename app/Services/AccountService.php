<?php
/**
 * Class service
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Services;

use App\Models\Account;
use App\Http\Inputs\AccountInput;
use App\Repository\AccountRepository;
use App\Business\Account as AccountBusiness;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Classe AccountService
 * @package App\Services
 */
class AccountService
{
    /**
     * Repository to account
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * Wallet service
     * @var WalletService
     */
    private $walletService;

    /**
     * Account business
     * @var AccountBusiness
     */
    private $accountBusiness;

    /**
     * Method construct
     * @param AccountRepository $accountRepository Account repository
     * @param WalletService     $walletService     Wallet service
     * @param AccountBusiness   $accountBusiness   Account business
     */
    public function __construct(
        AccountRepository $accountRepository,
        WalletService $walletService,
        AccountBusiness $accountBusiness
    ) {
        $this->accountRepository = $accountRepository;
        $this->walletService = $walletService;
        $this->accountBusiness = $accountBusiness;
    }

    /**
     * Create account
     * @param  ParameterBag $input List with parameters to new account
     * @return Account
     */
    public function createAccount(ParameterBag $input) : Account
    {
        // account already exists
        if ($this->accountRepository->emailExists($input->get('email'))) {
            throw new \Exception("User already exists.", 1);
        }

        $entity = new Account();
        $entity->fill($input->all());

        // validation

        // class business
        $accountEntity = $this->accountBusiness->create($entity);

        // perssist database
        if (!$this->accountRepository->save($accountEntity)) {
            throw new \Exception("Error to save data about user.", 1);
        }

        // wallet
        $this->createWallet($accountEntity);

        // return entity
        return $accountEntity;
    }

    /**
     * Create new wallet
     * @param  Account $account Account model
     * @return void
     */
    public function createWallet(Account $account) : void
    {
        $this->walletService->createWallet($account);
    }

    public function editAccount() : AccountInput
    {
    }

    /**
     * Get modelaccount
     * @param  id $accountId Account id
     * @return Account
     */
    public function getAccount(int $accountId) : Account
    {
        return $this->accountRepository->getAccountById($accountId);
    }

}
