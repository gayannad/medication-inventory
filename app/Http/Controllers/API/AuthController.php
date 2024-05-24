<?php

namespace App\Http\Controllers\API;

use App\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    use ApiHelper;

    /**
     * user register
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            Log::info('User created', ['id' => $user->id, 'username' => $user->username]);

            return $this->onSuccess($user, 'User created successfully!');
        } catch (\Exception $e) {
            Log::error('User create failed! - '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * user login
     *
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function login(LoginRequest $request)
    {
        try {
            if (! Auth::attempt($request->only('username', 'password'))) {
                Log::error('Login Failed !,The provided credentials are incorrect');

                return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, 'Login Failed !,The provided credentials are incorrect');
            }

            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                $user = User::where('username', $request->username)->first();
                $token = $user->createToken('auth_token')->plainTextToken;
                $user->auth_token = $token;
                $user->token_type = 'Bearer';

                Log::info('User login successfully!', ['id' => $user->id, 'username' => $user->username]);

                return $this->onSuccess($user, 'User login successfully!');

            }
        } catch (\Exception $e) {
            Log::error('Login failed! - '.$e->getMessage());

            return $this->onError(ResponseAlias::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
