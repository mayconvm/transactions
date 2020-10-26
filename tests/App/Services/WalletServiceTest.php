<?php

namespace Tests\App\Services;

use Exception;
use Tests\TestCase;
use App\Services\WalletService;
use App\Models\Account as AccountModel;
use App\Models\Wallet as WalletModel;
use App\Models\Transaction as TransactionModel;
use App\Repository\WalletRepository;
use App\Business\Wallet as WalletBusiness;
use App\Business\Transaction as TransactionBusiness;

class WalletServiceTest extends TestCase
{
    public function setUp() : void
    {
        $this->mockWalletRepository = \Mockery::mock(WalletRepository::class);
        $this->mockWalletBusiness = \Mockery::mock(WalletBusiness::class);

        $this->service = new WalletService(
            $this->mockWalletRepository,
            $this->mockWalletBusiness
        );
    }

    public function testCreateWalletSuccess()
    {
        $accountModel = new AccountModel();
        $walletModel = new WalletModel(['amount' => 99]);
        ///////////////////////////
        // mockWalletBusiness //
        ///////////////////////////
        $this->mockWalletBusiness
            ->shouldReceive('create')
            ->once()
            ->andReturn($walletModel)
        ;

        //////////////////////////
        // mockWalletRepository //
        //////////////////////////
        $this->mockWalletRepository
            ->shouldReceive('save')
            ->once()
            ->andReturn(true)
        ;

        $wallet = $this->service->createWallet(new AccountModel);
        $this->assertEquals(get_class($wallet), WalletModel::class);
    }

    public function testCreateWalletUnSuccess()
    {
        $this->expectException(Exception::class);
        $accountModel = new AccountModel();
        $walletModel = new WalletModel(['amount' => 99]);
        ///////////////////////////
        // mockWalletBusiness //
        ///////////////////////////
        $this->mockWalletBusiness
            ->shouldReceive('create')
            ->once()
            ->andReturn($walletModel)
        ;

        //////////////////////////
        // mockWalletRepository //
        //////////////////////////
        $this->mockWalletRepository
            ->shouldReceive('save')
            ->once()
            ->andReturn(false)
        ;

        $wallet = $this->service->createWallet(new AccountModel);
    }

    public function testUpdateAmountToWalletsSuccess()
    {
        $transaction = new TransactionModel([
            'value' => 100,
            'status' => true,
            'type' => TransactionBusiness::TYPE_TRANSFER,
        ]);

        $walletPayer = new WalletModel(['amount' => 101]);
        $walletPayer->id = 1;
        $walletPayee = new WalletModel(['amount' => 2]);
        $walletPayee->id = 2;

        $transaction->setWalletPayer($walletPayer);
        $transaction->setWalletPayee($walletPayee);

        //////////////////////////
        // mockWalletRepository //
        //////////////////////////
        $this->mockWalletRepository
            ->shouldReceive('save')
            ->with($walletPayer)
            ->once()
            ->andReturn(true)
        ;

        $this->mockWalletRepository
            ->shouldReceive('save')
            ->with($walletPayee)
            ->once()
            ->andReturn(true)
        ;

        $this->service->updateAmountToWallets($transaction);

        $this->assertEquals(1, $walletPayer->getAmount());
        $this->assertEquals(102, $walletPayee->getAmount());
    }

    public function testUpdateAmountToWalletsTransactionStatusFalse()
    {
        $transaction = new TransactionModel([
            'value' => 100,
            'status' => false,
            'type' => TransactionBusiness::TYPE_TRANSFER,
        ]);

        $walletPayer = new WalletModel(['amount' => 101]);
        $walletPayer->id = 1;
        $walletPayee = new WalletModel(['amount' => 2]);
        $walletPayee->id = 2;

        $transaction->setWalletPayer($walletPayer);
        $transaction->setWalletPayee($walletPayee);

        $this->service->updateAmountToWallets($transaction);

        $this->assertEquals(101, $walletPayer->getAmount());
        $this->assertEquals(2, $walletPayee->getAmount());
    }

    public function testGetAccountWallet()
    {
        $accountModel = new AccountModel;
        $accountModel->id = 1;

        //////////////////////////
        // mockWalletRepository //
        //////////////////////////
        $this->mockWalletRepository
            ->shouldReceive('getWalletByAccountId')
            ->with($accountModel->getId())
            ->once()
            ->andReturn(new WalletModel)
        ;

        $this->service->getAccountWallet($accountModel);
    }
}
