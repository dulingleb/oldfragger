<?php

namespace App\Http\Controllers;

use App\Http\Requests\Identification\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function update(UserUpdateRequest $request)
    {
        auth()->user()->update($request->only(['clan', 'standoff_id']));

        return $this->sendResponse('Updated Successfully');
    }
}
