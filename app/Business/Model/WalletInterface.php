<?php
/**
 * Classe BusinessModel
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Business\Model;

/**
 * Classe WalletInterface
 * @package App\Business\Model
 */
interface WalletInterface extends ModelInterface
{
    /**
     * Get account
     * @return AccountInterface
     */
    public function getAccount() : AccountInterface;

    /**
     * Get Amount
     * @return float
     */
    public function getAmount() : float;

    /**
     * Get Account id
     * @return int
     */
    public function getAccountId() : int;

    /**
     * Set Account id
     * @param int $value Account id
     */
    public function setAccountId(int $value) : void;

    /**
     * Set Amount
     * @param float $value Amout
     */
    public function setAmount(float $value) : void;

    /**
     * Set status wallet
     * @param bool $value Activer or not
     */
    public function setStatus(bool $value) : void;

    /**
     * Get status wallet
     * @return bool
     */
    public function getStatus() : bool;
}
