<?php
/**
 * Classe Models
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use App\Business\Model\TransactionInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Classe Transaction
 * @package App\Models
 */
class Transaction extends Model implements TransactionInterface
{
    use HasFactory;

    /**
     * Wallet Payee
     * @var Wallet
     */
    private $walletPayee;

    /**
     * Wallet Payer
     * @var Wallet
     */
    private $walletPayer;

    /**
     * Authorization
     * @var Authorization
     */
    private $authorization;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_code',
        'payee',
        'payer',
        'value',
        'type',
        'status',
        'comment',
    ];

    /**
     * Attributes to data
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Method construct
     * @param array $attributes Attributes to populate entity
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setStatus(true);
    }

    /**
     * Relation with Wallet
     * @return Model
     */
    public function walletPayer()
    {
        return $this->hasOne(Wallet::class, 'id', 'payer');
    }

    /**
     * Relation with wallet
     * @return Model
     */
    public function walletPayee()
    {
        return $this->hasOne(Wallet::class, 'id', 'payee');
    }

    /**
     * Relation with Authorization
     * @return Model
     */
    public function authorization()
    {
        return $this->hasOne(Authorization::class, 'transaction_id', 'id');
    }

    /**
     * Get Id
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Get id payer
     * @return int
     */
    public function getPayer() : int
    {
        return $this->payer;
    }

    /**
     * Get id payee
     * @return int
     */
    public function getPayee() : int
    {
        return $this->payee;
    }

    /**
     * Set payer id
     * @param int $value Id payer
     */
    public function setPayer(int $value) : void
    {
        $this->payer = $value;
    }

    /**
     * Set payee id
     * @param int $value Id payee
     */
    public function setPayee(int $value) : void
    {
        $this->payee = $value;
    }

    /**
     * Get transaction value
     * @return float
     */
    public function getValue() : float
    {
        return $this->value;
    }

    /**
     * Get transaction code
     * @return string
     */
    public function getTransactionCode() : string
    {
        return md5($this->getPayer() . $this->getPayee() . $this->getValue() . time());
    }

    /**
     * Set transaction code
     * @param string $value Transaction code
     */
    public function setTransactionCode(string $value) : string
    {
        return $this->transaction_code = $value;
    }

    /**
     * Get type transaction
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Set type transaction
     * @param string $value Type transaction
     */
    public function setType(string $value) : void
    {
        $this->type = $value;
    }

    /**
     * Get status transaction
     * @return bool
     */
    public function getStatus() : bool
    {
        return $this->status;
    }

    /**
     * Set Value
     * @param float $value Value transaction
     */
    public function setValue(float $value) : void
    {
        $this->value = $value;
    }

    /**
     * Set status
     * @param bool $value Status transaction
     */
    public function setStatus(bool $value) : void
    {
        $this->status = $value;
    }

    /**
     * Set Wallet Payee
     * @param Wallet $value Wallet to account
     */
    public function setWalletPayee(Wallet $value) : void
    {
        $this->walletPayee = $value;
        $this->setPayee($value->getId());
    }

    /**
     * Set Wallet Payer
     * @param Wallet $value Wallet to account
     */
    public function setWalletPayer(Wallet $value) : void
    {
        $this->walletPayer = $value;
        $this->setPayer($value->getId());
    }

    /**
     * Get wallet payer
     * @return Wallet
     */
    public function getWalletPayer() : Wallet
    {
        return $this->walletPayer;
    }

    /**
     * Get Wallet payee
     * @return Wallet
     */
    public function getWalletPayee() : Wallet
    {
        return $this->walletPayee;
    }

    /**
     * Get Authorization
     * @return AthorizarionInterface
     */
    public function getAuthorization() : ?Authorization
    {
        return $this->authorization;
    }

    /**
     * Set Authorization
     * @param Authorization $value Authorization entity
     * @return AthorizarionInterface
     */
    public function setAuthorization(Authorization $value) : void
    {
        $this->authorization = $value;
    }
}
