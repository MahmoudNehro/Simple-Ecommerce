<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Enums\Http;
use App\Helpers\MessageResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authentication\LoginRequest;
use App\Http\Resources\Authentication\UserResource;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): Responsable
    {
        $validated = $request->validated();
        $email = data_get($validated, 'email');
        $password = data_get($validated, 'password');
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password) || $user->is_admin) {
            return new MessageResponse(
                message: 'Invalid credentials',
                code: Http::UNPROCESSABLE_ENTITY,
                errors: [
                    'email' =>   ['Invalid credentials']
                ]
            );
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return new MessageResponse(
            message: 'Logged in successfully',
            body: [
                'user' => UserResource::make($user),
                'token' => $token
            ],
        );
    }
}
