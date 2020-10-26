<?php

namespace Tests\App\Repository;

use Tests\TestCase;
use App\Models\Transaction as TransactionModel;
use App\Repository\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionRepositoryTest extends TestCase
{

    public function setUp() : void
    {
        $this->mockModel = \Mockery::mock(TransactionModel::class);
        $this->repository = new TransactionRepository($this->mockModel);
    }

    public function testSave()
    {
        $newModelMock = \Mockery::mock(TransactionModel::class);

        $newModelMock->shouldReceive('getId')
            ->once()
            ->andReturn(null)
        ;

        $newModelMock->shouldReceive('getPayer')
            ->once()
            ->andReturn(1)
        ;

        $newModelMock->shouldReceive('getPayee')
            ->once()
            ->andReturn(1)
        ;

        $newModelMock->shouldReceive('getValue')
            ->once()
            ->andReturn(1)
        ;

        $code = md5(1 . 1 . 1 . time());
        $newModelMock->shouldReceive('setTransactionCode')
            ->with($code)
            ->andReturn(1)
        ;

        $newModelMock->shouldReceive('save')
            ->once()
            ->andReturn(true)
            ->getMock()
        ;

        $result = $this->repository->save($newModelMock);
        $this->assertTrue($result);
    }
}
