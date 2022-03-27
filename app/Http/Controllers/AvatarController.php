<?php

namespace App\Http\Controllers;

use App\Http\Requests\Identification\AvatarRequest;

class AvatarController extends BaseController
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post  (
     *     path = "/user/avatar/update",
     *     summary = "Upload new avatar",
     *     description = "Upload / Update avatar",
     *     tags = {"Users"},
     *     @OA\RequestBody (
     *         required = true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="avatar",
     *                      description="image | min_width = 64px, min_height = 64px, ration = 1/1, mimes = jpg/png, max_size = 1024kb",
     *                      @OA\Schema(
     *                          type="string",
     *                          format="binary"
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response (
     *         response = 200,
     *         description = "Success response",
     *         @OA\JsonContent (
     *             @OA\Property (property = "message", type = "string", default = "success"),
     *             @OA\Property (property = "data", type = "object",
     *                  @OA\Property (property = "avatar_thumb", type = "string", description = "url to image")
     *             ),
     *         )
     *     ),
     *     @OA\Response (
     *         response = 422,
     *         description = "Wrong fields",
     *         @OA\JsonContent (
     *             @OA\Property (property = "message", type = "string"),
     *             @OA\Property (property = "errors", type = "array", @OA\Items())
     *         )
     *     )
     * )
     */
    public function update(AvatarRequest $request) {
        $media = auth()->user()->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        return $this->sendResponse([
            'avatar_thumb' => $media->getUrl('thumb')
        ]);
    }
}
