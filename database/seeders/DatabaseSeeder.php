<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
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
        // User::factory(10)->create();


        DB::table('colors')->insert([
            [
                'name' => 'red'
            ],
            [
                'name' => 'green'
            ],
            [
                'name' => 'black'
            ],
            [
                'name' => 'white'
            ]
        ]);

        DB::table('categories')->insert([
            [
                'name' => 'sport'
            ],
            [
                'name' => 'man'
            ],
            [
                'name' => 'woman'
            ],
            [
                'name' => 'lite'
            ]
        ]);

        DB::table('sizes')->insert([
            [
                'name' => 'big'
            ],
            [
                'name' => 'medium'
            ],
            [
                'name' => 'small'
            ]

        ]);


        DB::table('products')->insert([
            [
                'name' => 'ساعت دیجیتال مردانه',
                'description' => ' ساعت دیجیتال مردانه مدل خاص سری اول جلکسی دو',
                'image' => 'watch-1.jpg',
                'category_id' => 2,
                'size_id' => 2,
                'color_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'price' => 25000,
                'count' => 10,
                'discount_percent' => 20,
            ],
            [
                'name' => 'ساعت  زنانه',
                'image' => 'watch-2.jpg',
                'description' => ' ساعت دیجیتال زنانه مدل خانمانه دو',
                'count' => 8,
                'category_id' => 3,
                'size_id' => 2,
                'color_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'price' => 60000,
                  'discount_percent' => 50,
            ]
        ]);

        Product::factory()->count(20)->create();
    }
}
