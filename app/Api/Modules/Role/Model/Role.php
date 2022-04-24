<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Api\Modules\User\Model\User;

class Role extends Model
{
    use HasFactory;

    public function Users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
