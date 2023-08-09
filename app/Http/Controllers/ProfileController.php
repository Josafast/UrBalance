<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function change_email_and_name(Request $request){
        $credentials = Validator::make($request->only(['name', 'email']), [
            'name' => 'required|min:3|max:50|string',
            'email' => ['required','email', $request->user()->email == $request->email ? '' : 'unique:users']
        ]);

        if ($credentials->fails()){
            return response()->json($credentials->errors(), 422);
        }

        $request->user()->fill($request->only(['name', 'email']));

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return response()->json(['link' => route('profile.index'), 'messages' => ['message' => [__('profile.messages.modified_email_and_name')]], 'status' => 'edited'], 200);
    }

    public function change_password(Request $request){
        $credentials = Validator::make($request->only(['current_password', 'new_password', 'new_password_confirmation']), [
            'current_password' => 'required|current_password',
            'new_password' => ['required', Password::defaults(), 'confirmed']
        ]);

        if ($credentials->fails()){
            return response()->json($credentials->errors(), 422);
        }

        $request->user()->update([
            'password' => $request->new_password
        ]);

        $request->user()->save();

        return response()->json(['link' => route('profile.index'), 'messages' => ['message' => [__('profile.messages.modified_password')]], 'status' => 'edited'], 200);
    }

    protected function destroy(Request $request){
        $credentials = Validator::make($request->only(['password', 'password_confirmation']), [ 
            'password' => 'required|confirmed|current_password'
        ]);

        if ($credentials->fails()){
            return response()->json($credentials->errors(), 422);
        }

        $request->user()->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['link' => route('login.view'), 'messages' => ['message' => [__('profile.messages.deleted_account')]], 'status' => 'deleted'], 200);
    }
}
