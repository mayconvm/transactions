<?php

namespace Tests\App\Repository;

use Tests\TestCase;
use App\Models\Authorization as AuthorizationModel;
use App\Repository\AuthorizationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorizationRepositoryTest extends TestCase
{
    public function setUp() : void
    {
        $this->mockAccountModel = \Mockery::mock(AuthorizationModel::class);
        $this->repository = new AuthorizationRepository($this->mockAccountModel);
    }

    public function testSave()
    {
        $newModelMock = \Mockery::mock(AuthorizationModel::class)
            ->shouldReceive('save')
            ->once()
            ->andReturn(true)
            ->getMock()
        ;

        $result = $this->repository->save($newModelMock);
        $this->assertTrue($result);
    }
}
