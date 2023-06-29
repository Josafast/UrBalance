<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index(Request $request){
        if (!Auth::guest()){
            $request->session()->put('main','yes');
            return redirect()->route('dashboard');
        }

        return view('loginForm')->with('into', $request->route()->uri == 'register');
        // return view('loginForm')->with('into', $request->route()->uri == 'register');
    }

    public function login(Request $request){
        $remember = $request->has('remember') ? true : false;
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials, $remember)){
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
                'password' => __('auth.failed')
            ]);
        }

        $request->session()->regenerate();
        $request->session()->put('main','yes');
        return redirect()->route('dashboard');
    }

    public function register(Request $request){
        $initial = $request->initial;
        $exchange_id = $request->exchange_id;

        $user = $request->validate([
            'name' => 'required|min:3|max:50|string',
            'email' => 'required|email|string|unique:users',
            'password' => ['required','confirmed', 'min:6', 'max:20', Password::defaults()]
        ]);

        $user = User::create($user);

        $balance = \App\Models\Balance::create([
            'user_id' => $user->id,
            'initial' => $initial,
            'exchange_id' => intval($exchange_id),
            'main' => true
        ]);

        $balanceFunc = app()->make('App\Http\Controllers\BalanceController');
        $balanceFunc->store($balance);

        Auth::login($user);

        $request->session()->put('main','yes');
        return redirect()->route('dashboard');
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.view');
    }
}
