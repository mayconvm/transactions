<?php

namespace App\Repository;

use App\Models\Wallet;

class WalletRepository
{
    private $table;

    public function __construct(Wallet $table)
    {
        $this->table = $table;
    }

    public function getWalletByAccountId(string $id) : Wallet
    {
        return $this->table->where(['account_id' => $id])->firstOrFail();
    }

    public function save(Wallet $entity) : bool
    {
        return $entity->save();
    }
}
