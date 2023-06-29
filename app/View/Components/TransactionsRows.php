<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TransactionsRows extends Component
{
    public $transactions;
    public $sign;
    public $queries;
    public function __construct()
    {
        $this->queries = request()->query();
        $balances = request()->user()->balance;
        $balanceFunc = app()->make('App\Http\Controllers\BalanceController');
        $balance = $balanceFunc->selectMainBalance($balances, request()->session()->get('main'));
        $this->sign = $balance->exchange->sign;
        $transactionsFunc = app()->make('App\Http\Controllers\TransactionController');
        $transactions = $transactionsFunc->show($balance->transactions, request()->query());
        $this->transactions = $transactions;
    }

    public function render(): View|Closure|string
    {
        return view('components.transactions-rows');
    }
}
