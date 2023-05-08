<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegiesterRequest;
use App\Http\Requests\API\UpdatePasswordRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\JWTResponse;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Storage;

class AuthController extends ApiController
{
    use ResponseAPI, JWTResponse;
    public function __construct()
    {
        $this->middleware('auth.api', ['except' => ['login', 'refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $loginRequest)
    {
        $statusDeviceToken = false;
        if ($device_token = $loginRequest->header('device_token')) {
            $statusDeviceToken = true;
        }
        $credentials = $loginRequest->only('email', 'password');
        $expiresIn = $loginRequest->input('expires_in') ?: config('jwt.ttl');

        if (!$token = $this->guard()->setTTL($expiresIn)->attempt($credentials)) {
            return $this->requestUnauthorized('Login Failed! ,Email or phone number and password is incorrect');
        }
        if ($statusDeviceToken) {
            User::find($this->guard()->id())->update([
                "device_token" => $device_token,
            ]);
            return $this->respondWithToken($token);
        } else {
            return $this->badRequest('Failed!, should be using device token');
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->requestSuccessData('Success!', new UserResource($this->guard()->user()));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();
        return $this->requestSuccess('Success Logout!');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $expiresIn = (int)request('expires_in') ?: config('jwt.ttl');
        try {
            return $this->requestRefreshToken($this->guard()->setTTL($expiresIn)->refresh());
        } catch (\Throwable $th) {
            return $this->handleTokenBlacklList();
        }
    }
    public function updatePassword(UpdatePasswordRequest $updatePasswordRequest)
    {
        $input = $updatePasswordRequest->only('new_password', 'old_password', 'password_confirmation');
        $credentials = [
            "email" => $this->guard()->user()->email,
            "password" => $input['old_password']
        ];
        if (!$this->guard()->attempt($credentials)) {
            return $this->requestUnauthorized('Failed!, Old password wrong');
        }
        $newPassword = bcrypt($input['new_password']);
        User::find($this->guard()->id())->update([
            "password" => $newPassword
        ]);
        return $this->requestSuccess('Success!');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->loginSuccess(new UserResource($this->guard()->user()), $token);
    }
    public function register(RegiesterRequest $regiesterRequest)
    {
        $input = $regiesterRequest->only('name', 'email', 'phone', 'password', 'confirm_password');
        $input['password'] = bcrypt($input['password']);
        unset($input['confirm_password']);
        try {
            User::create($input);
            return response()->json([
                "code" => 201,
                "message" => 'Register Success!',
            ], 201);
        } catch (\Throwable $errors) {
            return $this->badRequest('Failed!', 'bad_request');
        }
    }

    public function update(UpdateProfileRequest $updateProfileRequest)
    {
        $photo = $updateProfileRequest->file('photo');
        $banner = $updateProfileRequest->file('banner_photo');
        try {
            $user = User::find($this->guard()->id());

            if ($updateProfileRequest->hasAny('email', 'phone') && !$updateProfileRequest->hasAny('name', 'school_id', 'banner', 'photo')) {
                $input = $updateProfileRequest->only('phone', 'email');
                $user->phone = $input['phone'];
                $user->email = $input['email'];
            } elseif ($updateProfileRequest->hasAny('name', 'school_id') && !$updateProfileRequest->hasAny('email', 'phone')) {
                if ($photo) {
                    $pathDelete = $user->photo;
                    if ($pathDelete !== null) {
                        Storage::delete($pathDelete);
                    }
                    $path = Storage::disk('public')->put('images/users', $photo);
                    $user->photo = 'public/' . $path;
                }
                if ($banner) {
                    $pathDelete = $user->banner_photo;
                    if ($pathDelete !== null) {
                        Storage::delete($pathDelete);
                    }
                    $path = Storage::disk('public')->put('images/banner', $banner);
                    $user->banner_photo = 'public/' . $path;
                }
                $input = $updateProfileRequest->only('name', 'school_id');
                $user->name = $input['name'];
                $user->school_id = $input['school_id'];
            } else {
                return $this->badRequest('Failed!, Please enter the rules', 'rules_validation');
            }
            $user->save();
            return $this->requestSuccess('Success!', 200);
        } catch (\Illuminate\Database\QueryException $errors) {
            if ($errors->errorInfo[1] === 1062) {
                if (strpos($errors->getMessage(), 'users_phone_unique') !== false) {
                    return $this->badRequest('Phone number already registered!', 'phone_unique');
                } elseif (strpos($errors->getMessage(), 'users_email_unique') !== false) {
                    return $this->badRequest('Email already used!', 'email_unique');
                }
            }
        }
    }
}
