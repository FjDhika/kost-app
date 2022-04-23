<?php

namespace App\Api\Modules\Auth\Entities\Interfaces;

use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function register(Request $request);
    public function login(Request $request);
}
