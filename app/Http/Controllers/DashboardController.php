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

        $balance = request()->user()->balance
        ->where('exchange_id', session()->get('main'))->first()
        ->load('transactions.category', 'exchange'); 

        $balanceValues = app()->make('App\Http\Controllers\BalanceController')->index($balance);

        $balance = $balance->transactions->where('status', true)->groupBy('category.type_id');

        return view('dashboard', compact('balance', 'balanceValues', 'sinceUntil'));
    }
}
