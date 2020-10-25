<?php

namespace Tests\App\Business;

use App\Business\Account as AccountBusiness;
use App\Models\Account as AccountModel;
use Tests\TestCase;

class AccountTest extends TestCase
{
    public function testCreateAccountPerson()
    {
        $account = new AccountBusiness();
        $entityAccount = $account->create(new AccountModel);

        $this->assertFalse($entityAccount->getNotTransferValues());
    }

    public function testCreateAccountBusiness()
    {
        $accountModel = new AccountModel;
        $accountModel->setType(AccountBusiness::TYPE_BUSINESS);

        $account = new AccountBusiness();
        $entityAccount = $account->create($accountModel);

        $this->assertTrue($entityAccount->getNotTransferValues());
    }
}
