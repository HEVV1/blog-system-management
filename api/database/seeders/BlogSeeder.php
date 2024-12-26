<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listOfUsers = User::all();

        for ($i = 0; $i < 100; $i++) {
            $user = $listOfUsers->random();
            Blog::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
