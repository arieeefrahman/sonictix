<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject as ContractsJWTSubject;

class User extends Authenticatable implements ContractsJWTSubject
{
    use HasFactory, HasUuids, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['username', 'password', 'email', 'full_name'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public static function rules($id = null)
    {
        if ($id === 'register') {
            return [
                'username'  => ['required', 'string', 'max:255', 'unique:users'],
                'password'  => ['required', 'string', 'min:8'],
                'full_name' => ['required', 'string', 'max:255'],
                'email'     => ['required', 'string', 'email', 'max:255', 'unique:users']
            ];
        } elseif ($id === 'login') {
            return [
                'username'  => ['required_without:email', 'nullable', 'string', 'max:255'],
                'password'  => ['required', 'string', 'max:100'],
                'email'     => ['required_without:username', 'nullable', 'string', 'email', 'max:255']
            ];
        }
    }
}
