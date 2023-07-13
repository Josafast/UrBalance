<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::create([
            'name' => 'Transaccion genérica',
            'quantity' => 20,
            'category_id' => 6
        ]);

        Transaction::create([
            'name' => 'Transaccion genérica',
            'quantity' => 10,
            'category_id' => 2
        ]);

        Transaction::create([
            'name' => 'Transaccion genérica',
            'quantity' => 20,
            'category_id' => 13
        ]);

        Transaction::create([
            'name' => 'Transaccion genérica',
            'quantity' => 15.5,
            'category_id' => 6,
            'status' => false
        ]);

        Transaction::create([
            'name' => 'Transaccion genérica',
            'quantity' => 10.3,
            'category_id' => 7,
            'status' => false
        ]);

        Transaction::create([
            'name' => 'Transaccion genérica',
            'quantity' => 100,
            'category_id' => 7,
            'status' => true
        ]);

        Transaction::create([
            'name' => 'Transaccion genérica',
            'quantity' => 10,
            'category_id' => 14
        ]);

        Transaction::create([
            'name' => 'Transaccion genérica',
            'quantity' => 40,
            'category_id' => 15
        ]);
    }
}
