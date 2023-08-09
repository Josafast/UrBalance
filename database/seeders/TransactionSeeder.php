<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DateTime;
use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::withoutEvents(function (){
            Transaction::create([
                'name' => 'Transaccion genérica',
                'quantity' => 2000,
                'category_id' => 6,
                'date' => new DateTime()
            ]);
    
            Transaction::create([
                'name' => 'Transaccion genérica',
                'quantity' => 1000,
                'category_id' => 2,
                'date' => new DateTime()
            ]);
    
            Transaction::create([
                'name' => 'Transaccion genérica',
                'quantity' => 2000,
                'category_id' => 14,
                'date' => new DateTime()
            ]);
    
            Transaction::create([
                'name' => 'Transaccion genérica',
                'quantity' => 1550,
                'category_id' => 6,
                'status' => false,
                'date' => new DateTime()
            ]);
    
            Transaction::create([
                'name' => 'Transaccion genérica',
                'quantity' => 1030,
                'category_id' => 7,
                'status' => false,
                'date' => new DateTime()
            ]);
    
            Transaction::create([
                'name' => 'Transaccion genérica',
                'quantity' => 1000,
                'category_id' => 7,
                'status' => true,
                'date' => new DateTime()
            ]);
    
            Transaction::create([
                'name' => 'Transaccion genérica',
                'quantity' => 1000,
                'category_id' => 15,
                'date' => new DateTime()
            ]);
    
            Transaction::create([
                'name' => 'Transaccion genérica',
                'quantity' => 4000,
                'category_id' => 16,
                'date' => new DateTime()
            ]);
        });
    }
}
