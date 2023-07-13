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
        $request->session()->put(
            'main',
            \App\Models\Balance::where('user_id',$request->user()->id)->where('main',"=",true)->first()->exchange_id
        );
        return redirect()->route('dashboard');
    }

    public function register(Request $request){
        $user = $request->validate([
            'name' => 'required|min:3|max:50|string',
            'email' => 'required|email|string|unique:users',
            'password' => ['required','confirmed', Password::defaults()]
        ]);

        $user = User::create($user);

        $request->merge(['userID' => $user->id]);

        $balanceCreateFunc = app()->make('App\Http\Controllers\BalanceController');
        $balanceCreateFunc->create($request);

        Auth::login($user);

        $request->session()->put('main',$request->exchange_id);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.view');
    }
}
