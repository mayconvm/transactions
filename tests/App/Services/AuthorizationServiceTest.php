<?php

namespace Tests\App\Services;

use Exception;
use Tests\TestCase;
use App\Services\AuthorizationService;
use App\Repository\AuthorizationRepository;
use App\Models\Transaction as TransactionModel;
use App\Models\Authorization as AuthorizationModel;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\AuthorizationProvider\AuthorizationProviderInterface;

class AuthorizationServiceTest extends TestCase
{
    public function setUp() : void
    {
        $this->mockAuthorizationProvider = \Mockery::mock(AuthorizationProviderInterface::class);
        $this->mockAuthorizationRepository = \Mockery::mock(AuthorizationRepository::class);

        $this->service = new AuthorizationService(
            $this->mockAuthorizationProvider,
            $this->mockAuthorizationRepository
        );
    }

    public function testCheckAuthorizationSuccess()
    {
        $transaction = new TransactionModel;
        ///////////////////////////
        // authorizationProvider //
        ///////////////////////////
        $this->mockAuthorizationProvider
            ->shouldReceive('checkAuthorization')
            ->with($transaction)
            ->once()
            ->andReturn(['message' => AuthorizationModel::MESSAGE_ALLOW])
        ;

        $entity = $this->service->checkAuthorization($transaction);
        $this->assertTrue($entity->allow());
        $this->assertEquals(AuthorizationModel::MESSAGE_ALLOW, $entity->getMessage());
    }

    public function testCheckAuthorizationUnSuccess()
    {
        $transaction = new TransactionModel;
        ///////////////////////////
        // authorizationProvider //
        ///////////////////////////
        $this->mockAuthorizationProvider
            ->shouldReceive('checkAuthorization')
            ->with($transaction)
            ->once()
            ->andReturn(['message' => AuthorizationModel::MESSAGE_DEFAULT])
        ;

        $entity = $this->service->checkAuthorization($transaction);
        $this->assertFalse($entity->allow());
        $this->assertEquals(AuthorizationModel::MESSAGE_DEFAULT, $entity->getMessage());
    }

    public function testSaveAuthorization()
    {
        $this->mockAuthorizationRepository
            ->shouldReceive('save')
            ->once()
            ->andReturn(true)
            ->getMock()
        ;

        $result = $this->service->saveAuthorization(new AuthorizationModel);
        $this->assertTrue($result);
    }
}
