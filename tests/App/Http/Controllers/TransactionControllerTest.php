<?php

namespace Tests\App\Controller;

use Tests\TestCase;
use App\Business\Transaction as TransactionBusiness;
use App\Business\Account as AccountBusiness;
use App\Services\AuthorizationProvider\AuthorizationProviderInterface;
use App\Business\Model\AuthorizationInterface;


class TransactionControllerTest extends TestCase
{
    protected function createUser($type = null)
    {
        // create account
        $data = [
            "name" => "name test",
            "document" => rand(),
            "email" => rand() . "email@email.com",
            "type" => is_null($type) ? AccountBusiness::TYPE_PERSON : $type,
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/account', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();
        $dataArray = $response->json();

        return $dataArray['id'];
    }

    protected function addAmountToWallet($idAccount, $value, $availableMock = true)
    {
        if ($availableMock) {
            $mock = \Mockery::mock(AuthorizationProviderInterface::class);
            $mock->shouldReceive('checkAuthorization')
                ->twice()
                ->andReturn(['message' => AuthorizationInterface::MESSAGE_ALLOW])
            ;
            $this->app->instance(AuthorizationProviderInterface::class, $mock);
        }

        $data = [
            "value" => $value,
            "payer" => $idAccount,
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];
        $response = $this->call('POST', '/transaction/credit', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();
    }

    public function testAddAmountToWallet()
    {
        $mock = \Mockery::mock(AuthorizationProviderInterface::class);
        $mock->shouldReceive('checkAuthorization')
            ->once()
            ->andReturn(['message' => AuthorizationInterface::MESSAGE_ALLOW])
        ;
        $this->app->instance(AuthorizationProviderInterface::class, $mock);

        $data = [
            "value" => 100,
            "payer" => $this->createUser(),
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];
        $response = $this->call('POST', '/transaction/credit', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();

        $responseArray = $response->json();
        $this->assertArrayHasKey('payer', $responseArray);
        $this->assertArrayHasKey('value', $responseArray);
        $this->assertArrayHasKey('type', $responseArray);
        $this->assertArrayHasKey('status', $responseArray);
        $this->assertArrayHasKey('transaction_code', $responseArray);
        $this->assertArrayHasKey('updated_at', $responseArray);
        $this->assertArrayHasKey('created_at', $responseArray);
        $this->assertArrayHasKey('id', $responseArray);

        $this->assertEquals(TransactionBusiness::TYPE_CREDIT, $responseArray['type']);
        $this->assertEquals($data['payer'], $responseArray['payer']);
        $this->assertEquals($data['value'], $responseArray['value']);
        $this->assertTrue($responseArray['status']);
    }

    public function testAddAmountToWalletWithoutValue()
    {
        $data = [
            "payer" => $this->createUser(),
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/transaction/credit', [], [], [], $headers, json_encode($data));
        $this->seeStatusCode(422);

        $responseArray = $response->json();
        $this->assertArrayHasKey('value', $responseArray);
    }

    public function testAddAmountToWalletInvalidPayer()
    {
        $data = [
            "value" => 10,
            "payer" => 0,
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/transaction/credit', [], [], [], $headers, json_encode($data));
        $this->seeStatusCode(422);

        $responseArray = $response->json();
        $this->assertArrayHasKey('message', $responseArray);
    }

    public function testExecuteTransactionSuccess()
    {
        $data = [
            "value" => 100,
            "payer" => $this->createUser(),
            "payee" => $this->createUser(),
        ];

        // add credit
        $this->addAmountToWallet($data['payer'], 200);

        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/transaction', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();

        $responseArray = $response->json();
        $this->assertArrayHasKey('payer', $responseArray);
        $this->assertArrayHasKey('payee', $responseArray);
        $this->assertArrayHasKey('value', $responseArray);
        $this->assertArrayHasKey('type', $responseArray);
        $this->assertArrayHasKey('status', $responseArray);
        $this->assertArrayHasKey('transaction_code', $responseArray);
        $this->assertArrayHasKey('updated_at', $responseArray);
        $this->assertArrayHasKey('created_at', $responseArray);
        $this->assertArrayHasKey('id', $responseArray);

        $this->assertEquals(TransactionBusiness::TYPE_TRANSFER, $responseArray['type']);
        $this->assertEquals($data['payer'], $responseArray['payer']);
        $this->assertEquals($data['payee'], $responseArray['payee']);
        $this->assertEquals($data['value'], $responseArray['value']);
        $this->assertTrue($responseArray['status']);
    }

    public function testExecuteTransactionPersonBusiness()
    {
        $data = [
            "value" => 100,
            "payer" => $this->createUser(),
            "payee" => $this->createUser(AccountBusiness::TYPE_BUSINESS),
        ];

        // add credit
        $this->addAmountToWallet($data['payer'], 200);

        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/transaction', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();

        $responseArray = $response->json();
        $this->assertArrayHasKey('payer', $responseArray);
        $this->assertArrayHasKey('payee', $responseArray);
        $this->assertArrayHasKey('value', $responseArray);
        $this->assertArrayHasKey('type', $responseArray);
        $this->assertArrayHasKey('status', $responseArray);
        $this->assertArrayHasKey('transaction_code', $responseArray);
        $this->assertArrayHasKey('updated_at', $responseArray);
        $this->assertArrayHasKey('created_at', $responseArray);
        $this->assertArrayHasKey('id', $responseArray);

        $this->assertEquals(TransactionBusiness::TYPE_TRANSFER, $responseArray['type']);
        $this->assertEquals($data['payer'], $responseArray['payer']);
        $this->assertEquals($data['payee'], $responseArray['payee']);
        $this->assertEquals($data['value'], $responseArray['value']);
        $this->assertTrue($responseArray['status']);
    }

    public function testExecuteTransactionBusinessBusiness()
    {
        $data = [
            "value" => 100,
            "payer" => $this->createUser(AccountBusiness::TYPE_BUSINESS),
            "payee" => $this->createUser(AccountBusiness::TYPE_BUSINESS),
        ];

        $headers = [ 'CONTENT_TYPE' => 'application/json' ];
        $response = $this->call('POST', '/transaction', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();

        $responseArray = $response->json();
        $this->assertArrayHasKey('payer', $responseArray);
        $this->assertArrayHasKey('payee', $responseArray);
        $this->assertArrayHasKey('value', $responseArray);
        $this->assertArrayHasKey('type', $responseArray);
        $this->assertArrayHasKey('status', $responseArray);
        $this->assertArrayHasKey('transaction_code', $responseArray);
        $this->assertArrayHasKey('updated_at', $responseArray);
        $this->assertArrayHasKey('created_at', $responseArray);
        $this->assertArrayHasKey('id', $responseArray);

        $this->assertEquals(TransactionBusiness::TYPE_TRANSFER, $responseArray['type']);
        $this->assertEquals($data['payer'], $responseArray['payer']);
        $this->assertEquals($data['payee'], $responseArray['payee']);
        $this->assertEquals($data['value'], $responseArray['value']);
        $this->assertFalse($responseArray['status']);
    }

    public function testExecuteTransactionPersonWithoutAmout()
    {
        $data = [
            "value" => 100,
            "payer" => $this->createUser(),
            "payee" => $this->createUser(AccountBusiness::TYPE_BUSINESS),
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/transaction', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();

        $responseArray = $response->json();
        $this->assertArrayHasKey('payer', $responseArray);
        $this->assertArrayHasKey('payee', $responseArray);
        $this->assertArrayHasKey('value', $responseArray);
        $this->assertArrayHasKey('type', $responseArray);
        $this->assertArrayHasKey('status', $responseArray);
        $this->assertArrayHasKey('transaction_code', $responseArray);
        $this->assertArrayHasKey('updated_at', $responseArray);
        $this->assertArrayHasKey('created_at', $responseArray);
        $this->assertArrayHasKey('id', $responseArray);

        $this->assertEquals(TransactionBusiness::TYPE_TRANSFER, $responseArray['type']);
        $this->assertEquals($data['payer'], $responseArray['payer']);
        $this->assertEquals($data['payee'], $responseArray['payee']);
        $this->assertEquals($data['value'], $responseArray['value']);
        $this->assertFalse($responseArray['status']);
    }

    public function testExecuteTransactionPersonUnAuthorization()
    {
        $mock = \Mockery::mock(AuthorizationProviderInterface::class);
        $mock->shouldReceive('checkAuthorization')
            ->once()
            ->andReturns([
                ['message' => AuthorizationInterface::MESSAGE_ALLOW],
                ['message' => ''],
            ])
        ;
        $this->app->instance(AuthorizationProviderInterface::class, $mock);

        $data = [
            "value" => 100,
            "payer" => $this->createUser(),
            "payee" => $this->createUser(AccountBusiness::TYPE_BUSINESS),
        ];

        // add credit
        $this->addAmountToWallet($data['payer'], 200, false);

        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/transaction', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();

        $responseArray = $response->json();
        $this->assertArrayHasKey('payer', $responseArray);
        $this->assertArrayHasKey('payee', $responseArray);
        $this->assertArrayHasKey('value', $responseArray);
        $this->assertArrayHasKey('type', $responseArray);
        $this->assertArrayHasKey('status', $responseArray);
        $this->assertArrayHasKey('transaction_code', $responseArray);
        $this->assertArrayHasKey('updated_at', $responseArray);
        $this->assertArrayHasKey('created_at', $responseArray);
        $this->assertArrayHasKey('id', $responseArray);

        $this->assertEquals(TransactionBusiness::TYPE_TRANSFER, $responseArray['type']);
        $this->assertEquals($data['payer'], $responseArray['payer']);
        $this->assertEquals($data['payee'], $responseArray['payee']);
        $this->assertEquals($data['value'], $responseArray['value']);
        $this->assertFalse($responseArray['status']);
    }

    public function testExecuteTransactionWithoutValue()
    {
        $data = [
            "payer" => $this->createUser(),
            "payee" => $this->createUser(AccountBusiness::TYPE_BUSINESS),
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/transaction', [], [], [], $headers, json_encode($data));
        $this->seeStatusCode(422);

        $responseArray = $response->json();
        $this->assertArrayHasKey('value', $responseArray);
    }

    public function testExecuteTransactionInvalidPayer()
    {
        $data = [
            "value" => 1,
            "payer" => 987,
            "payee" => $this->createUser(AccountBusiness::TYPE_BUSINESS),
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/transaction', [], [], [], $headers, json_encode($data));
        $this->seeStatusCode(422);

        $responseArray = $response->json();
        $this->assertArrayHasKey('message', $responseArray);
    }
}
