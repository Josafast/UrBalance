<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
             'name' => 'Josafat Quijada',
             'email' => 'josafat@gmail.com',
             'password' => '123456'
        ]);

        $this->call([ExchangeSeeder::class, TypeSeeder::class, CategoriesSeeder::class]);

        $balance_one = \App\Models\Balance::create([
            'user_id' => 1,
            'exchange_id' => 1,
            'initial' => 10000,
            'main' => true
        ]);

        $balance_two = \App\Models\Balance::create([
            'user_id' => 1,
            'exchange_id' => 3,
            'initial' => 50000
        ]);

        $this->call([TransactionSeeder::class]);

        DB::table('balance_transaction')->insert([
            'balance_id' => 1,
            'transaction_id' => 1
        ]);

        DB::table('balance_transaction')->insert([
            'balance_id' => 1,
            'transaction_id' => 2
        ]);

        DB::table('balance_transaction')->insert([
            'balance_id' => 1,
            'transaction_id' => 3
        ]);

        DB::table('balance_transaction')->insert([
            'balance_id' => 1,
            'transaction_id' => 4
        ]);

        DB::table('balance_transaction')->insert([
            'balance_id' => 1,
            'transaction_id' => 5
        ]);

        DB::table('balance_transaction')->insert([
            'balance_id' => 2,
            'transaction_id' => 6
        ]);

        DB::table('balance_transaction')->insert([
            'balance_id' => 1,
            'transaction_id' => 7
        ]);

        DB::table('balance_transaction')->insert([
            'balance_id' => 1,
            'transaction_id' => 8
        ]);

        $balanceUpdate = app()->make('App\Http\Controllers\BalanceController');
        $balanceUpdate->store($balance_one);

        $balanceUpdate = app()->make('App\Http\Controllers\BalanceController');
        $balanceUpdate->store($balance_two);
    }
}
