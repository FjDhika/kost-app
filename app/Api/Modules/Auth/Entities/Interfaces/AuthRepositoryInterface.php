<?php

namespace App\Api\Modules\Auth\Entities\Interfaces;

use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function register(Request $request, int $role_id);
    public function login(Request $request);
}
