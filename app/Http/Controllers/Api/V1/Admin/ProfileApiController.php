<?php


namespace App\Http\Controllers\Api\V1\Admin;


use App\Http\Requests\UpdatePasswordRequest;
use App\User;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Profile
 * @authenticated
 */
class ProfileApiController
{
    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        auth()->user()->update($request->validated());

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
