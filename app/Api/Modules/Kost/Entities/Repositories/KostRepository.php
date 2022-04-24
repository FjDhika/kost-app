<?php

namespace App\Api\Modules\Kost\Entities\Repositories;

use App\Api\Modules\Kost\Entities\Interfaces\KostRepositoryInterface;
use App\Api\Modules\Kost\Model\Kost;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KostRepository implements KostRepositoryInterface
{

    use ApiResponse;

    /**
     * @var Kost
     */
    private Kost $kost;

    public function __construct(Kost $kost)
    {
        $this->kost = $kost;
    }

    public function add(Request $request)
    {
        $kost = $this->kost->fill($request->all());
        $kost->location = strtolower($kost->location);
        $kost->user_id = Auth::user()->id;

        try {
            $saved = $kost->save();
            if (!$saved) {
                $result = $this->BadRequestError("Failed to save kost");
            } else {
                $result = $this->SuccessResponse("Success add kost", $kost);
            }
        } catch (\Throwable $th) {
            $result = $this->BadRequestError($th->getMessage());
        }
        return $result;
    }

    public function update(Request $request)
    {
        $kost_id = $request->id;
        $kost = $this->kost->find($kost_id);
        if (!$kost) {
            return $this->NotFoundError("Kost with id of " . $kost_id . " not found");
        }

        if ($kost->user_id != Auth::user()->id) {
            return $this->UnauthorizeError("Not Allowed");
        }

        $kost->fill($request->all());
        try {
            $saved = $kost->save();
            if (!$saved) {
                $result = $this->BadRequestError("Failed to save kost");
            } else {
                $result = $this->SuccessResponse("Success update kost", $kost);
            }
        } catch (\Throwable $th) {
            $result = $this->BadRequestError($th->getMessage());
        }
        return $result;
    }

    public function delete(Request $request)
    {
        $kost_id = $request->id;
        $kost = $this->kost->find($kost_id);
        if (!$kost) {
            return $this->NotFoundError("Kost with id of " . $kost_id . " not found");
        }

        if ($kost->user_id != Auth::user()->id) {
            return $this->UnauthorizeError("Not Allowed");
        }

        try {
            $deleted = $kost->delete();
            if (!$deleted) {
                $result = $this->BadRequestError("Failed to save kost");
            } else {
                $result = $this->SuccessResponse("Success delete kost", $kost);
            }
        } catch (\Throwable $th) {
            $result = $this->BadRequestError($th->getMessage());
        }
        return $result;
    }

    public function search(Request $request)
    {
        $kost = $this->kost;
        if ($request->name) {
            $kost = $kost->filterName($request->name);
        }

        if ($request->location) {
            $kost = $kost->filterLocation($request->location);
        }

        if (!is_null($request->max_price) || !is_null($request->min_price)) {
            $kost = $kost->filterPrice($request->min_price, $request->max_price);
        }

        if (!is_null($request->order_by) || !is_null($request->direction)) {
            $kost = $kost->orderByProperty($request->order_by, $request->direction);
        }

        $searched = $kost->get();
        return $this->SuccessResponse("Success Retrieve Kost", $searched);
    }

    public function kostById(Request $request)
    {
        $kost_id = $request->kost_id;
        $kost = $this->kost->find($kost_id);
        if (!$kost) {
            return $this->NotFoundError("Kost with id of " . $kost_id . " not found");
        }
        return $this->SuccessResponse("Success retrieve kost", $kost);
    }

    public function kostByUserId(Request $request)
    {
        $user_id = Auth::user()->id;
        $kost = $this->kost->where('user_id', $user_id)->get();

        return $this->SuccessResponse("Success retrieve kost", $kost);
    }
}
