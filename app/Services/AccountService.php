<?php

namespace App\Services;

use App\Http\Inputs\AccountInput;
use Symfony\Component\HttpFoundation\ParameterBag;
use App\Models\Account;
use App\Business\Account as AccountBusiness;
use App\Repository\AccountRepository;


class AccountService
{
    private $accountBusiness;

    public function __construct(
        AccountRepository $accountRepository,
        WalletService $walletService,
        AccountBusiness $accountBusiness
    ) {
        $this->accountRepository = $accountRepository;
        $this->walletService = $walletService;
        $this->accountBusiness = $accountBusiness;
    }

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

    public function createWallet(Account $account)
    {
        $this->walletService->createWallet($account);
    }

    public function editAccount() : AccountInput
    {
    }

    public function getAccount(string $accountId) : Account
    {
        return $this->accountRepository->getAccountById($accountId);
    }

}
