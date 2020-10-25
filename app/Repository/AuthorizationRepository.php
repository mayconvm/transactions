<?php
/**
 * Classe Repository
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Repository;

use App\Models\Authorization;

/**
 * Classe AuthorizationRepository
 * @package App\Repository
 */
class AuthorizationRepository
{
    /**
     * Model Authorization
     * @var Authorization
     */
    private $table;

    /**
     * Method construct
     * @param Authorization $table Model Authorization
     */
    public function __construct(Authorization $table)
    {
        $this->table = $table;
    }

    /**
     * Save entity
     * @param  Authorization $entity Authorization entity
     * @return bool
     */
    public function save(Authorization $entity) : bool
    {
        return $entity->save();
    }
}
