<?php

namespace App\Http\Resources;

use App\Models\Device;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="UserResource",
 *     description="User resource",
 *     @OA\Xml(
 *         name="UserResource"
 *     )
 * )
 */
class UserResource extends JsonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     *
     * @return array
     * @var \App\Models\User[]
     */
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
