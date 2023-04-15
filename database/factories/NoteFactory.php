<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $task = Task::pluck('id')->toArray();
        return [
            'subject'   => $this->faker->text(20),
            'tasks_id'  => $this->faker->randomElement($task),
            'note'      => $this->faker->text(100),
        ];
    }
}
