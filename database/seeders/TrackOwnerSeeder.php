<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Seeder;

class TrackOwnerSeeder extends Seeder
{
    public function run(): void
    {
        $ownerTrackMap = [
            'adazi@emeks.lv' => 'Ādaži',
            'adazu_poligons@emeks.lv' => 'Ādažu poligons',
            'aizpute@emeks.lv' => 'Aizpute',
            'aloja@emeks.lv' => 'Aloja',
            'ape@emeks.lv' => 'Ape',
            'blome@emeks.lv' => 'Blome',
            'burtnieki@emeks.lv' => 'Burtnieki',
            'cesis@emeks.lv' => 'Cēsis',
            'daugavpils@emeks.lv' => 'Daugavpils',
            'dobele@emeks.lv' => 'Dobele',
            'drusti@emeks.lv' => 'Drusti',
            'elksni@emeks.lv' => 'Elkšņi',
            'gulbene@emeks.lv' => 'Gulbene',
            'jaunmarupe@emeks.lv' => 'Jaunmārupe',
            'jaunpils@emeks.lv' => 'Jaunpils',
            'jurkalne@emeks.lv' => 'Jurkalne',
            'kegums@emeks.lv' => 'Ķegums',
            'limbazi@emeks.lv' => 'Limbaži',
            'lubana@emeks.lv' => 'Lubāna',
            'madona@emeks.lv' => 'Madona',
            'nereta@emeks.lv' => 'Nereta',
            'pilsblidene@emeks.lv' => 'Pilsblīdene',
            'pravinas@emeks.lv' => 'Praviņas',
            'rauna@emeks.lv' => 'Rauna',
            'rujiena@emeks.lv' => 'Rūjiena',
            'saldus@emeks.lv' => 'Saldus',
            'sigulda@emeks.lv' => 'Sigulda',
            'staicele@emeks.lv' => 'Staicele',
            'stameriena@emeks.lv' => 'Stāmeriena',
            'stelpe@emeks.lv' => 'Stelpe',
            'stende@emeks.lv' => 'Stende',
            'vaveres@emeks.lv' => 'Vāveres',
        ];

        Track::query()->update(['owner_id' => null]);

        foreach ($ownerTrackMap as $ownerEmail => $trackName) {
            $owner = User::where('email', $ownerEmail)->where('role', 'owner')->first();
            $track = Track::where('name', $trackName)->first();

            if (!$owner || !$track) {
                continue;
            }

            $track->update(['owner_id' => $owner->id]);
        }
    }
}
