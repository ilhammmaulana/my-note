<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\WEB\CreateUserRequest;
use App\Http\Requests\WEB\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private $userRepository;
    /**
     * Class constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admins.index', [
            "users" => $this->userRepository->getUser(1, auth()->id()),
            "total_user" => $this->userRepository->countUserByRole(1)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $createUserRequest)
    {
        try {
            $input = $createUserRequest->only('name', 'email', 'phone', 'password');
            $photo = $createUserRequest->file('photo');
            $input['password'] = bcrypt($input['password']);
            $input['role_id'] = 1;

            if ($photo) {
                $path = Storage::disk('public')->put('images/users', $photo);
                $input['photo'] = 'public/' . $path;
            }
            $this->userRepository->register($input);
            return redirect('admins')->with('success', 'Success create user friend_list');
        } catch (\Illuminate\Database\QueryException $errors) {
            if ($errors->errorInfo[1] === 1062) {
                if (strpos($errors->getMessage(), 'users_email_unique') !== false) {
                    return redirect('admins')->with('failed', 'Email  already registered!');
                } elseif (strpos($errors->getMessage(), 'users_phone_unique') !== false) {
                    return redirect('admins')->with('failed', 'Phone number already registered!');
                }
            } else {
                return $this->badRequest('Failed!', $errors->getMessage());
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $updateUserRequest, $id)
    {
        try {
            $input = $updateUserRequest->only('name', 'email', 'phone');
            $photo = $updateUserRequest->file('photo');
            $user = User::find($id);
            $user->fill($input);
            if ($photo) {
                $pathDelete = $user->photo;
                if ($pathDelete !== null) {
                    Storage::delete($pathDelete);
                }
                $path = Storage::disk('public')->put('images/users', $photo);
                $user->photo = 'public/' . $path;
            }

            $user->save();
            return redirect()->back()->with('success', 'Success update user');
        } catch (\Illuminate\Database\QueryException $th) {
            if ($th->errorInfo[1] === 1062) {
                if (strpos($th->getMessage(), 'users_email_unique') !== false) {
                    return redirect()->back()->with('failed', 'Phone number already registered!', 'phone_unique');
                }
            }
        } catch (\Throwable $th) {
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->userRepository->deleteUser($id);
            return redirect()->back()->with('success', 'Success delete user');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
