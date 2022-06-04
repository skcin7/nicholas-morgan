<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuccessfulLogin extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    public $table = 'successful_logins';

    /**
     * The model's default values for attributes.
     * @var array
     */
    protected $attributes = [
        'secret_data' => '',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'secret_data' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'secret_data',
    ];

    /**
     * A successful login must be associated with a user.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Set the secret data attribute.
     * @param $secret_data
     * @return void
     */
    public function setSecretDataAttribute($secret_data)
    {
//        $this->setAttribute('secret_data', encrypt(json_encode($secret_data)));
        $this->attributes['secret_data'] = encrypt(json_encode($secret_data));
    }

}
