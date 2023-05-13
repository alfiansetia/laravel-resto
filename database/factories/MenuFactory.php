<?php

namespace Database\Factories;

use App\Models\Catmenu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $category = Catmenu::pluck('id')->toArray();
        return [
            'name' => $this->faker->word,
            'catmenu_id' => $this->faker->randomElement($category),
            'price' => $this->faker->numberBetween(1000, 50000),
            'disc' => $this->faker->numberBetween(0, 50),
            'stock' => $this->faker->numberBetween(0, 50),
            'img' => null,
            'desc' => null,
        ];
    }
}
