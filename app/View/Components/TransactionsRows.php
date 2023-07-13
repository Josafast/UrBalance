<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use App\Models\Balance;
use Illuminate\View\Component;

class TransactionsRows extends Component
{
    public $transactions;
    public $sign;
    public $queries;
    public function __construct()
    {
        $this->queries = request()->query();
        $balance = Balance::where('exchange_id',request()->session()->get('main'))->where('user_id',request()->user()->id)->first();
        $this->sign = $balance->exchange->sign;
        $transactionsFunc = app()->make('App\Http\Controllers\TransactionController');
        $transactions = $transactionsFunc->show($balance->transactions->sortByDesc('created_at'), request()->query());
        $this->transactions = $transactions;
    }

    public function render(): View|Closure|string
    {
        return view('components.transactions-rows');
    }
}
