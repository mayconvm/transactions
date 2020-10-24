<?php
/**
 * Classe Models
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Business\Model\AuthorizationInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Classe Authorization
 * @package App\Models
 */
class Authorization extends Model implements AuthorizationInterface
{
    use HasFactory;

    /**
     * Set default value to attributes
     * @var array
     */
    protected $attributes = [
        'message' => 'STATE_LESS',
        'status' => false,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'message',
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
     * Method construct
     * @param array $attributes Attributes to populate entity
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(isset($attributes['message'])) {
            $this->getStatus();
        }
    }

    /**
     * Relation entity with transaction
     * @return Model
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }

    /**
     * Get Id authorization
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Check allow or no
     * @return bool
     */
    public function allow() : bool
    {
        return $this->getMessage() === self::MESSAGE_ALLOW;
    }

    /**
     * Get status authorization
     * @return bool
     */
    public function getStatus() : bool
    {
        if (!empty($this->status)) {
            return $this->status;
        }

        $this->status = $this->allow();

        return $this->status;
    }

    /**
     * Get authorization message
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Set transaction id
     * @param int $transactionId Transaction id
     */
    public function setTransactionId($transactionId) : void
    {
        $this->transaction_id = $transactionId;
    }
}
