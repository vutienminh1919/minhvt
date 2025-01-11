<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password')],
        ]);

        DB::table('posts')->insert([
            ['title' => 'First Post', 'content' => 'This is the first post.', 'user_id' => 1],
        ]);

        DB::table('products')->insert([
            ['name' => 'Product 1', 'description' => 'Description of Product 1', 'price' => 100.00],
        ]);
    }
}
