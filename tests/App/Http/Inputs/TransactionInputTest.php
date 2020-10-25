<?php

namespace Tests\App\Http\Inputs;

use Tests\TestCase;
use App\Http\Inputs\TransactionInput;

class TransactionInputTest extends TestCase
{
    public function testRulesToValidate()
    {
        $inputs = new TransactionInput;
        $rules = $inputs->rules();

        $this->assertIsArray($rules);
        $this->assertCount(3, $rules);
    }

    public function testInputValid()
    {
        $data = [
            'value' => 100,
            'payer' => 1,
            'payee' => 2,
        ];

        $inputs = new TransactionInput([], [], [], [], [], [], json_encode($data));
        $result = $inputs->valid();
        $this->assertTrue($result);
        $this->assertEmpty($inputs->getErrors());
    }

    public function testInputWithoutPayee()
    {
        $data = [
            'value' => 100,
            'payer' => 1,
        ];

        $inputs = new TransactionInput([], [], [], [], [], [], json_encode($data));
        $result = $inputs->valid();

        $this->assertFalse($result);

        $errors = $inputs->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertCount(1, $errors);
        $this->assertArrayHasKey('payee', $errors);
    }

    public function testInputWithoutPayeePayer()
    {
        $data = [
            'value' => 100,
        ];

        $inputs = new TransactionInput([], [], [], [], [], [], json_encode($data));
        $result = $inputs->valid();

        $this->assertFalse($result);

        $errors = $inputs->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertCount(2, $errors);
        $this->assertArrayHasKey('payee', $errors);
        $this->assertArrayHasKey('payer', $errors);
    }

    public function _testInputWithoutPayeePayerValue()
    {
        $inputs = new TransactionInput();
        $result = $inputs->valid();

        $this->assertFalse($result);

        $errors = $inputs->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertCount(3, $errors);
        $this->assertArrayHasKey('payee', $errors);
        $this->assertArrayHasKey('payer', $errors);
        $this->assertArrayHasKey('value', $errors);
    }
}
