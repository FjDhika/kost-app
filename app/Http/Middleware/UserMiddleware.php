<?php

namespace App\Http\Middleware;

use App\Api\Modules\Role\Entities\Constant\RoleIdConstant;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->role_id == RoleIdConstant::PREMIUM || Auth::user()->role_id == RoleIdConstant::REGULER)) {
            return $next($request);
        }
        return $this->UnauthorizeError('Not Allowed');
    }
}
