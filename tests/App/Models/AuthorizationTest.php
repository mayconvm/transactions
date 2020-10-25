<?php

namespace Tests\App\Models;

use Tests\TestCase;
use App\Business\Model\AuthorizationInterface;
use App\Models\Authorization as AuthorizationModel;

class AuthorizationTest extends TestCase
{
    public function testPopulateAuthorization()
    {
        $entity = new AuthorizationModel([
            'message' => AuthorizationInterface::MESSAGE_ALLOW
        ]);
        $entity->id = 1;
        $entity->setTransactionId(2);

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals(AuthorizationInterface::MESSAGE_ALLOW, $entity->getMessage());
        $this->assertEquals(2, $entity->getTransactionId());
        $this->assertTrue($entity->allow());
        $this->assertTrue($entity->getStatus());
    }

    public function testPopulateNotAuthorization()
    {
        $entity = new AuthorizationModel;
        $entity->id = 1;
        $entity->setTransactionId(2);

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals(AuthorizationInterface::MESSAGE_DEFAULT, $entity->getMessage());
        $this->assertEquals(2, $entity->getTransactionId());
        $this->assertFalse($entity->allow());
        $this->assertFalse($entity->getStatus());
    }
}

