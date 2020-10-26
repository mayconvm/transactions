<?php

namespace Tests\App\Services;

use Exception;
use Tests\TestCase;
use App\Models\Transaction as TransactionModel;
use App\Models\Authorization as AuthorizationModel;
use App\Providers\Http\AdapterProviderInterface;
use App\Services\AuthorizationProvider\Http\AuthorizationProviderHttp;

use App\Providers\Http\AdapterProviderHttp;

class AdapterProviderHttpTest extends TestCase
{
    public function testRequest()
    {
        $resultMock = ['message' => AuthorizationModel::MESSAGE_ALLOW];
        $mock = \Mockery::mock(AdapterProviderHttp::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial()
        ;

        $mock->shouldReceive('getSettings')
            ->with('url')
            ->once()
        ;

        $mock->shouldReceive('getSettings')
            ->with('headers')
            ->once()
            ->andReturn(null)
        ;

        $provider = new AuthorizationProviderHttp($mock);
        $result = $provider->checkAuthorization(new TransactionModel(['value' => 100]));
    }

    public function testRequestWithHeaders()
    {
        $resultMock = ['message' => AuthorizationModel::MESSAGE_ALLOW];
        $mock = \Mockery::mock(AdapterProviderHttp::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial()
        ;

        $mock->shouldReceive('getSettings')
            ->with('url')
            ->once()
        ;

        $mock->shouldReceive('getSettings')
            ->with('headers')
            ->once()
            ->andReturn(['header_1' => 'result'])
        ;

        $provider = new AuthorizationProviderHttp($mock);
        $result = $provider->checkAuthorization(new TransactionModel(['value' => 100]));
    }

    public function testSettings()
    {
        $provider = new AdapterProviderHttp([
            'set1' => 1,
            'set2' => 2,
        ]);

        $this->assertEquals(1, $provider->getSettings('set1'));
        $this->assertEquals(2, $provider->getSettings('set2'));
        $this->assertNull($provider->getSettings('set3'));
    }
}
