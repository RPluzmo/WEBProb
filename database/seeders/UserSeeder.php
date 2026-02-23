<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@emeks.lv'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'password' => Hash::make('qwe'),
                'role' => 'admin',
                'club_id' => null,
                'category' => '',
                'experience_level' => '',
                'profile_image' => null,
            ]
        );

        $owners = [
            'adazi' => 'Ādažu',
            'adazu_poligons' => 'Ādažu-Poligona',
            'aizpute' => 'Aizputes',
            'aloja' => 'Alojas',
            'ape' => 'Apes',
            'blome' => 'Blomes',
            'burtnieki' => 'Burtnieku',
            'cesis' => 'Cēsu',
            'daugavpils' => 'Daugavpils',
            'dobele' => 'Dobeles',
            'drusti' => 'Drustu',
            'elksni' => 'Elkšņu',
            'gulbene' => 'Gulbenes',
            'jaunmarupe' => 'Jaunmārupes',
            'jaunpils' => 'Jaunpils',
            'jurkalne' => 'Jurkalnes',
            'kegums' => 'Ķeguma',
            'limbazi' => 'Limbažu',
            'lubana' => 'Lubanās',
            'madona' => 'Madonas',
            'nereta' => 'Neretas',
            'pilsblidene' => 'Pilsblīdenes',
            'pravinas' => 'Praviņu',
            'rauna' => 'Raunas',
            'rujiena' => 'Rūjienas',
            'saldus' => 'Saldus',
            'sigulda' => 'Siguldas',
            'staicele' => 'Staiceles',
            'stameriena' => 'Stamerienes',
            'stelpe' => 'Stelpes',
            'stende' => 'Stendes',
            'vaveres' => 'Vāveru',
        ];

        foreach ($owners as $emailPrefix => $firstName) {
            User::updateOrCreate(
                ['email' => $emailPrefix . '@emeks.lv'],
                [
                    'first_name' => $firstName,
                    'last_name' => 'Saimnieks',
                    'password' => Hash::make('qwe'),
                    'role' => 'owner',
                    'club_id' => null, 
                    'category' => '',
                    'experience_level' => '',
                    'profile_image' => null,
                ]
            );
        }

        User::factory(30)->create([
            'role' => 'guest',
            'club_id' => fn() => \App\Models\Club::inRandomOrder()->first()->id,
            'category' => fn() => collect(['MX1', 'MX2', 'MX125', 'MX85'])->random(),
            'experience_level' => fn() => collect(['Iesācējs', 'Amatieris', 'Veterāns'])->random(),
        ]);
    }
}