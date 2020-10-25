<?php
/**
 * Classe Repository
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Repository;

use App\Models\Account;

/**
 * Classe AccountRepository
 * @package App\Repository
 */
class AccountRepository
{
    /**
     * Model account
     * @var Account
     */
    private $table;

    /**
     * Method construct
     * @param Account $table Model account
     */
    public function __construct(Account $table)
    {
        $this->table = $table;
    }

    /**
     * Check if email exists
     * @param  string $email Email
     * @return bool
     */
    public function emailExists(string $email) : bool
    {
        return $this->table->find(['email' => $email])->count();
    }

    /**
     * Save entity
     * @param  Account $entity Account entity
     * @return bool
     */
    public function save(Account $entity) : bool
    {
        return $entity->save();
    }

    /**
     * Get account by id
     * @param  string $id Id account
     * @return Account
     */
    public function getAccountById(string $id) : Account
    {
        return $this->table->where(['id' => $id])->firstOrFail();
    }
}
