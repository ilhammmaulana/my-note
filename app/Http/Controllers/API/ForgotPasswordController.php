<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\ResetPasswordRequest;
use App\Http\Requests\API\SendOTPForgotPasswordRequets;
use App\Http\Requests\API\VerifyOTPRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;

class ForgotPasswordController extends ApiController
{
    /**
     * Sending OTP To email 
     */
    public function sendOTP(SendOTPForgotPasswordRequets $sendOTPForgotPasswordRequets)
    {
        try {
            $input = $sendOTPForgotPasswordRequets->only('email');
            $user = User::where('email', $input['email'])->first();
            $randomOTP = generateOTP();
            $token = Str::random(50) . Carbon::now()->format('YmdHms');

            DB::table('password_resets')->insert([
                "token" => $token,
                "email" => $input['email'],
                "otp" => $randomOTP,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
            Mail::to($input['email'])->send(new ForgotPassword($input['email'], $user, $randomOTP));
            return $this->requestSuccess('Success!');
        } catch (ModelNotFoundException $th) {
            return $this->requestSuccess("If an account exists for " . $input['email'] . ", you will get an email with instructions on resetting your password. If it doesn't arrive, be sure to check your spam folder.");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Verify otp to get token
     */
    public function verifyOTP(VerifyOTPRequest $verifyOTPRequest)
    {
        try {
            $input = $verifyOTPRequest->only('email', 'otp');
            $token = DB::table('password_resets')
                ->where('email', $input['email'])
                ->where('otp', $input['otp'])
                ->first();
            if (!$token) {
                return $this->badRequest("otp_not_valid", "Failed!, OTP not valid");
            }
            if ($token->verified) {
                return $this->badRequest("otp_not_valid", "Failed!, OTP recent allready used ");
            }
            $expiresAt = Carbon::parse($token->created_at)->addMinutes(config('app.expired_token_otp'));
            if (Carbon::now()->gt($expiresAt)) {
                return $this->badRequest('otp_expired', 'OTP expired!');
            }
            DB::table('password_resets')
                ->where('email', $input['email'])
                ->where('token', $token->token)
                ->update([
                    "verified" => true
                ]);
            return $this->OTPSuccess($token->token);
        } catch (ModelNotFoundException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Reset password
     */
    public function resetPassword(ResetPasswordRequest $resetPasswordRequest)
    {
        try {
            $input = $resetPasswordRequest->only('token', 'password', 'confirm_password');
            $token = DB::table('password_resets')
                ->where('token', $input['token'])
                ->first();
            if (!$token) {
                return $this->badRequest('token_not_valid');
            }
            $expiresAt = Carbon::parse($token->created_at)->addMinutes(config('app.expired_token_otp'));
            if (Carbon::now()->gt($expiresAt)) {
                return $this->badRequest('token_expired', 'Token expired!');
            }
            DB::table('password_resets')
                ->where('token', $input['token'])
                ->update(['created_at' => Carbon::now()->subYears(10)]);
            User::where('email', $token->email)->update([
                "password" => bcrypt($input['password'])
            ]);
            return $this->requestSuccess();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
