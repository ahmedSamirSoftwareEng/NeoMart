<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $name = $this->faker->department;
        // Get all image paths from public/assets/images/products
        $imageFiles = File::files(public_path('assets/images/products'));

        // Randomly pick one image file
        $randomImage = $imageFiles[array_rand($imageFiles)];

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentences(15, true),
            'image' => 'assets/images/products/' . $randomImage->getFilename(),
        ];
    }
}
