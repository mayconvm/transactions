<?php

namespace Tests\App\Business;

use Tests\TestCase;
use App\Business\Account as AccountBusiness;
use App\Business\Wallet as WalletBusiness;
use App\Models\Account as AccountModel;
use App\Models\Transaction as TransactionModel;
use App\Models\Wallet as WalletModel;

class WalletTest extends TestCase
{

    public function testCreateWithSuccess()
    {
        $mockAccount = $this->mock = \Mockery::mock(AccountModel::class);
        $mockAccount
            ->shouldReceive('getId')
            ->once()
            ->andReturn(1)
        ;

        $walletBusiness = new WalletBusiness();
        $wallet = $walletBusiness->create(
            $mockAccount,
            new WalletModel
        );

        $this->assertTrue($wallet->getStatus());
        $this->assertEquals(0, $wallet->getAmount());
        $this->assertEquals(1, $wallet->getAccountId());
    }
}
