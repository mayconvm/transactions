<?php

namespace App\Repository;

use App\Models\Transaction;

class TransactionRepository
{
    private $table;

    public function __construct(Transaction $table)
    {
        $this->table = $table;
    }

    public function save(Transaction $entity) : bool
    {
        // transaction code
        if (empty($entity->getId())) {
            $entity->setTransactionCode($entity->getTransactionCode());
        }

        return $entity->save();
    }
}
