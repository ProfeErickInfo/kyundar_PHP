<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\Hash;

/**
 * User Model
 * 
 * Eloquent model for the wx25_usu table.
 * Represents system users (clubs, admins, etc.)
 */
class User extends Model implements AuthenticatableContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wx25_usu';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipoU',
        'id_asocc',
        'nickz',
        'pazz',
        'password',
        'fec_reg',
        'estado',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'pazz',
        'password',
    ];

    /**
     * Get the password for authentication.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the organizacion that owns the user.
     */
    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class, 'id_asocc', 'id');
    }

    // Implement Authenticatable interface methods
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Not using remember token
    }

    public function getRememberTokenName()
    {
        return null;
    }
}
