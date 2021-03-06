<?php

namespace App\Api\Modules\Auth\Controllers;

use App\Api\Modules\Auth\Entities\Repositories\AuthRepository;
use App\Api\Modules\Role\Entities\Constant\RoleIdConstant;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @var AuthRepository
     */
    private AuthRepository $authRepo;

    public function __construct(
        AuthRepository $authRepo
    ) {
        $this->authRepo = $authRepo;
    }

    private function register(Request $request, int $role_id)
    {
        $rules = [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users',
        ];
        $failedValidationMessage = [
            'name.required' => 'Sorry, but can we know your name?',
            'password.required' => 'Your password please',
            'email.required' => 'We need to know your email if you want to register!',
            'email.email' => 'Hmmm, your format email is unrecognized. Please check again.',
        ];

        $validator = Validator::make($request->all(), $rules, $failedValidationMessage);
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->authRepo->register($request, $role_id);
        return $result;
    }

    public function registerOwner(Request $request)
    {
        $result = $this->register($request, RoleIdConstant::OWNER);
        return $result;
    }

    public function registerRegular(Request $request)
    {
        $result = $this->register($request, RoleIdConstant::REGULER);
        return $result;
    }

    public function registerPremium(Request $request)
    {
        $result = $this->register($request, RoleIdConstant::PREMIUM);
        return $result;
    }

    public function login(Request $request)
    {
        $rules = [
            'password' => 'required|string',
            'email' => 'required|email',
        ];
        $failedValidationMessage = [
            'password.required' => 'Your password please',
            'email.required' => 'We need to know your email if you want to register!',
            'email.email' => 'Hmmm, your format email is unrecognized. Please check again.',
        ];

        $validator = Validator::make($request->all(), $rules, $failedValidationMessage);
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->authRepo->login($request);
        return $result;
    }
}
