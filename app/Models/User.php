<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prefixname',
        'firstname',
        'middlename',
        'lastname',
        'suffixname',
        'username',
        'email',
        'password',
        'photo',
        'type',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return
            $this->firstname . ' ' .
            $this->middleInitial . ' ' .
            $this->lastname . ' ' .
            $this->suffixname;
    }

    /**
     * @return string
     */
    public function getAvatarAttribute(): string
    {
        $avatar = $this->photo ?? '/img/no-image.jpg';

        return asset($avatar);
    }

    /**
     * @return string
     */
    public function getMiddleInitialAttribute (): string
    {
        return strtoupper($this->middlename ? $this->middlename[0] . '.' : '');
    }
}
