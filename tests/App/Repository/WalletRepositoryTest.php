<?php

namespace Tests\App\Repository;

use Tests\TestCase;
use App\Models\Wallet as WalletModel;
use App\Repository\WalletRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WalletRepositoryTest extends TestCase
{
    public function setUp() : void
    {
        $this->mockWalletModel = \Mockery::mock(WalletModel::class);
        $this->repository = new WalletRepository($this->mockWalletModel);
    }

    public function testSave()
    {
        $newModelMock = \Mockery::mock(WalletModel::class)
            ->shouldReceive('save')
            ->once()
            ->andReturn(true)
            ->getMock()
        ;

        $result = $this->repository->save($newModelMock);
        $this->assertTrue($result);
    }

    public function testgetWalletByAccountIdSuccess()
    {
        $model = new WalletModel;
        $mockBuild = \Mockery::mock(Builder::class);

        $this->mockWalletModel
            ->shouldReceive('where')
            ->with(['account_id' => 1])
            ->once()
            ->andReturn($mockBuild)
        ;

        $mockBuild->makePartial()
            ->shouldReceive('firstOrFail')
            ->once()
            ->andReturn($model)
        ;

        $result = $this->repository->getWalletByAccountId(1);
        $this->assertEquals($model, $result);
    }

    public function testgetWalletByAccountIdUnSuccess()
    {
        $this->expectException(ModelNotFoundException::class);

        $model = new WalletModel;
        $mockBuild = \Mockery::mock(Builder::class);

        $this->mockWalletModel
            ->shouldReceive('where')
            ->with(['account_id' => 1])
            ->once()
            ->andReturn($mockBuild)
        ;

        $mockBuild->makePartial()
            ->shouldReceive('firstOrFail')
            ->once()
            ->andThrow(new ModelNotFoundException)
        ;

        $result = $this->repository->getWalletByAccountId(1);
        $this->assertEquals($model, $result);
    }
}
