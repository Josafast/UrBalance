<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'Interest' => 'blue',
                'Gift' => 'pink',
                'Salary' => 'green',
                'Other' => 'purple'
            ],
            [
                'Transport' => 'strong-blue',
                'Feeding' => 'orange',
                'Health' => 'strong-red',
                'Home' => 'green',
                'Education' => 'yellow',
                'Gift' => 'pink',
                'Leisure' => 'purple',
                'Other' => 'red'
            ],
            [
                'Short-Term' => 'red',
                'Medium-Term' => 'orange',
                'Long-Term' => 'yellow'
            ]
        ];

        for ($i = 0; $i < 3; $i++){
            foreach ($categories[$i] as $categoryName => $categoryColor){
                Category::firstOrCreate([
                    'name' => $categoryName,
                    'color' => $categoryColor,
                    'type_id' => $i+1
                ]);
            }
        }
    }
}
