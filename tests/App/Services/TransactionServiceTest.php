<?php

namespace Tests\App\Services;

use DB;
use Exception;
use Tests\TestCase;
use App\Services\WalletService;
use App\Services\AccountService;
use App\Services\TransactionService;
use App\Services\AuthorizationService;
use App\Repository\TransactionRepository;
use App\Business\Transaction as TransactionBusiness;
use App\Models\Transaction as TransactionModel;
use App\Models\Authorization as AuthorizationModel;
use App\Models\Wallet as WalletModel;
use App\Models\Account as AccountModel;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;


use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\AuthorizationProvider\AuthorizationProviderInterface;

class TransactionServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp() : void
    {
        parent::setUp();

        $this->mockTransactionRepository = \Mockery::mock(TransactionRepository::class);
        $this->mockAccountService = \Mockery::mock(AccountService::class);
        $this->mockWalletService = \Mockery::mock(WalletService::class);
        $this->mockAuthorizationService = \Mockery::mock(AuthorizationService::class);
        $this->mockTransactionBusiness = \Mockery::mock(TransactionBusiness::class);

        $this->service = new TransactionService(
            $this->mockTransactionRepository,
            $this->mockAccountService,
            $this->mockWalletService,
            $this->mockAuthorizationService,
            $this->mockTransactionBusiness
        );
    }

    public function _testExecuteTransactionSuccess()
    {
        // mock
        DB::shouldReceive('beginTransaction')->once();

        $data = [
            'payer' => 1,
            'payee' => 2,
            'value' => 99
        ];

        $transaction = new TransactionModel($data);
        $transaction->id = 5;
        $walletPayer = new WalletModel;
        $walletPayer->id = 3;
        $walletPayee = new WalletModel;
        $walletPayee->id = 4;
        $accountPayer = new AccountModel;
        $accountPayer->id = 1;
        $accountPayee = new AccountModel;
        $accountPayee->id = 2;
        $authorization = new AuthorizationModel(['message' => AuthorizationModel::MESSAGE_ALLOW]);

        ////////////////////////
        // mockAccountService //
        ////////////////////////
        $this->mockAccountService
            ->shouldReceive('getAccount')
            ->with(1)
            ->once()
            ->andReturn($accountPayer)
        ;

        $this->mockAccountService
            ->shouldReceive('getAccount')
            ->with(2)
            ->once()
            ->andReturn($accountPayee)
        ;

        ///////////////////////
        // mockWalletService //
        ///////////////////////
        $this->mockWalletService
            ->shouldReceive('getAccountWallet')
            ->with($accountPayer)
            ->once()
            ->andReturn($walletPayer)
        ;

        $this->mockWalletService
            ->shouldReceive('getAccountWallet')
            ->with($accountPayee)
            ->once()
            ->andReturn($walletPayee)
        ;

        $this->mockWalletService
            ->shouldReceive('updateAmountToWallets')
            ->once()
        ;

        //////////////////////////////
        // mockTransactionBusiness //
        //////////////////////////////
        $this->mockTransactionBusiness
            ->shouldReceive('validateAvailability')
            ->once()
            ->andReturn(true)
        ;

        $this->mockTransactionBusiness
            ->shouldReceive('validateAuthorization')
            ->once()
            ->andReturn(true)
        ;

        $this->mockTransactionBusiness
            ->shouldReceive('execute')
            ->once()
            ->andReturn($transaction)
        ;

        //////////////////////////////
        // mockAuthorizationService //
        //////////////////////////////
        $this->mockAuthorizationService
            ->shouldReceive('checkAuthorization')
            ->once()
            ->andReturn($authorization)
        ;

        $this->mockAuthorizationService
            ->shouldReceive('saveAuthorization')
            ->once()
            ->andReturn(true)
        ;

        ///////////////////////////////
        // mockTransactionRepository //
        ///////////////////////////////
        $this->mockTransactionRepository
            ->shouldReceive('save')
            ->once()
            ->andReturn(true)
        ;

        $entity = $this->service->executeTransaction(new ParameterBag($data));
    }


    public function testSaveAuthorization()
    {

    }
    // public function testExecuteTransactionSuccess()

    // public function executeTransaction(ParameterBag $input) : Transaction
}
