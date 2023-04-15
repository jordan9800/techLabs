<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject'     => $this->faker->text(20),
            'description' => $this->faker->text(100),
            'start_date'  => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'due_date'    => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'status'      => Arr::random(['New', 'Incomplete', 'Complete']),
            'priority'    => Arr::random(['High', 'Medium', 'Low']),
        ];
    }
}
