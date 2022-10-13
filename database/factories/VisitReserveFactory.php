<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VisitReserveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $section = $this->faker->numberBetween(2,5);
        $hour = $this->faker->numberBetween(10,20);
        $min = $this->faker->randomElement(['00', '30']);
        $visit_time = \Carbon\Carbon::createFromTimeString($hour . ':' . $min . ':00');

        return [
            'customer_id' => $this->faker->numberBetween(1,100),
            'shop_id' => $this->faker->numberBetween(1,3),
            'user_id' => $this->faker->numberBetween(1,10),
            'visit_date' => $this->faker->dateTimeBetween($startDate = '-1 week', $endDate = '+1 week')->format('Y-m-d'),
            'time_section' => $section,
            'visit_time' => $visit_time->format('H:i:s'),
            'finish_time' => $visit_time->addMinutes($section * 30)->format('H:i:s'),
            'memo' => '',
        ];
    }
}
