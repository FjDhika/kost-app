<?php

namespace App\Api\Modules\Availability\Entities\Interfaces;

use Illuminate\Http\Request;

interface AvailabilityRepositoryInterface
{
    public function askAvailability(Request $request);
    public function answerAvailability(Request $request);
    public function getAvailabilityByOwnerId(Request $request);
    public function getAvailabilityByUserId(Request $request);
    public function getAvailabilityById(Request $request);
}
