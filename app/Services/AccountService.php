<?php

namespace App\Services;

use App\Http\Inputs\AccountInput;
use App\Models\Account;
use App\Business\Account as AccountBusiness;


class AccountService
{
    private $accountBusiness;

    public function __construct(AccountBusiness $accountBusiness)
    {
        $this->accountBusiness = $accountBusiness;
    }

    public function createAccount(AccountInput $input) : AccountInput
    {
        $entity = new Account();
        // populate
        $entity->fill($input->all());
        // class business
        $accountEntity = $this->accountBusiness->create($entity);

        echo "<pre>"; die(print_r([$input->all(), $entity]));
        // perssist database
        if (!$accountEntity->save()) {
            // error
        }

        // return entity
        return $accountEntity;
    }

    public function editAccount() : AccountInput
    {
    }

}
