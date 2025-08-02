<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name'            => $this->faker->word(),
            'description'     => $this->faker->sentence(10),
            'image'           => 'watch-defult.jpg',
            'count'           => $this->faker->numberBetween(5, 50),
            'category_id'     => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'size_id'         => Size::inRandomOrder()->first()->id ?? Size::factory(),
            'color_id'        => Color::inRandomOrder()->first()->id ?? Color::factory(),
            'price'           => $this->faker->numberBetween(100000, 500000),
            'discount_price'  => $this->faker->numberBetween(0, 50000),
        ];
    }
}
