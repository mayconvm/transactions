<?php
/**
 * Classe Repository
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Repository;

use App\Models\Wallet;

/**
 * Classe WalletRepository
 * @package App\Repository
 */
class WalletRepository
{
    /**
     * Model Authorization
     * @var Authorization
     */
    private $table;

    /**
     * Method construct
     * @param Wallet $table Model Wallet
     */
    public function __construct(Wallet $table)
    {
        $this->table = $table;
    }

    /**
     * Get Wallet by id
     * @param  int $id Id wallet
     * @return Wallet
     */
    public function getWalletByAccountId(int $id) : Wallet
    {
        return $this->table->where(['account_id' => $id])->firstOrFail();
    }

    /**
     * Save entity
     * @param  Wallet $entity Wallet entity
     * @return bool
     */
    public function save(Wallet $entity) : bool
    {
        return $entity->save();
    }
}
