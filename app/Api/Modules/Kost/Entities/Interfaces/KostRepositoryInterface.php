<?php

namespace App\Api\Modules\Kost\Entities\Interfaces;

use Illuminate\Http\Request;

interface KostRepositoryInterface
{
    public function add(Request $request);
    public function update(Request $request);
    public function delete(Request $request);
    public function search(Request $request);
    public function kostById(Request $request);
    public function kostByUserId(Request $request);
}
