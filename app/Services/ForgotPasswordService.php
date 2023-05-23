<?php

interface ForgotPasswordServiceInterface
{
    public function sendOTP($email, $dataUser);
}


class ForgotPasswordService
{
    public function sendOTP($email, $dataUser)
    {
    }
}
