<?php

namespace App\Http\Resources;

use App\Models\Device;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'clan' => $this->clan,
            'standoff_id' => $this->standoff_id,
            'device' => new DeviceResource($this->device)
        ];
    }
}
