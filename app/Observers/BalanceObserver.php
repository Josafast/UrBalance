<?php

namespace App\Observers;

use App\Models\Balance;
use App\Models\Transaction;
use DateTime;
use Illuminate\Support\Facades\DB;

class BalanceObserver
{
    /**
     * Handle the Balance "created" event.
     */
    public function created(Balance $balance): void
    {
        $array = [1, 5, 14];
        for ($i = 1; $i <= 3; $i++){
            Transaction::withoutEvents(function () use ($i, $array, $balance){
                $transaction = Transaction::create([
                    'name' => 'Test Transaction',
                    'quantity' => 0,
                    'category_id' => $array[$i-1],
                    'date' => new DateTime()
                ]);

                DB::table('balance_transaction')->insert([
                    'balance_id' => $balance->id,
                    'transaction_id' => $transaction->id
                ]);
            });
        }
    }

    /**
     * Handle the Balance "updated" event.
     */
    public function updated(Balance $balance): void
    {
        //
    }

    /**
     * Handle the Balance "deleted" event.
     */
    public function deleted(Balance $balance): void
    {
        //
    }

    /**
     * Handle the Balance "restored" event.
     */
    public function restored(Balance $balance): void
    {
        //
    }

    /**
     * Handle the Balance "force deleted" event.
     */
    public function forceDeleted(Balance $balance): void
    {
        //
    }
}
