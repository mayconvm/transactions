<?php

namespace Tests\App\Models;

use Tests\TestCase;
use App\Models\Account as AccountModel;
use App\Models\Wallet as WalletModel;
use App\Business\Account as AccountBusiness;

class WalletTest extends TestCase
{
    public function testPopulateEntity()
    {
        $entity = new WalletModel;
        $entity->id = 1;
        $entity->setStatus(false);
        $entity->setAccountId(123);
        $entity->setAmount(123.445);

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals(123.445, $entity->getAmount());

        $entity->updateAmout(1.555);
        $this->assertEquals(125, $entity->getAmount());

        $entity->updateAmout(-0.555);
        $this->assertEquals(124.445, $entity->getAmount());

        $this->assertEquals(123, $entity->getAccountId());
        $this->assertFalse($entity->getStatus());

        $entity->relationAccount = new AccountModel(['name' => 'NAME_TEST']);
        $this->assertEquals('NAME_TEST', $entity->getAccount()->getName());
    }
}

