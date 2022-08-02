<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    public const IS_ADMIN = 1; // for admin
    public const IS_CUSTOMER = 2; // for customer

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
