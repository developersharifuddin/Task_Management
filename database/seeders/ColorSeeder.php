<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Color;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $batchSize = 500; // Number of records to insert in each batch

        $totalRecords = 1000; // Total number of records to insert
        $batches = $totalRecords / $batchSize;

        for ($i = 0; $i < $batches; $i++) {
            $colors = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $colors[] = [
                    'name_english' => $faker->colorName(),
                    'name_bangla' => $faker->colorName(),
                    'code' => $faker->hexColor,
                    'description' => $faker->sentence(8),
                    'status' => $faker->randomElement([0, 1]),
                ];
            }

            Color::insert($colors);
        }
    }
}
