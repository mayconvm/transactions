<?php
/**
 * Classe BusinessModel
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Business\Model;

/**
 * Classe AuthorizationInterface
 * @package App\Business\Model
 */
interface AuthorizationInterface extends ModelInterface
{
    /**
     * Message to allow transaction
     */
    const MESSAGE_ALLOW = 'Autorizado';

    /**
     * Message default
     */
    const MESSAGE_DEFAULT = 'Não Autorizado';

    /**
     * Check allow or no
     * @return bool
     */
    public function allow() : bool;

    /**
     * Get status authorization
     * @return bool
     */
    public function getStatus() : bool;

    /**
     * Get authorization message
     * @return string
     */
    public function getMessage() : string;
}
