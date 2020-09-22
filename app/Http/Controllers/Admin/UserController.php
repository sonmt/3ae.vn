<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use Illuminate\Http\Request;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class UserController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (!User::isManager($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();

        return View('admin.user.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required | unique:users',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect('users/create')
                ->withErrors($validation)
                ->withInput();
        }
        
        // insert to database
        $user = new User();
        $user->insert([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'image' => $request->input('image'),
            'name' => $request->input('name'),
            'role' => $request->input('role'),
        ]);

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return View('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'email' =>  Rule::unique('users')->ignore($user->id, 'id'),
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect(route('users.edit', ['id' => $user->id]))
                ->withErrors($validation)
                ->withInput();
        }

        $isChangePassword = $request->input('is_change_password');
        if ($isChangePassword == 1) {
            $user->update([
                'password' =>  bcrypt($request->input('password'))
            ]);
        }
        // insert to database
        $user->update([
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'image' => $request->input('image'),
            'name' => $request->input('name'),
            'role' => $request->input('role'),
        ]);

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::where('id', $user->id)->delete();

        return redirect('admin/users');
    }
}
