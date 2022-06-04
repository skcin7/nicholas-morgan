<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\SuccessfulLogin;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use SoftDeletes;

    /**
     * The database table used by the model.
     * @var string
     */
    public $table = 'users';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'email' => '',
        'is_mastermind' => false,
        'secret_data' => '',
        'last_login_at' => null,
        'login_count' => 0,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_mastermind' => 'boolean',
        'secret_data' => 'string',
        'last_login_at' => 'datetime',
        'login_count' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'is_mastermind',
        'secret_data',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Determine if user is a mastermind.
     * @return bool
     */
    public function isMastermind(): bool
    {
        return (bool) $this->getAttribute('is_mastermind');
    }

    /**
     * A user can have many successful logins.
     * @return HasMany
     */
    public function successfulLogins(): HasMany
    {
        return $this->hasMany('App\SuccessfulLogin');
    }

//    /**
//     * Set the secret data attribute.
//     * @param $secret_data
//     * @return void
//     */
//    public function setSecretDataAttribute($secret_data)
//    {
//        $this->setAttribute('secret_data', encrypt(json_encode($secret_data)));
//    }

    /**
     * Store a successful login about this user.
     * @param $secret_data
     * @return void
     */
    public function storeSuccessfulLogin($secret_data)
    {
        $successful_login = new SuccessfulLogin();
        $successful_login->user()->associate($this);
//        $successful_login->secret_data = $secret_data;
        $successful_login->setAttribute('secret_data', $secret_data);
        $successful_login->save();
    }
}
