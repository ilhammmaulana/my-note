<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\WEB\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function viewLogin()
    {
        return view('admin.login');
    }
    public function login(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->only('email', 'password');
        if (!$user = auth()->attempt($credentials)) {
            return redirect()->back()->with('failed', 'Failed! Credentials wrong')->withInput();
        }
        $user = User::find(auth()->id());
        if ($user->role->id === 2) {
            auth()->logout();
            return redirect('auth/login')->with('failed', 'Login Failed! You not have permission to access the dashboard')->withInput();
        } else {
            return redirect('/users')->with('success', 'Successfully logged in to dashboard');
        }
    }
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/auth/login');
    }
}
