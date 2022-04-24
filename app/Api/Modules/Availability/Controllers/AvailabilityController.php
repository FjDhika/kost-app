<?php

namespace App\Api\Modules\Availability\Controllers;

use App\Api\Modules\Availability\Entities\Repositories\AvailabilityRepository;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvailabilityController extends Controller
{
    use ApiResponse;

    /**
     * @var AvailabilityRepository
     */
    private AvailabilityRepository $availabilityRepo;

    public function __construct(AvailabilityRepository $availabilityRepo)
    {
        $this->availabilityRepo = $availabilityRepo;
    }

    public function askAvailability(Request $request)
    {
        $rules = [
            'kost_id' => 'required|integer',
        ];
        $failedValidationMessage = [
            'kost_id.required' => 'Sorry, but can we know which kost you wanna ask?',
            'kost_id.integer' => 'It looks like your kost id is not a number',
        ];

        $validator = Validator::make($request->all(), $rules, $failedValidationMessage);
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->availabilityRepo->askAvailability($request);
        return $result;
    }

    public function answerAvailability(Request $request)
    {
        $rules = [
            'availability_id' => 'required|integer',
            'is_available' => 'required|boolean',
        ];
        $failedValidationMessage = [
            'is_available.required' => 'You had to answer the question',
        ];

        $validator = Validator::make($request->all(), $rules, $failedValidationMessage);
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->availabilityRepo->answerAvailability($request);
        return $result;
    }

    public function getAvailabilityById(Request $request)
    {
        $rules = [
            'availability_id' => 'required|integer',
        ];
        $failedValidationMessage = [
            'availability_id.required' => 'Which Availability Question you wanna see?',
        ];

        $validator = Validator::make(
            $request->route()->parameters(),
            $rules,
            $failedValidationMessage
        );
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->availabilityRepo->getAvailabilityById($request);
        return $result;
    }

    public function getAvailabilityByOwnerId(Request $request)
    {
        $result = $this->availabilityRepo->getAvailabilityByOwnerId($request);
        return $result;
    }

    public function getAvailabilityByUserId(Request $request)
    {
        $result = $this->availabilityRepo->getAvailabilityByUserId($request);
        return $result;
    }
}
