<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DeviceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'success' => true,
            'data' => $this->collection,
        ];
    }
}
