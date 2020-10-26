<?php

namespace Tests\App\Controller;

use Tests\TestCase;
use App\Business\Account as AccountBusiness;

class AccountControllerTest extends TestCase
{
    public function testCreateNewAccountPerson()
    {
        $data = [
            "name" => "name test",
            "document" => rand() . "14253678955",
            "email" => rand() . "email@email.com",
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/account', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();

        $responseArray = $response->json();
        $this->assertArrayHasKey('type', $responseArray);
        $this->assertArrayHasKey('name', $responseArray);
        $this->assertArrayHasKey('document', $responseArray);
        $this->assertArrayHasKey('email', $responseArray);
        $this->assertArrayHasKey('updated_at', $responseArray);
        $this->assertArrayHasKey('created_at', $responseArray);

        $this->assertEquals(AccountBusiness::TYPE_PERSON, $responseArray['type']);
        $this->assertEquals($data['name'], $responseArray['name']);
        $this->assertEquals($data['document'], $responseArray['document']);
        $this->assertEquals($data['email'], $responseArray['email']);
    }

    public function testCreateNewAccountBusiness()
    {
        $data = [
            "name" => "name test",
            "document" => rand() . "14253678955",
            "email" => rand() . "email@email.com",
            "type" => "business",
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/account', [], [], [], $headers, json_encode($data));
        $this->assertResponseOk();

        $responseArray = $response->json();
        $this->assertArrayHasKey('type', $responseArray);
        $this->assertArrayHasKey('name', $responseArray);
        $this->assertArrayHasKey('document', $responseArray);
        $this->assertArrayHasKey('email', $responseArray);
        $this->assertArrayHasKey('updated_at', $responseArray);
        $this->assertArrayHasKey('created_at', $responseArray);

        $this->assertEquals(AccountBusiness::TYPE_BUSINESS, $responseArray['type']);
        $this->assertEquals($data['name'], $responseArray['name']);
        $this->assertEquals($data['document'], $responseArray['document']);
        $this->assertEquals($data['email'], $responseArray['email']);
    }

    public function testCreateNewAccountWithoutEmail()
    {
        $data = [
            "name" => "name test",
            "document" => rand() . "14253678955",
            "type" => "business",
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/account', [], [], [], $headers, json_encode($data));
        $this->seeStatusCode(422);

        $responseArray = $response->json();
        $this->assertArrayHasKey('email', $responseArray);
        $this->assertArrayNotHasKey('name', $responseArray);
        $this->assertArrayNotHasKey('document', $responseArray);
    }

    public function testCreateNewAccountWithoutEmailName()
    {
        $data = [
            "document" => rand() . "14253678955",
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/account', [], [], [], $headers, json_encode($data));
        $this->seeStatusCode(422);

        $responseArray = $response->json();
        $this->assertArrayHasKey('email', $responseArray);
        $this->assertArrayHasKey('name', $responseArray);
        $this->assertArrayNotHasKey('document', $responseArray);
    }

    public function testCreateNewAccountWithoutEmailNameDocument()
    {
        $data = [
            "type" => "business",
        ];
        $headers = [ 'CONTENT_TYPE' => 'application/json' ];

        $response = $this->call('POST', '/account', [], [], [], $headers, json_encode($data));
        $this->seeStatusCode(422);

        $responseArray = $response->json();
        $this->assertArrayHasKey('email', $responseArray);
        $this->assertArrayHasKey('name', $responseArray);
        $this->assertArrayHasKey('document', $responseArray);
    }
}
