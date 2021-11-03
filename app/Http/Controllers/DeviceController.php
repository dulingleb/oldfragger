<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeviceCollection;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends BaseController
{
    public function find(Request $request)
    {
        if (!$request->exists('s') || strlen(trim($request->s)) < 3) {
            return $this->sendResponse([]);
        }

        $devices = Device::where('name', 'LIKE', '%'. $request->s . '%')->take(5)->get();

        return new DeviceCollection($devices);
    }
}
