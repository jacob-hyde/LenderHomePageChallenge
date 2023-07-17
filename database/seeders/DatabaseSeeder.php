<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $primaryUser = User::factory()->create([
            'email' => 'test@test.com',
        ]);

        Task::factory(20)->create(['user_id' => $primaryUser->id]);

        User::factory(10)->create()->each(function (User $user) {
            Task::factory(mt_rand(5, 20))->create(['user_id' => $user->id]);
        });
    }
}
