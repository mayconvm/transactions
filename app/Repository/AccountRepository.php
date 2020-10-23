<?php

namespace App\Repository;

use App\Models\Account;

class AccountRepository
{
    private $table;

    public function __construct(Account $table)
    {
        $this->table = $table;
    }

    public function emailExists(string $email) : bool
    {
        return $this->table->find(['email' => $email])->count();
    }

    public function save(Account $entity) : bool
    {
        return $entity->save();
    }

    public function getAccountById(string $id) : Account
    {
        return $this->table->where(['id' => $id])->firstOrFail();
    }
}
