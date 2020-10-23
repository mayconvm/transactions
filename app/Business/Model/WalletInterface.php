<?php

namespace App\Business\Model;

interface WalletInterface extends ModelInterface
{
    public function getAccount() : AccountInterface;
    public function getAmount() : float;
    // public function getAmountAvailable() : float;

    public function setAccountId(string $value) : void;
    public function setAmount(float $value) : void;
    public function setStatus(bool $value) : void;
}
