<?php

namespace Tests\App\Repository;

use Tests\TestCase;
use App\Models\Account as AccountModel;
use App\Repository\AccountRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountRepositoryTest extends TestCase
{
    public function setUp() : void
    {
        $this->mockAccountModel = \Mockery::mock(AccountModel::class);
        $this->repository = new AccountRepository($this->mockAccountModel);
    }

    public function testEmailExists()
    {
        $email = 'email@email.com';
        $this->mockAccountModel
            ->shouldReceive('find')
            ->with(['email' => $email])
            ->once()
            ->andReturn(new Collection([1]))
        ;

        $result = $this->repository->emailExists($email);
        $this->assertTrue($result);
    }

    public function testEmailNotExists()
    {
        $email = 'email@email.com';
        $this->mockAccountModel
            ->shouldReceive('find')
            ->with(['email' => $email])
            ->once()
            ->andReturn(new Collection())
        ;

        $result = $this->repository->emailExists($email);
        $this->assertFalse($result);
    }

    public function testSave()
    {
        $newAccountMock = \Mockery::mock(AccountModel::class)
            ->shouldReceive('save')
            ->once()
            ->andReturn(true)
            ->getMock()
        ;

        $result = $this->repository->save($newAccountMock);
        $this->assertTrue($result);
    }

    public function testgetAccountByIdSuccess()
    {
        $account = new AccountModel;
        $mockBuild = \Mockery::mock(Builder::class);

        $this->mockAccountModel
            ->shouldReceive('where')
            ->with(['id' => 1])
            ->once()
            ->andReturn($mockBuild)
        ;

        $mockBuild->makePartial()
            ->shouldReceive('firstOrFail')
            ->once()
            ->andReturn($account)
        ;

        $result = $this->repository->getAccountById(1);
        $this->assertEquals($account, $result);
    }

    public function testgetAccountByIdUnSuccess()
    {
        $this->expectException(ModelNotFoundException::class);
        $account = new AccountModel;
        $mockBuild = \Mockery::mock(Builder::class);

        $this->mockAccountModel
            ->shouldReceive('where')
            ->with(['id' => 1])
            ->once()
            ->andReturn($mockBuild)
        ;

        $mockBuild
            ->shouldReceive('firstOrFail')
            ->once()
            ->andThrow(new ModelNotFoundException)
        ;

        $result = $this->repository->getAccountById(1);
    }
}
