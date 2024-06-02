<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegRequest;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
    public function userProduct()
    {
        $user = auth()->user();
        $products = Product::where('userId', $user->id)->get();

        return view('user.user-products', compact('user', 'products'));
    }
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            if ($user->images) {
                Storage::disk('public')->delete($user->images);
            }
            $user->images = $avatarPath;
            $user->save();

            return response()->json(['success' => true, 'avatar' => $avatarPath]);
        }

        return response()->json(['success' => false]);
    }
    public function settings() {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',
            'password' => 'nullable|min:6',
        ], [
            'phone_number.unique' => 'Номер уже занят другим пользователем',
            'min' => 'Минимальная длина пароля 6 символов',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->number = $request->number;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('settings');
    }

    public function userPage($id)
    {
        $user = User::with('products')->findOrFail($id); // Загружаем пользователя вместе с его товарами
        return view('user.user-page', compact('user'));
    }

    public function userReviewsPage($userId)
    {
        $reviews = Review::where('seller_id', $userId)->with('reviewer')->get();
        $user = User::find($userId);

        return view('user.user-page-reviews', compact('reviews', 'user'));
    }
    public function userProductsPage($userId)
    {
        $products = Product::where('userId', $userId)->get();
        $user = User::find($userId);

        return view('user.user-page-products', compact('products', 'user'));
    }
}
