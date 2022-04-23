<?php

namespace App\Api\Modules\Auth\Entities\Repositories;

use App\Api\Modules\Auth\Entities\Interfaces\AuthRepositoryInterface;
use App\Api\Modules\Auth\Model\User;
use App\Api\Modules\Role\Entities\Constant\RoleIdConstant;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthRepositoryInterface
{
    use ApiResponse;

    /**
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(Request $request, int $role_id)
    {
        $registered = $this->user->fill($request->all());
        $registered->password = bcrypt($registered->password);
        $registered->role_id = $role_id;

        if ($role_id == RoleIdConstant::PREMIUM) {
            $registered->credit = 40;
        } else if ($role_id == RoleIdConstant::REGULER) {
            $registered->credit = 20;
        }

        try {
            $registered->save();
            $token = $this->assignJwt($request);
            $result = $this->SuccessResponse('register success', ['token' => $token]);
        } catch (Exception $e) {
            $result = $this->InternalServerError($e->getMessage());
        }
        return $result;
    }

    public function login(Request $request)
    {
        $token = $this->assignJwt($request);
        return $this->SuccessResponse('login success', ['token' => $token]);
    }

    private function assignJwt(Request $request)
    {
        $credential = $request->only(['email', 'password']);
        try {
            $token = JWTAuth::attempt($credential);
            if (!$token) {
                throw new Exception("Failed To Assign Token");
            }
            $result = $token;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
        return $result;
    }
}
