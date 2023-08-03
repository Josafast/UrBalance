<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $sinceUntil = [
            request()->has('since') ? request()->input('since') : null,
            request()->has('until') ? request()->input('until') : null 
        ];

        $main = $request->session()->get('main');

        $balanceFunc = app()->make('App\Http\Controllers\BalanceController');
        $balanceValues = $balanceFunc->index($main);

        return view('dashboard', compact('balanceValues', 'sinceUntil'));
    }
}
