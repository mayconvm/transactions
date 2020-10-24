<?php
/**
 * Classe Business
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Business;

use App\Business\Model\AccountInterface;

/**
 * Classe Account
 * @package App\Business
 */
class Account
{
    /**
     * Type person
     */
    const TYPE_PERSON = 'person';

    /**
     * Type Business
     */
    const TYPE_BUSINESS = 'business';

    /**
     * Create account
     * @param  AccountInterface $entity AccountInterface
     * @return AccountInterface
     */
    public function create(AccountInterface $entity) : AccountInterface
    {
        if ($entity->getType() === self::TYPE_BUSINESS) {
            $entity->setNotTransferValues(true);
        }

        return $entity;
    }

    /**
     * Update Account
     * @param  AccountInterface $entity Account Entity
     * @return AccountInterface
     */
    public function update(AccountInterface $entity) : AccountInterface
    {
    }
}
