<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory(5)->create();

        User::factory(5)->create()->each(function ($user) {
            \App\Models\Order::factory(rand(1, 5))
                ->withItems()
                ->create(['user_id' => $user->id]);
        });
    }
}
