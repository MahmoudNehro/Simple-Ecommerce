<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Helpers\MessageResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authentication\RegisterationRequest;
use App\Http\Resources\Authentication\UserResource;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;

class AuthenticationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterationRequest $request): Responsable
    {
        $validated = $request->validated();
        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;
        return new MessageResponse(
            message: 'Registered successfully',
            body: [
                'user' => UserResource::make($user),
                'token' => $token
            ],
        );
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): Responsable
    {
        auth()->user()?->currentAccessToken()?->delete();
        return new MessageResponse(
            message: 'Logged out successfully'
        );
    }
}
