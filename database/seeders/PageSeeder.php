<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        Post::create([
            'title'         => 'About Us',
            'description'   => $faker->paragraph,
            'status'        => 1,
            'comment_able'  => 0,
            'post_type'     => 'page',
            'user_id'       => 1,
            'category_id'   => 1,
        ]);


        Post::create([
            'title'         => 'Our Vision',
            'description'   => $faker->paragraph,
            'status'        => 1,
            'comment_able'  => 0,
            'post_type'     => 'page',
            'user_id'       => 1,
            'category_id'   => 1,
        ]);
    }
}
