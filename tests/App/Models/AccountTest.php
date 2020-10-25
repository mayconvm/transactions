<?php

namespace Tests\App\Models;

use Tests\TestCase;
use App\Models\Account as AccountModel;
use App\Business\Account as AccountBusiness;

class AccountTest extends TestCase
{
    public function testPopulateEntity()
    {
        $entity = new AccountModel([
            'name' => 'DATA_NAME',
            'email' => 'DATA_EMAIL',
            'document' => 'DATA_DOCUMENT',
        ]);
        $entity->id = 1;
        $entity->setNotTransferValues(false);

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals('DATA_NAME', $entity->getName());
        $this->assertEquals('DATA_EMAIL', $entity->getEmail());
        $this->assertEquals('DATA_DOCUMENT', $entity->getDocument());
        $this->assertEquals(AccountBusiness::TYPE_PERSON, $entity->getType());
        $entity->setType("teste");
        $this->assertEquals('teste', $entity->getType());
        $this->assertFalse($entity->getNotTransferValues());
    }
}
