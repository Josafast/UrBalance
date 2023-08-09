<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use App\Models\Exchange;
use Illuminate\View\Component;

class TransactionsRows extends Component
{
    public $transactions;
    public $sign;
    public $queries;
    public function __construct()
    {
        $this->queries = request()->query();
        $this->sign = Exchange::find(request()->session()->get('main'))->sign;
        $transactions = app()->make('App\Http\Controllers\TransactionController')->show($this->queries);
        $this->transactions = $transactions;
    }

    public function render(): View|Closure|string
    {
        return view('components.transactions-rows');
    }
}
