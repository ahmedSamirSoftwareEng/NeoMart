<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $images = [];
        static $index = 0;

        // Fetch only once
        if (empty($images)) {
            for ($i = 1; $i <= 20; $i++) {
                $response = Http::withoutVerifying()->get("https://fakestoreapi.com/products/{$i}");
                if ($response->ok()) {
                    $images[] = $response['image'];
                }
            }
        }

        $name = $this->faker->words(3, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(3),
            'image' => $images[$index++ % count($images)],
            'price' => $this->faker->randomFloat(2, 5, 200),
            'compare_price' => $this->faker->randomFloat(2, 100, 250),
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'store_id' => Store::inRandomOrder()->first()->id ?? 1,
            'featured' => rand(0, 1),
        ];
    }
}
