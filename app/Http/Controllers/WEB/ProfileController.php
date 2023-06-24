<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Repositories\SchoolRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $userRepository;

    /**
     * Class constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $user = $this->userRepository->getOne(auth()->id());
        return view('admin.profile.index', [
            "user" => $user,
        ]);
    }
}
