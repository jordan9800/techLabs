<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    protected $truncate = ['users', 'tasks', 'notes'];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->truncate as $table) {
            DB::table($table)->truncate();
        }
        \App\Models\User::factory(10)->create();
        \App\Models\Task::factory(10)->create();
        \App\Models\Note::factory(30)->create();
    }
}
