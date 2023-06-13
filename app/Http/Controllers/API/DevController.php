<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DevController extends ApiController
{
    public function sendEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required"
        ]);
        if ($validator->fails()) {
            return $this->requestValidation($validator->errors());
        }
        try {
            $input = $request->only('email');
            $idUser = "2930920393";
            Mail::to($input['email'])->send(new ForgotPassword($idUser, $input['email']));
            return response()->json([
                'code' => 200,
                'data' => 'data'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
