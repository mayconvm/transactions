<?php

namespace App\Models;

use App\Business\Model\AuthorizationInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Authorization extends Model implements AuthorizationInterface
{
    use HasFactory;

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

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(isset($attributes['message'])) {
            $this->getStatus();
        }
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function allow() : bool
    {
        return $this->getMessage() === self::MESSAGE_ALLOW;
    }

    public function getStatus() : bool
    {
        if (!empty($this->status)) {
            return $this->status;
        }

        $this->status = $this->allow();

        return $this->status;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function setTransactionId($transactionId) : void
    {
        $this->transaction_id = $transactionId;
    }
}
