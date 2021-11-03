<?php

namespace App\Http\Resources;

use App\Models\Device;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'os' => Device::OS[$this->os]
        ];
    }
}
