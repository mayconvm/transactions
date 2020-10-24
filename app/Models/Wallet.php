<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Business\Model\WalletInterface;

class Wallet extends Model implements WalletInterface
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'amount',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function relationAccount()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function getId() : ?string
    {
        return $this->id;
    }

    public function updateAmout($value)
    {
        $this->amount += $value;
    }

    public function getAccount() : Account
    {
        return $this->relationAccount;
    }

    public function getAmount() : float
    {
        return $this->amount;
    }

    public function setAccountId(string $value) : void
    {
        $this->account_id = $value;
    }

    public function getAccountId() : string
    {
        return $this->account_id;
    }

    public function setAmount(float $value) : void
    {
        $this->amount = $value;
    }

    public function setStatus(bool $value) : void
    {
        $this->status = $value;
    }


}
