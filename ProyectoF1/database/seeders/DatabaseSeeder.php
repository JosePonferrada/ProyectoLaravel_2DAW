<?php

namespace Database\Seeders;

use App\Models\Circuit;
use App\Models\Race;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        /* Circuit::factory(10)->create();

        Driver::factory(10)->create();

        Team::factory(10)->create();

        Race::factory(10)->create(); */

        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'surname' => 'Admin Surname',  
                'username' => 'admin',
                'profile_photo' => null, // Puede ser null si no tienes una foto de perfil
                'role' => 'admin',  
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Normal User',
                'surname' => 'Normal User',  
                'username' => 'user',
                'profile_photo' => null, // Puede ser null
                'role' => 'user',
                'email' => 'user@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Borramos todos los datos de las tablas antes de insertar nuevos datos
        DB::table('teams')->delete();

        // Insertar datos en la tabla `teams`
        DB::table('teams')->insert([
            [
                'name' => 'Mercedes',
                'logo' => 'mercedes.png',
                'country' => 'Germany',
                'year_founded' => 1954,
                'championships' => 8,
            ],
            [
                'name' => 'Red Bull Racing',
                'logo' => 'redbull.png',
                'country' => 'Austria',
                'year_founded' => 2005,
                'championships' => 4,
            ],
            [
                'name' => 'Ferrari',
                'logo' => 'ferrari.png',
                'country' => 'Italy',
                'year_founded' => 1929,
                'championships' => 16,
            ],
        ]);

        // Borramos todos los datos de la tabla `drivers` antes de insertar nuevos datos
        DB::table('drivers')->delete();

        // Insertar datos en la tabla `drivers`
        DB::table('drivers')->insert([
            [
                'name' => 'Lewis Hamilton',
                'team_id' => 1,
                'photo' => 'hamilton.png',
                'nationality' => 'British',
                'date_of_birth' => '1985-01-07',
                'number' => 44,
            ],
            [
                'name' => 'Max Verstappen',
                'team_id' => 2,
                'photo' => 'verstappen.png',
                'nationality' => 'Dutch',
                'date_of_birth' => '1997-09-30',
                'number' => 33,
            ],
            [
                'name' => 'Charles Leclerc',
                'team_id' => 3,
                'photo' => 'leclerc.png',
                'nationality' => 'Monegasque',
                'date_of_birth' => '1997-10-16',
                'number' => 16,
            ],
        ]);

        // Borramos todos los datos de la tabla `circuits` antes de insertar nuevos datos
        DB::table('circuits')->delete();

        // Insertar datos en la tabla `circuits`
        DB::table('circuits')->insert([
            [
                'name' => 'Circuit de Monaco',
                'location' => 'Monaco',
                'length' => 3.337,
                'lap_record' => '1:14.260',
                'capacity' => 37000,
                'first_grand_prix' => 1929,
            ],
            [
                'name' => 'Silverstone Circuit',
                'location' => 'United Kingdom',
                'length' => 5.891,
                'lap_record' => '1:27.097',
                'capacity' => 150000,
                'first_grand_prix' => 1950,
            ],
            [
                'name' => 'Suzuka International Racing Course',
                'location' => 'Japan',
                'length' => 5.807,
                'lap_record' => '1:30.983',
                'capacity' => 155000,
                'first_grand_prix' => 1987,
            ],
        ]);

        // Borramos todos los datos de la tabla `races` antes de insertar nuevos datos
        DB::table('races')->delete();

        // Insertar datos en la tabla `races`
        DB::table('races')->insert([
            [
                'name' => 'Monaco Grand Prix',
                'date' => '2025-05-25',
                'laps' => 78,
                'weather' => 'Sunny',
            ],
            [
                'name' => 'British Grand Prix',
                'date' => '2025-07-06',
                'laps' => 52,
                'weather' => 'Cloudy',
            ],
            [
                'name' => 'Japanese Grand Prix',
                'date' => '2025-10-05',
                'laps' => 53,
                'weather' => 'Rainy',
            ],
        ]);

        // Borramos todos los datos de la tabla `circuit_race` antes de insertar nuevos datos
        DB::table('circuit_race')->delete();

        // Insertar datos en la tabla `circuit_race`
        DB::table('circuit_race')->insert([
            ['circuit_id' => 1, 'race_id' => 1],
            ['circuit_id' => 2, 'race_id' => 2],
            ['circuit_id' => 3, 'race_id' => 3],
        ]);

    }
}
