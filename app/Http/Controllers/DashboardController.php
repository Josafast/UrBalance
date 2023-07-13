<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $main = $request->session()->get('main');

        $balanceFunc = app()->make('App\Http\Controllers\BalanceController');
        $balance = $balanceFunc->index($main);

        return view('dashboard')->with('balance', $balance);
    }
}
