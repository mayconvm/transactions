<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use App\Business\Model\AccountModelInterface;

class Account extends Model implements AuthenticatableContract, AuthorizableContract, AccountModelInterface
{
    use Authenticatable, Authorizable, HasFactory;

    private $type = 'personal';

    private $transferValues = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'cpf', 'transferValues', 'transferValues'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function getType() : string
    {
        return $this->type;
    }

    public function setNotTransferValues(bool $value)
    {
        $this->transferValues = $value;
    }
}
