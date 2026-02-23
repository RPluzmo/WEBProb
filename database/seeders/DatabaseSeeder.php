<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            ClubSeeder::class,
            UserSeeder::class,
            TrackSeeder::class,
            TrackOwnerSeeder::class,
            TrackImageSeeder::class,
            TrackCompetitionSeeder::class,
            RiderSeeder::class,
        ]);
    }
}
