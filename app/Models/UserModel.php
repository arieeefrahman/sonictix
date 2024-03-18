<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'users';
    protected $fillable = ['username', 'password', 'email', 'full_name'];
}
