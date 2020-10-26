<?php

namespace Tests\App\Services;

use Exception;
use Tests\TestCase;
use App\Services\AccountService;
use App\Services\WalletService;
use App\Business\Account as AccountBusiness;
use App\Repository\AccountRepository;
use App\Models\Account as AccountModel;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountServiceTest extends TestCase
{
    public function setUp() : void
    {
        $this->mockAccountRepository = \Mockery::mock(AccountRepository::class);
        $this->mockWalletService = \Mockery::mock(WalletService::class);
        $this->mockAccountBusiness = \Mockery::mock(AccountBusiness::class);

        $this->service = new AccountService(
            $this->mockAccountRepository,
            $this->mockWalletService,
            $this->mockAccountBusiness
        );
    }

    public function testCreateAccountSuccess()
    {
        $data = [
            'email' => '__EMAIL__',
            'name' => '__NAME__',
            'document' => '__DOCUMENT__',
        ];
        ///////////////////////
        // accountRepository //
        ///////////////////////
        $this->mockAccountRepository
            ->shouldReceive('emailExists')
            ->with('__EMAIL__')
            ->once()
            ->andReturn(false)
        ;

        $this->mockAccountRepository
            ->shouldReceive('save')
            ->once()
            ->andReturn(true)
            ->getMock()
        ;

        /////////////////////
        // accountBusiness //
        /////////////////////
        $this->mockAccountBusiness
            ->shouldReceive('create')
            ->once()
            ->andReturn(new AccountModel($data))
        ;

        ///////////////////
        // walletService //
        ///////////////////
        $this->mockWalletService
            ->shouldReceive('createWallet')
            ->once()
        ;

        $entity = $this->service->createAccount(new ParameterBag($data));

        $this->assertEquals($data['name'], $entity->getName());
        $this->assertEquals($data['email'], $entity->getEmail());
        $this->assertEquals($data['document'], $entity->getDocument());
    }

    public function testCreateAccountEmailAlredyExists()
    {
        $this->expectException(Exception::class);
        $data = [
            'email' => '__EMAIL__',
            'name' => '__NAME__',
            'document' => '__DOCUMENT__',
        ];
        ///////////////////////
        // accountRepository //
        ///////////////////////
        $this->mockAccountRepository
            ->shouldReceive('emailExists')
            ->with('__EMAIL__')
            ->once()
            ->andReturn(true)
        ;

        $this->service->createAccount(new ParameterBag($data));
    }

    public function testCreateAccountErrorToSave()
    {
        $this->expectException(Exception::class);
        $data = [
            'email' => '__EMAIL__',
            'name' => '__NAME__',
            'document' => '__DOCUMENT__',
        ];
        ///////////////////////
        // accountRepository //
        ///////////////////////
        $this->mockAccountRepository
            ->shouldReceive('emailExists')
            ->with('__EMAIL__')
            ->once()
            ->andReturn(false)
        ;

        $this->mockAccountRepository
            ->shouldReceive('save')
            ->once()
            ->andThrow(new Exception)
            ->getMock()
        ;

        /////////////////////
        // accountBusiness //
        /////////////////////
        $this->mockAccountBusiness
            ->shouldReceive('create')
            ->once()
            ->andReturn(new AccountModel($data))
        ;

        $this->service->createAccount(new ParameterBag($data));
    }

    public function testGetAccount()
    {
        $data = [
            'email' => '__EMAIL__',
            'name' => '__NAME__',
            'document' => '__DOCUMENT__',
        ];

        ///////////////////////
        // accountRepository //
        ///////////////////////
        $this->mockAccountRepository
            ->shouldReceive('getAccountById')
            ->with(1)
            ->once()
            ->andReturn(new AccountModel($data))
        ;

        $entity = $this->service->getAccount(1);
        $this->assertEquals($data['name'], $entity->getName());
        $this->assertEquals($data['email'], $entity->getEmail());
        $this->assertEquals($data['document'], $entity->getDocument());
    }
}
