<?php
/**
 * Classe BusinessModel
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Business\Model;

/**
 * Classe ModelInterface
 * @package App\Business\Model
 */
interface ModelInterface
{
    /**
     * Get entity id
     * @return int
     */
    public function getId() : ?int;
}
