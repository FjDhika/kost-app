<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use User;

class Role extends Model
{
    use HasFactory;

    public function Users(): HasMany
    {
        return $this->hasMany(User::class,'role_id','id');
    }
}
