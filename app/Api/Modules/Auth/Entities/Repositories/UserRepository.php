<?php

namespace App\Api\Modules\Auth\Entities\Repositories;

use App\Api\Modules\Auth\Entities\Interfaces\UserRepositoryInterface;
use App\Api\Modules\Auth\Model\User;
use App\Api\Modules\Role\Entities\Constant\RoleIdConstant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function resetCredit()
    {
        try {
            $user = $this->user;
            DB::transaction(function () use ($user) {
                $user->where('role_id', RoleIdConstant::OWNER)->update(['credit' => 0]);
                $user->where('role_id', RoleIdConstant::PREMIUM)->update(['credit' => 40]);
                $user->where('role_id', RoleIdConstant::REGULER)->update(['credit' => 20]);
            }, 5);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
