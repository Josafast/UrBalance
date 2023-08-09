<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function index(Request $request){
        if (!Auth::guest()){
            return redirect()->route('dashboard');
        }

        return view('loginForm')->with('isRegister', $request->route()->uri == 'register');
    }

    public function login(Request $request){
        app()->make('App\Http\Controllers\ValidationController')
        ->validation(
            $request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', '=',$request->email)->first();
        if (!$user){
            return response()->json([
                'email' => [__('auth.failed')],
                'password' => ['']
            ], 422);
        }
        if (!Hash::check($request->password, $user->password)){
            return response()->json([
                'email' => [''],
                'password' => [__('auth.password')]
            ], 422);
        }
        Auth::login($user);

        if ($request->has('remember')){
            $request->session()->regenerate();
        }

        $request->session()->put(
            'main',
            $user->balance->where('main', true)->first()->exchange_id
        );

        return response()->json(['link' => route('dashboard')], 200);
    }

    public function register(Request $request){
        app()->make('App\Http\Controllers\ValidationController')
        ->validation(
            $request->only(['name', 'email', 'paswword', 'password_confirmation']), [
                'name' => 'required|min:3|max:50|string',
                'email' => 'required|email|unique:users',
                'password' => ['confirmed', Password::defaults()]
        ]);

        $user = User::create($request->only(['name','email','password']));

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
