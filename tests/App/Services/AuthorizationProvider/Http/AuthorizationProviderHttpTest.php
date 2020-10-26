<?php

namespace Tests\App\Services\AuthorizationProvider\Http;

use Tests\TestCase;
use App\Models\Account as AccountModel;
use App\Repository\AccountRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorizationProviderHttpTest extends TestCase
{
    // https://stackoverflow.com/questions/22355828/doing-http-requests-from-laravel-to-an-external-api
    // https://stackoverflow.com/questions/7911535/how-to-unit-test-curl-call-in-php
    public function testGetAuthorizationSucess()
    {
        // $http = $this->getMock('HttpRequest');
        // $http->expects($this->any())
        //      ->method('getInfo')
        //      ->will($this->returnValue('not JSON'));
        // $this->setExpectedException('HttpResponseException');
        // // create class under test using $http instead of a real CurlRequest
        // $fixture = new ClassUnderTest($http);
        // $fixture->get();
    }
    // public function testGetAuthorizationUnSucess()
}
