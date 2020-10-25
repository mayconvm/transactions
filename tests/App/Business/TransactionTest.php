<?php

namespace Tests\App\Business;

use App\Business\Account as AccountBusiness;
use App\Business\Transaction as TransactionBusiness;
use App\Models\Account as AccountModel;
use App\Models\Transaction as TransactionModel;
use App\Models\Wallet as WalletModel;
use App\Models\Authorization as AuthorizationModel;
use Tests\TestCase;
use App\Business\Model\AuthorizationInterface;

class TransactionTest extends TestCase
{

    public function testValidateAvailabilitySuccess()
    {
        $mockWalletPayee = $this->mock = \Mockery::mock(WalletModel::class);
        $mockWalletPayee
            ->shouldReceive('getId')
            ->once()
            ->andReturn(1)
        ;

        $mockWalletPayer = $this->mock = \Mockery::mock(WalletModel::class);
        $mockWalletPayer
            ->shouldReceive('getId')
            ->once()
            ->andReturn(2)
        ;
        $mockWalletPayer
            ->shouldReceive('getAccount')
            ->once()
            ->andReturn(new AccountModel)
        ;
        $mockWalletPayer
            ->shouldReceive('getAmount')
            ->once()
            ->andReturn(100)
        ;

        $transaction = new TransactionModel(['value' => 99]);
        $transaction->setWalletPayee($mockWalletPayee);
        $transaction->setWalletPayer($mockWalletPayer);

        $transactionBusiness = new TransactionBusiness();
        $result = $transactionBusiness->validateAvailability($transaction);

        $this->assertTrue($result);
    }

    public function testValidateAvailabilityAccountTypeInvalid()
    {
        $mockWalletPayee = $this->mock = \Mockery::mock(WalletModel::class);
        $mockWalletPayee
            ->shouldReceive('getId')
            ->once()
            ->andReturn(1)
        ;

        $mockWalletPayer = $this->mock = \Mockery::mock(WalletModel::class);
        $mockWalletPayer
            ->shouldReceive('getId')
            ->once()
            ->andReturn(2)
        ;
        $mockWalletPayer
            ->shouldReceive('getAccount')
            ->once()
            ->andReturn(new AccountModel(['type' => AccountBusiness::TYPE_BUSINESS]))
        ;

        $transaction = new TransactionModel(['value' => 99]);
        $transaction->setWalletPayee($mockWalletPayee);
        $transaction->setWalletPayer($mockWalletPayer);

        $transactionBusiness = new TransactionBusiness();
        $result = $transactionBusiness->validateAvailability($transaction);

        $this->assertFalse($result);
    }

    public function testValidateAvailabilityAmountNotAvailable()
    {
        $mockWalletPayee = $this->mock = \Mockery::mock(WalletModel::class);
        $mockWalletPayee
            ->shouldReceive('getId')
            ->once()
            ->andReturn(1)
        ;

        $mockWalletPayer = $this->mock = \Mockery::mock(WalletModel::class);
        $mockWalletPayer
            ->shouldReceive('getId')
            ->once()
            ->andReturn(2)
        ;
        $mockWalletPayer
            ->shouldReceive('getAccount')
            ->once()
            ->andReturn(new AccountModel)
        ;
        $mockWalletPayer
            ->shouldReceive('getAmount')
            ->once()
            ->andReturn(98)
        ;

        $transaction = new TransactionModel(['value' => 99]);
        $transaction->setWalletPayee($mockWalletPayee);
        $transaction->setWalletPayer($mockWalletPayer);

        $transactionBusiness = new TransactionBusiness();
        $result = $transactionBusiness->validateAvailability($transaction);

        $this->assertFalse($result);
    }

    public function testAuthorization()
    {
        $transactionBusiness = new TransactionBusiness();
        $result = $transactionBusiness->validateAuthorization(
            new AuthorizationModel(['message' => AuthorizationInterface::MESSAGE_ALLOW])
        );

        $this->assertTrue($result);
    }

    public function testNotAuthorization()
    {
        $transactionBusiness = new TransactionBusiness();
        $result = $transactionBusiness->validateAuthorization(new AuthorizationModel);

        $this->assertFalse($result);
    }

    public function testExecuteSuccess()
    {
        $transactionBusiness = new TransactionBusiness;
        $transaction = $transactionBusiness->execute(
            new TransactionModel(['status' => true])
        );

        $this->assertTrue($transaction->getStatus());
    }

    public function testExecuteUnSuccess()
    {
        $transactionBusiness = new TransactionBusiness;
        $transaction = $transactionBusiness->execute(
            new TransactionModel(['status' => false])
        );

        $this->assertFalse($transaction->getStatus());
    }
}
