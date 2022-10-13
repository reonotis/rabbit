<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'customer_no' => $this->faker->randomElement(['CA', 'DE', 'AR']) . str_pad($this->faker->numberBetween(1,9999), 6, 0, STR_PAD_LEFT),
            'f_name' => $this->faker->lastName(),
            'l_name' => $this->faker->firstName(),
            'f_read' => $this->faker->lastName(),
            'l_read' => $this->faker->firstName(),
            'sex' => $this->faker->numberBetween(1,2),
            'tel' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'zip21' => '100',
            'zip22' => '0001',
            'pref21' => '東京都',
            'address21' => '〇〇区',
            'street21' => '住所が入ります',
            'memo' => 'メモが入りますメモが入りますメモが入りますメモが入りますメモが入りますメモが入りますメモが入ります',
        ];
    }
}
