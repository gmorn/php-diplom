<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register()
    {
        return view("user.reg");
    }
    public function loginPost(AuthRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect("/");
        }
        return back();
    }
    public function registerPost(RegRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['images'] = '';
        $user = User::create($data);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect("/");
    }
    public function logout(Request $request) 
    {
        Auth::logout();
        $request->session()->regenerate();
        return redirect("/");
    }
    public function login()
    {
        return view("user.auth");
    }
}
