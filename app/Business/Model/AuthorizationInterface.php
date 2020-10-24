<?php

namespace App\Business\Model;

interface AuthorizationInterface extends ModelInterface
{
    const MESSAGE_ALLOW = 'Autorizado';

    public function allow() : bool;
    public function getStatus() : bool;
    public function getMessage() : string;
}
