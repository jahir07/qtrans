<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Package::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->word(),
            'email' => $this->faker->email,
            'package_type' => $this->faker->word(),
            'field_text' => $this->faker->word(),
            'words' => $this->faker->word(),
            'duration' => $this->faker->word(),
            'discount' => $this->faker->randomNumber(2),
            'language' => $this->faker->word(),
            'complementary' => $this->faker->boolean(),
        ];
    }
}
