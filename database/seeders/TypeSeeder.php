<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Entrance' => 'blue',
            'Spent' => 'red',
            'Saving' => 'yellow'
        ];

        foreach ($types as $type => $color):
            \App\Models\Type::firstOrCreate([
                'name' => $type,
                'color' => $color
            ]);
        endforeach;
    }
}
