<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index(Request $request, string $option){
        $this->$option($request);
        return redirect()->route('profile.index');
    }

    protected function change_email(Request $request){
        $credentials = $request->validate([
            'name' => 'required|min:3|max:50|string',
            'email' => ['required','email','string', $request->user()->email == $request->email ? '' : 'unique:users']
        ]);

        $request->user()->fill($credentials);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
    }

    protected function change_password(Request $request){
        $credentials = $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => ['required', Password::defaults(), 'confirmed']
        ]);

        $request->user()->update([
            'password' => $credentials['new_password']
        ]);
        $request->user()->save();
    }

    protected function destroy(Request $request){
        $request->validate(['password'=>'required|confirmed|current_password']);

        $user = $request->user();

        $user->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.view');
    }
}
