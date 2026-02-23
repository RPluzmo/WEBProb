<?php

namespace Database\Seeders;

use App\Models\Rider;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Seeder;

class RiderSeeder extends Seeder
{
    public function run(): void
    {
        $tracks = Track::all();
        $users = User::where('role', 'guest')->get();
        
        $dates = [
            now()->toDateString(), 
            now()->addDay()->toDateString()
        ];

        $times = ['08:00:00', '12:00:00', '16:00:00', '20:00:00'];

        foreach ($tracks as $track) {
            $ridersToAssign = $users->random(rand(0, 7));

            foreach ($ridersToAssign as $user) {
                Rider::create([
                    'track_id'         => $track->id,
                    'user_id'          => $user->id,
                    'name'             => $user->first_name . ' ' . $user->last_name,
                    'club_id'          => $user->club_id,
                    'category'         => $user->category ?: 'MX1',
                    'experience_level' => $user->experience_level ?: 'Amatieris',
                    'ride_date'        => $dates[array_rand($dates)],
                    'ride_time'        => $times[array_rand($times)],
                ]);
            }
        }
    }
}