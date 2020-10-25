<?php
/**
 * Classe BusinessModel
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Business\Model;

/**
 * Classe AccountInterface
 * @package App\Business\Model
 */
interface AccountInterface extends ModelInterface
{
    /**
     * Get Type account
     * @return string
     */
    public function getType() : string;

    /**
     * Set if account can transfer values or not
     * @param bool $value Can or no
     */
    public function setNotTransferValues(bool $value);

    /**
     * Check if account receive transfer
     * @return bool
     */
    public function getNotTransferValues() : bool;
}
