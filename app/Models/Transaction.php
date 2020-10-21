<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Business\Model\ModelInterface as ModelInterfaceBusiness;

class Transaction extends Model implements ModelInterfaceBusiness;
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'transaction_code', 'value'
    ];
}
