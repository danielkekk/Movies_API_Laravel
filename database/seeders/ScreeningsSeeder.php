<?php

namespace Database\Seeders;

use App\Models\Screening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ScreeningsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=10; $i++) {
            Screening::create([
                'screenings_id' => $i,
                'movies_id' => $i,
                'screeining_time' => Carbon::now(),
                'available_seats' => 100,
                'url' => 'https://cinema.hu/movie-'.$i,
            ]);
        }
    }
}
