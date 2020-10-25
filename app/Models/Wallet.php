<?php
/**
 * Classe Models
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Business\Model\WalletInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Classe Transaction
 * @package App\Models
 */
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

    /**
     * Attributes to data
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation with Account
     * @return Model
     */
    protected function relationAccount()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
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
     * Update amount
     * @param  float $value Amount to update
     * @return void
     */
    public function updateAmout(float $value) : void
    {
        $this->amount += $value;
    }

    /**
     * Get Account
     * @return Account
     */
    public function getAccount() : Account
    {
        return $this->relationAccount;
    }

    /**
     * Get Amount
     * @return float
     */
    public function getAmount() : float
    {
        return $this->amount;
    }

    /**
     * Set Account id
     * @param int $value Account id
     */
    public function setAccountId(int $value) : void
    {
        $this->account_id = $value;
    }

    /**
     * Get Account id
     * @return int
     */
    public function getAccountId() : int
    {
        return $this->account_id;
    }

    /**
     * Set Amount
     * @param float $value Amout
     */
    public function setAmount(float $value) : void
    {
        $this->amount = $value;
    }

    /**
     * Set status wallet
     * @param bool $value Activer or not
     */
    public function setStatus(bool $value) : void
    {
        $this->status = $value;
    }

    /**
     * Get status wallet
     * @return bool
     */
    public function getStatus() : bool
    {
        return $this->status;
    }
}
