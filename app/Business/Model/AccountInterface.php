<?php

namespace App\Business\Model;

interface AccountInterface extends ModelInterface
{
    const TYPE_PERSON = 'person';

    const TYPE_BUSINESS = 'business';

    public function getType() : string;
    public function setNotTransferValues(bool $value);
    // public function getWallet() : WalletInterface;
}
