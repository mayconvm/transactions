<?php

namespace Tests\App\Http\Inputs;

use Tests\TestCase;
use App\Http\Inputs\AccountInput;

class AccountInputTest extends TestCase
{
    public function testRulesToValidate()
    {
        $inputs = new AccountInput;
        $rules = $inputs->rules();

        $this->assertIsArray($rules);
        $this->assertCount(3, $rules);
    }

    public function testInputValid()
    {
        $data = [
            'name' => 'NAME_TEST',
            'email' => rand() . 'email@email.com',
            'document' => '123123123',
        ];

        $inputs = new AccountInput($data);
        $result = $inputs->valid();
        $this->assertTrue($result);
        $this->assertEmpty($inputs->getErrors());
    }

    public function testInputWithoutEmail()
    {
        $data = [
            'name' => 'NAME_TEST',
            'document' => '123123123',
        ];

        $inputs = new AccountInput($data);
        $result = $inputs->valid();

        $this->assertFalse($result);

        $errors = $inputs->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertCount(1, $errors);
        $this->assertArrayHasKey('email', $errors);
    }

    public function testInputWithoutNameAndEmail()
    {
        $data = [
            'document' => '123123123',
        ];

        $inputs = new AccountInput($data);
        $result = $inputs->valid();

        $this->assertFalse($result);

        $errors = $inputs->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertCount(2, $errors);
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('name', $errors);
    }

    public function _testInputWithoutDocumentEmailName()
    {
        $inputs = new AccountInput();
        $result = $inputs->valid();

        $this->assertFalse($result);

        $errors = $inputs->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertCount(3, $errors);
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('document', $errors);
    }
}
