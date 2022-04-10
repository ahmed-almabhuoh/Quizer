<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
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
            'name' => 'Ali Mohammed',
            'email' => 'ali_mohammed@gmail.com',
            'password' => Hash::make('password'),
            'age' => '25',
        ];
    }
}
