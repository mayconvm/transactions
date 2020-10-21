<?php

namespace App\Business;

use App\Business\Model\ModelInterface;

class Account
{
    const TYPE_PERSON = 'person';

    const TYPE_BUSINESS = 'business';


    public function create(ModelInterface $entity) : ModelInterface
    {
        if ($entity->getType() === self::TYPE_BUSINESS) {
            $entity->setNotTransferValues(true);
        }

        return $entity;
    }

    public function update(ModelInterface $entity) : ModelInterface
    {
    }
}
