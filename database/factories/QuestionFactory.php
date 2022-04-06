<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'question' => $this->faker->word(),
            'degree' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->word(),
            'quiz_id' => 15,
        ];
    }
}
