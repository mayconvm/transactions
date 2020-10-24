<?php
/**
 * Classe BusinessModel
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Business\Model;

/**
 * Classe TransactionInterface
 * @package App\Business\Model
 */
interface TransactionInterface extends ModelInterface
{
    /**
     * Type credit
     */
    const TYPE_CREDIT = 'credit';

    /**
     * Type revert
     */
    const TYPE_REVERT = 'revert';

    /**
     * Get transaction code
     * @return string
     */
    public function getTransactionCode() : string;

    /**
     * Get id payer
     * @return int
     */
    public function getPayer() : int;

    /**
     * Get id payee
     * @return int
     */
    public function getPayee() : int;

    /**
     * Get transaction value
     * @return float
     */
    public function getValue() : float;

    /**
     * Get type transaction
     * @return string
     */
    public function getType() : string;

    /**
     * Get status transaction
     * @return bool
     */
    public function getStatus() : bool;

    /**
     * Set payer id
     * @param int $value Id payer
     */
    public function setPayer(int $value) : void;

    /**
     * Set payee id
     * @param int $value Id payee
     */
    public function setPayee(int $value) : void;

    /**
     * Set type transaction
     * @param string $value Type transaction
     */
    public function setType(string $value) : void;

    /**
     * Get wallet payer
     * @return WalletInterface
     */
    public function getWalletPayer() : WalletInterface;

    /**
     * Get Wallet payee
     * @return WalletInterface
     */
    public function getWalletPayee() : WalletInterface;

    /**
     * Set Wallet Payer
     * @param WalletInterface $value Wallet to account
     */
    // public function setWalletPayer(WalletInterface $value) : void;

    /**
     * Set Wallet Payee
     * @param WalletInterface $value Wallet to account
     */
    // public function setWalletPayee(WalletInterface $value) : void;

    /**
     * Get Authorization
     * @return AthorizarionInterface
     */
    public function getAuthorization() : ?AuthorizationInterface;
}
