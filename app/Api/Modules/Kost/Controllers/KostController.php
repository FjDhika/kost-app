<?php

namespace App\Api\Modules\Kost\Controllers;

use App\Api\Modules\Kost\Entities\Repositories\KostRepository;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KostController extends Controller
{

    use ApiResponse;

    /**
     * @var KostRepository
     */
    private KostRepository $kostRepo;

    public function __construct(KostRepository $kostRepo)
    {
        $this->kostRepo = $kostRepo;
    }

    public function add(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'location' => 'required|string',
            'price' => 'required|integer',
        ];
        $failedValidationMessage = [
            'name.required' => 'Sorry, but can we know your kost name?',
            'location.required' => 'Sorry, we need to know where your kost located',
            'price.required' => 'How much it kost to rent your kost?',
            'price.integer' => 'Looks like your price is not a number',
        ];

        $validator = Validator::make($request->all(), $rules, $failedValidationMessage);
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->kostRepo->add($request);
        return $result;
    }

    public function update(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
            'name' => 'string',
            'location' => 'string',
            'price' => 'integer',
        ];
        $failedValidationMessage = [
            'id.required' => 'We need to know which kost you want to update',
            'id.integer' => 'Looks like your id is not a number',
            'price.integer' => 'Looks like your price is not a number',
        ];

        $validator = Validator::make($request->all(), $rules, $failedValidationMessage);
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->kostRepo->update($request);
        return $result;
    }

    public function delete(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
        ];
        $failedValidationMessage = [
            'id.required' => 'We need to know which kost you want to delete',
            'id.integer' => 'Looks like your id is not a number',
        ];

        $validator = Validator::make($request->all(), $rules, $failedValidationMessage);
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->kostRepo->delete($request);
        return $result;
    }

    public function search(Request $request)
    {
        $rules = [
            'name' => 'string',
            'location' => 'string',
            'min_price' => 'integer',
            'max_price' => 'integer',
            'order_by' => Rule::in(['price']),
            'direction' => Rule::in(['asc', 'desc']),
        ];
        $failedValidationMessage = [
            'min_price.integer' => 'Looks like your min price is not a number',
            'max_price.integer' => 'Looks like your max price is not a number',
        ];

        $validator = Validator::make($request->all(), $rules, $failedValidationMessage);
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->kostRepo->search($request);
        return $result;
    }

    public function getById(Request $request)
    {
        $rules = [
            'kost_id' => 'numeric',
        ];
        $failedValidationMessage = [
            'kost_id.integer' => 'Looks like your kost id is not a number',
        ];

        $validator = Validator::make(
            $request->route()->parameters(),
            $rules,
            $failedValidationMessage
        );
        if ($validator->fails()) {
            return $this->BadRequestError($validator->errors());
        }

        $result = $this->kostRepo->kostById($request);
        return $result;
    }

    public function kostList(Request $request)
    {
        $result = $this->kostRepo->kostByUserId($request);
        return $result;
    }
}
