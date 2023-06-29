<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exchanges = [
            'Dollar' => '$',
            'Euro' => '€',
            'Bolivar' => 'Bs'
        ];

        foreach ($exchanges as $exchange => $simbol):
            \App\Models\Exchange::firstOrCreate([
                'name'=>$exchange,
                'sign'=>$simbol
            ]);
        endforeach;
    }
}
