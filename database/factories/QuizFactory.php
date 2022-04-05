<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
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
            'title' => $this->faker->word(),
            'description' => $this->faker->word(),
            'mark' => $this->faker->numberBetween(1, 100),
            'teacher_id' => '1',
            'room_id' => Room::inRandomOrder()->first()->id,
        ];
    }
}
