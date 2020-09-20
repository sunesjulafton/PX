<?php

namespace App;


use App\Permissions\HasPermissionsTrait;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //use Notifiable;
    use HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /* 
    protected $fillable = [
        'name', 'email', 'password', 'type', 'activated_at'
    ];
    */

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function accounts() {
        return $this->belongsToMany(Account::class)->withTimestamps();
    }

    public function websites() {
        return $this->belongsToMany(Website::class)->withTimestamps();
    }

    public function abtests() {
        return $this->hasMany(Abtest::class);
    }
}
