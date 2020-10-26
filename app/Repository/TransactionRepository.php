<?php
/**
 * Classe Repository
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Repository;

use App\Models\Transaction;

/**
 * Classe TransactionRepository
 * @package App\Repository
 */
class TransactionRepository
{
    /**
     * Model Authorization
     * @var Authorization
     */
    private $table;

    /**
     * Method construct
     * @param Transaction $table Model Transaction
     */
    public function __construct(Transaction $table)
    {
        $this->table = $table;
    }

    /**
     * Save entity
     * @param  Transaction $entity Transaction entity
     * @return bool
     */
    public function save(Transaction $entity) : bool
    {
        // transaction code
        if (empty($entity->getId())) {
            $entity->setTransactionCode(
                md5($entity->getPayer() . $entity->getPayee() . $entity->getValue() . time())
            );
        }

        return $entity->save();
    }
}
