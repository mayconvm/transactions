<?php
/**
 * Classe Models
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Models;

use App\Business\Account as AccountBusiness;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use App\Business\Model\AccountInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * Classe Account
 * @package App\Models
 */
class Account extends Model implements AuthenticatableContract, AuthorizableContract, AccountInterface
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * If allow transfer values
     * @var bool
     */
    private $transferValues;

    /**
     * Set default value to attributes
     * @var array
     */
    protected $attributes = [
        'type' => AccountBusiness::TYPE_PERSON,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'document',
        'type',
        'transferValues'
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
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get Id
     * @return id
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Get Type account
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Set if possible or not execute transfer
     * @param bool $value Value to parameter
     */
    public function setNotTransferValues(bool $value)
    {
        $this->transferValues = $value;
    }
}
