<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
use App\Models\User\Favorites;
use App\Models\User\Following;
use Faker\Generator;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DataSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);

        for($i = 1; $i <= 200; $i++){

            $movieTitle = $faker->realText(10);
            Movie::create([
                'title' => $movieTitle,
                'slug' => Str::slug(strtolower($movieTitle)),
            ]);
        }

        // if(App::environment() === 'testing'){

            $movies = Movie::all();
            $user = User::where('email', 'test@live.com')->first();

            $index = 1;

            foreach($movies as $movie){
                if($index % 10 === 0){
                    // skip observer event triggers on create
                    Favorites::withoutEvents(function() use ($movie, $user){
                        Favorites::create([
                            'movie_id'  => $movie->id,
                            'user_id'   => $user->id
                        ]);
                    });
                }

                if($index % 15 === 0){
                    Following::create([
                        'movie_id'  => $movie->id,
                        'user_id'   => $user->id
                    ]);
                }

                $index++;
            }
            
        // }
    }
}
