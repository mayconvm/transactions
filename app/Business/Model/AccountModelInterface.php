<?php

namespace App\Business\Model;

interface AccountModelInterface extends ModelInterface
{
    public function getType() : string;
    public function setNotTransferValues(bool $value);
}
