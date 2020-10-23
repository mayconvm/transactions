<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Business\Model\TransactionInterface;

class Transaction extends Model implements TransactionInterface
{
    use HasFactory;

    // public $status = true;

    private $walletPayee;

    private $walletPayer;


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

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setStatus(true);
    }

    public function walletPayer()
    {
        return $this->hasOne(Wallet::class, 'id', 'payer');
    }

    public function walletPayee()
    {
        return $this->hasOne(Wallet::class, 'id', 'payee');
    }

    public function getId() : ?string
    {
        return $this->id;
    }

    public function getPayer() : string
    {
        return $this->payer;
    }

    public function getPayee() : string
    {
        return $this->payee;
    }

    public function setPayer(string $value) : void
    {
        $this->payer = $value;
    }

    public function setPayee(string $value) : void
    {
        $this->payee = $value;
    }

    public function getValue() : float
    {
        return $this->value;
    }

    public function getTransactionCode() : string
    {
        return md5($this->getPayer() . $this->getPayee() . $this->getValue() . (string) $this->created_at);
    }

    public function setTransactionCode(string $value) : string
    {
        return $this->transaction_code = $value;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function setType(string $value) : void
    {
        $this->type = $value;
    }

    public function getStatus() : bool
    {
        return $this->status;
    }

    public function setValue($value) : void
    {
        $this->value = $value;
    }

    public function setStatus($value) : void
    {
        $this->status = $value;
    }

    public function setWalletPayee(Wallet $value) : void
    {
        $this->walletPayee = $value;
        $this->setPayee($value->getId());
    }

    public function setWalletPayer(Wallet $value) : void
    {
        $this->walletPayer = $value;
        $this->setPayer($value->getId());
    }

    public function getWalletPayer() : Wallet
    {
        return $this->walletPayer;
    }

    public function getWalletPayee() : Wallet
    {
        return $this->walletPayee;
    }
}
