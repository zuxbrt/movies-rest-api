<?php

namespace Database\Seeders;

use App\Models\Movie;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MoviesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies_json = 'https://gist.githubusercontent.com/saniyusuf/406b843afdfb9c6a86e25753fe2761f4/raw/523c324c7fcc36efab8224f9ebb7556c09b69a14/Film.JSON';
        
        try {
            $jsonSnippet = Http::get($movies_json);
            $resp = json_decode($jsonSnippet->body(), true);
    
            foreach($resp as $single_movie){
                Movie::create([
                    'title' => $single_movie['Title'],
                    'slug' => Str::slug(strtolower($single_movie['Title'])),
                ]);
            }
        } catch (Exception $e) {
            for($i = 1; $i <= 30; $i++){
                Movie::create([
                    'title' => "Movie " . $i,
                    'slug' => Str::slug(strtolower("Movie " . $i)),
                ]);
            }
        }
        
    }
}
