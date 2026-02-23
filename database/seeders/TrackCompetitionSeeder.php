<?php

namespace Database\Seeders;

use App\Models\Track;
use Illuminate\Database\Seeder;

class TrackCompetitionSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            'Aizpute' => [
                ['title' => 'Latvijas čempionāts motokrosā| 1. posms', 'event_date' => '2026-04-25'],
            ],
            'Aloja' => [
                ['title' => 'Latvijas čempionāts motokrosā| 3. posms', 'event_date' => '2026-06-20'],
                ['title' => 'Latvijas kauss motokrosā | 3. posms', 'event_date' => '2026-05-30'],
            ],
            'Ape' => [
                ['title' => '53. Vaidavas kauss motokrosā - Latvijas čempionāts motokrosā 2.posms', 'event_date' => '2026-05-17'],
            ],
            'Ķegums' => [
                ['title' => 'MXGP Pasaules un Eiropas čempionāts motokrosā 2026', 'event_date' => '2026-06-06'],
            ],
            'Lubāna' => [
                ['title' => 'Nacionālais kauss motokrosā | 4. posms', 'event_date' => '2026-08-08'],
            ],
            'Madona' => [
                ['title' => 'Pasaules čempionāts blakusvāģu motokrosā', 'event_date' => '2026-07-25'],
                ['title' => 'Latvijas čempionāts motokrosā| 4. posms', 'event_date' => '2026-08-15'],
            ],
            'Jaunmārupe' => [
                ['title' => 'Mārupes kausa izcīņa Mini motokrosā | 1.posms', 'event_date' => '2026-06-03'],
                ['title' => 'Mārupes kausa izcīņa Mini motokrosā | 2.posms', 'event_date' => '2026-07-15'],
                ['title' => 'Mārupes kausa izcīņa Mini motokrosā | 3.posms', 'event_date' => '2026-08-12'],
                ['title' => 'Mārupes Lielais motokross 2026', 'event_date' => '2026-09-27'],
                ['title' => 'Latvijas čempionāts motokrosā MXDāmas 2026', 'event_date' => '2026-09-27'],
                ['title' => 'Mārupes kausa izcīņa Mini motokrosā 4.posms', 'event_date' => '2026-09-27'],
            ],
            'Jaunpils' => [
                ['title' => 'Nacionālais kauss motokrosā | 2. posms', 'event_date' => '2026-06-27'],
            ],
            'Nereta' => [
                ['title' => 'Latvijas kauss motokrosā | 5. posms', 'event_date' => '2026-08-22'],
            ],
            'Pilsblīdene' => [
                ['title' => 'Nacionālais kauss motokrosā | 5. posms', 'event_date' => '2026-09-12'],
            ],
            'Rūjiena' => [
                ['title' => 'Eriņu kauss motokrosā | 1.posms', 'event_date' => '2026-06-06'],
                ['title' => 'Eriņu kauss motokrosā | 2.posms', 'event_date' => '2026-10-03'],
            ],
            'Saldus' => [
                ['title' => 'Kurzemes kauss motokrosā 2026', 'event_date' => '2026-08-29'],
            ],
            'Sigulda' => [
                ['title' => 'Nacionālais kauss motokrosā | 3. posms', 'event_date' => '2026-07-18'],
            ],
            'Staicele' => [
                ['title' => 'Nacionālais kauss motokrosā | 1. posms', 'event_date' => '2026-05-02'],
                ['title' => 'Latvijas kauss motokrosā | 2. posms', 'event_date' => '2026-05-23'],
                ['title' => 'Salacas kauss motokrosā 2026', 'event_date' => '2026-07-25'],
            ],
            'Stāmeriena' => [
                ['title' => 'Dimantu kauss 2026 | motokrosa sacensības', 'event_date' => '2026-06-17'],
            ],
            'Stelpe' => [
                ['title' => 'Latvijas kauss motokrosā | 4. posms', 'event_date' => '2026-07-11'],
                ['title' => 'Latvijas čempionāts motokrosā| 5. posms', 'event_date' => '2026-09-05'],

            ],
            'Stende' => [
                ['title' => 'Stendes kauss motokrosā| 1. posms', 'event_date' => '2026-04-18'],
                ['title' => 'Lativjas kauss motokrosā | 1. posms', 'event_date' => '2026-05-09'],
                ['title' => 'Stendes kauss motokrosā | 2.posms', 'event_date' => '2026-08-01'],
                ['title' => 'Stendes kauss motokrosā | 3. posms', 'event_date' => '2026-09-19'],
                ['title' => 'Lativjas kauss motokrosā | 4. posms', 'event_date' => '2026-10-10'],
            ]
        ];

        foreach ($events as $trackName => $trackEvents) {
            $track = Track::where('name', $trackName)->first();

            if (!$track) {
                continue;
            }

            $track->events()->delete();

            foreach ($trackEvents as $event) {
                $track->events()->updateOrCreate(
                    [
                        'title' => $event['title'],
                        'event_date' => $event['event_date'],
                    ],
                    []
                );
            }
        }
    }
}
