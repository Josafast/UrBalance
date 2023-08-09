<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ValidationController extends Controller
{
    public function validation(array $data, array $rules){
        $credentials = Validator::make($data, $rules);

        if ($credentials->fails()){
            return response()->json($credentials->errors(), 422);
        }
    }
}
