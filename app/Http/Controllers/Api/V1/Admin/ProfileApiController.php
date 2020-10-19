<?php


namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Requests\UpdatePasswordRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Profile
 * @authenticated
 */
class ProfileApiController
{
    public function changePassword(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());

        return response(null, Response::HTTP_ACCEPTED);
    }
}
