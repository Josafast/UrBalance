<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionObserver
{
    protected function update_balance($transaction):void {
        app()->make('App\Http\Controllers\BalanceController')->store($transaction);
    } 

    public function created(Transaction $transaction): void
    {
        if (request()->session()->has('main')){
            $balance = request()->user()->balance->where('exchange_id', session()->get('main'))->first();
            DB::table('balance_transaction')->insert([
                'balance_id' => $balance->id,
                'transaction_id' => $transaction->id
            ]);

            $this->update_balance($transaction);
        }
    }

    protected function transaction_formater(Transaction $transaction):void {
        $previousTransaction = $transaction->getOriginal();
        $transaction->quantity = intval($transaction->quantity) - intval($previousTransaction['quantity']);
        $this->update_balance($transaction);
        $transaction->quantity = intval($transaction->quantity) + intval($previousTransaction['quantity']);
    }

    public function updating(Transaction $transaction): void
    {
        $this->transaction_formater($transaction);
    }

    public function deleting(Transaction $transaction): void
    {
        $this->transaction_formater($transaction);
    }
}