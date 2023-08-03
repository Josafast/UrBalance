<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(Request $request){
        if (!Auth::guest()){
            return redirect()->route('dashboard');
        }

        return view('loginForm')->with('isRegister', $request->route()->uri == 'register');
    }

    public function login(Request $request){
        $remember = $request->has('remember');

        $credentials = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($credentials->fails()){
            return response()->json($credentials->errors(), 422);
        }

        if (!Auth::attempt($request->only(['email', 'password']), $remember)){
            return response()->json([
                'email' => [__('auth.failed')],
                'password' => [__('auth.password')]
            ], 422);
        }

        $request->session()->regenerate();
        $request->session()->put(
            'main',
            \App\Models\Balance::where('user_id',$request->user()->id)->where('main',"=",true)->first()->exchange_id
        );

        return response()->json(['link' => route('dashboard')], 200);
    }

    public function register(Request $request){
        $credentials = Validator::make($request->only(['name', 'email', 'paswword', 'password_confirmation']), [
            'name' => 'required|min:3|max:50|string',
            'email' => 'required|email|unique:users',
            'password' => ['confirmed', Password::defaults()]
        ]);

        if ($credentials->fails()){
            return response()->json($credentials->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        $request->merge(['userID' => $user->id]);

        $balanceCreateFunc = app()->make('App\Http\Controllers\BalanceController');
        $balanceCreateFunc->create($request);

        Auth::login($user);

        $request->session()->put('main',$request->exchange_id);
        return response()->json(['link' => route('dashboard')], 200);
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.view');
    }
}
