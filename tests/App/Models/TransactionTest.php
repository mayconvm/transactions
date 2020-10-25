<?php

namespace Tests\App\Models;

use Tests\TestCase;
use App\Models\Wallet as WalletModel;
use App\Models\Transaction as TransactionModel;
use App\Models\Authorization as AuthorizationModel;
use App\Business\Transaction as TransactionBusiness;

class TransactionTest extends TestCase
{
    public function testPopulateEntity()
    {
        $walletPayer = new WalletModel(['amount' => 99]);
        $walletPayer->id = 3;
        $walletPayee = new WalletModel(['amount' => 1]);
        $walletPayee->id = 4;

        $entity = new TransactionModel;
        $entity->id = 1;

        $entity->setTransactionCode('SETTRANSACTIONCODE');
        $entity->setType('SETTYPE');
        $entity->setValue(1.2);
        $entity->setPayer(3);
        $entity->setPayee(4);
        $entity->setStatus(false);
        $entity->setWalletPayer($walletPayer);
        $entity->setWalletPayee($walletPayee);
        $entity->setAuthorization(new AuthorizationModel);

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals('SETTRANSACTIONCODE', $entity->getTransactionCode());
        $this->assertEquals('SETTYPE', $entity->getType());
        $this->assertEquals(1.2, $entity->getValue());
        $this->assertEquals(3, $entity->getPayer());
        $this->assertEquals(4, $entity->getPayee());
        $this->assertFalse($entity->getStatus());

        $this->assertEquals(99, $entity->getWalletPayer()->getAmount());
        $this->assertEquals(1, $entity->getWalletPayee()->getAmount());
        $this->assertFalse($entity->getAuthorization()->allow());
    }
}

