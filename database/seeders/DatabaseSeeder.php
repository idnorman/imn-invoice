<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // UsersTableSeeder->run();
        $user = new UsersTableSeeder();
        $user->run();
        // \App\Models\User::factory(10)->create();
    }
}
