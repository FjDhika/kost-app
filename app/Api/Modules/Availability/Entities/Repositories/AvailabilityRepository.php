<?php

namespace App\Api\Modules\Availability\Entities\Repositories;

use App\Api\Modules\Auth\Model\User;
use App\Api\Modules\Availability\Entities\Interfaces\AvailabilityRepositoryInterface;
use App\Api\Modules\Availability\Model\Availability;
use App\Api\Modules\Kost\Model\Kost;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AvailabilityRepository implements AvailabilityRepositoryInterface
{

    use ApiResponse;

    /**
     * @var Availability
     */
    private Availability $availability;

    /**
     * @var Kost
     */
    private Kost $kost;

    /**
     * @var User
     */
    private User $user;

    public function __construct(Availability $availability, Kost $kost, User $user)
    {
        $this->availability = $availability;
        $this->kost = $kost;
        $this->user = $user;
    }

    public function askAvailability(Request $request)
    {
        $user_id = Auth::user()->id;
        $kost_id = $request->get('kost_id');

        //find kost;
        $kost = $this->kost->find($kost_id);
        if (!$kost) {
            return $this->NotFoundError("Kost with id of " . $kost_id . " not found");
        }

        $owner_id = $kost->user_id;

        //find owner
        $owner = $this->user->find($owner_id);
        if (!$owner) {
            return $this->NotFoundError("Owner with id of " . $owner_id . " not found");
        }

        $availability = $this->availability->fill($request->all());
        $availability->owner_id = $owner_id;
        $availability->user_id = $user_id;

        $userModel = $this->user;
        try {
            DB::transaction(function () use ($user_id, $userModel, $availability) {
                //find user
                $user = $userModel->where('id', $user_id)->lockForUpdate()->first();
                if (!$user) {
                    throw new Exception("User with id of " . $user_id . " not found");
                }

                if ($user->credit < 5) {
                    throw new Exception("You doesnt have enough credit");
                }

                $user->credit -= 5;

                $user->save();
                $availability->save();
            }, 3);
            return $this->SuccessResponse("Success ask availabilty", $availability);
        } catch (Exception $e) {
            return $this->BadRequestError($e->getMessage());
        }
    }

    public function answerAvailability(Request $request)
    {
        $owner_id = Auth::user()->id;
        $availability_id = $request->get('availability_id');
        $is_available = $request->get('is_available');

        $availability = $this->availability->find($availability_id);
        if (!$availability) {
            return $this->NotFoundError("No availability question with id of " . $availability_id);
        }

        if ($availability->owner_id != $owner_id) {
            return $this->UnauthorizeError("Not Allowed to answer this question");
        }

        if (!is_null($availability->is_available)) {
            return $this->BadRequestError("The Question Already Answered");
        }

        try {
            $availability->is_available = $is_available;
            if (!$availability->save()) {
                throw new Exception("Failed when save answer");
            }
            return $this->SuccessResponse("Success Answer Question", $availability);
        } catch (Exception $e) {
            return $this->InternalServerError($e->getMessage());
        }
    }

    public function getAvailabilityById(Request $request)
    {
        $user_id = Auth::user()->id;
        $avail_id = $request->availability_id;

        $availability = $this->availability->find($avail_id);
        if (!$availability) {
            return $this->BadRequestError("Availability question with id of " . $avail_id . " not found");
        }

        if (!in_array($user_id, [$availability->user_id, $availability->owner_id])) {
            return $this->UnauthorizeError("Not Allowed to get availablity question");
        }

        return $this->SuccessResponse("Success to get availabiilty", $availability);
    }

    public function getAvailabilityByOwnerId(Request $request)
    {
        $owner_id = Auth::user()->id;
        $availability = $this->availability->where('owner_id', $owner_id)->get();
        return $this->SuccessResponse("Success to get availabiilty", $availability);
    }

    public function getAvailabilityByUserId(Request $request)
    {
        $user_id = Auth::user()->id;
        $availability = $this->availability->where('user_id', $user_id)->get();
        return $this->SuccessResponse("Success to get availabiilty", $availability);
    }
}
