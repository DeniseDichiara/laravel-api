<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i=0; $i < 100; $i++) {
            $newPost = new Post();

            //than start to popolate for each of the features
            $newPost->title = ucfirst($faker->unique()->words(4, true));
            $newPost->content = $faker->paragraph(10, true);
            $newPost->slug = $faker->slug();
            $newPost->image = $faker->imageUrl(480, 360, 'post', true, 'posts', true, 'png');
            //than save 
            $newPost->save();
            
        }
    }
}
