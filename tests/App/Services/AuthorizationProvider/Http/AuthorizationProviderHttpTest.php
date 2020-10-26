<?php

namespace Tests\App\Services;

use Exception;
use Tests\TestCase;
use App\Models\Transaction as TransactionModel;
use App\Models\Authorization as AuthorizationModel;
use App\Providers\Http\AdapterProviderInterface;
use App\Services\AuthorizationProvider\Http\AuthorizationProviderHttp;

class AuthorizationProviderHttpTest extends TestCase
{

    public function testRequestAuthorization()
    {
        $resultMock = ['message' => AuthorizationModel::MESSAGE_ALLOW];
        $mock = \Mockery::mock(AdapterProviderInterface::class);
        $mock->shouldReceive('send')
            // ->with()
            ->once()
            ->andReturn(json_encode($resultMock))
        ;

        $provider = new AuthorizationProviderHttp($mock);
        $result = $provider->checkAuthorization(new TransactionModel(['value' => 100]));

        $this->assertArrayHasKey('message', $result);
        $this->assertEquals($resultMock, $result);
    }

    public function testRequestAuthorizationWithResponseInvalid()
    {
        $mock = \Mockery::mock(AdapterProviderInterface::class);
        $mock->shouldReceive('send')
            // ->with()
            ->once()
            ->andReturn('response_invalid')
        ;

        $provider = new AuthorizationProviderHttp($mock);
        $result = $provider->checkAuthorization(new TransactionModel(['value' => 100]));

        $this->assertEmpty($result);
    }

    public function testSettings()
    {
        $mock = \Mockery::mock(AdapterProviderInterface::class);
        $provider = new AuthorizationProviderHttp($mock);
        $provider->setSettings([
            'set1' => 1,
            'set2' => 2,
        ]);

        $this->assertEquals(1, $provider->getSettings('set1'));
        $this->assertEquals(2, $provider->getSettings('set2'));
        $this->assertNull($provider->getSettings('set3'));

    }
}
