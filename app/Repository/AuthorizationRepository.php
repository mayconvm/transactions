<?php

namespace App\Repository;

use App\Models\Authorization;

class AuthorizationRepository
{
    private $table;

    public function __construct(Authorization $table)
    {
        $this->table = $table;
    }

    public function save(Authorization $entity) : bool
    {
        return $entity->save();
    }
}
