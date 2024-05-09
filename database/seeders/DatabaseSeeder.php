<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(10)
            ->has(Post::factory(3)
                    ->for(Community::factory()))
            ->create();
        Comment::factory(50)->create();
    }
}
