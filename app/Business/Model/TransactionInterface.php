<?php

namespace App\Business\Model;

interface TransactionInterface extends ModelInterface
{
    const TYPE_CREDIT = 'credit';

    const TYPE_DEBIT = 'debit';

    const TYPE_REVERT = 'revert';

    public function getTransactionCode() : string;
    public function getPayer() : string;
    public function getPayee() : string;
    public function getValue() : float;
    public function getType() : string;

    public function getStatus() : bool;
    public function getWalletPayer() : WalletInterface;
    public function getWalletPayee() : WalletInterface;
    public function getAuthorization() : ?AuthorizationInterface;

    public function setPayer(string $value) : void;
    public function setPayee(string $value) : void;
    public function setType(string $value) : void;

    // public function setWalletPayer(WalletInterface $value): void;
    // public function setWalletPayee(WalletInterface $value): void;
    // public function getStatus() : string;
}
