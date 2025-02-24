<?php

namespace Database\Seeders;

use App\Models\Circuit;
use App\Models\Race;
use App\Models\Standing;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        /* Circuit::factory(10)->create();

        Driver::factory(10)->create();

        Team::factory(10)->create();

        Race::factory(10)->create();

        Standing::factory(10)->create(); */

        // Borramos todos los datos de las tablas antes de insertar nuevos datos
        DB::table('teams')->delete();

        // Insertar datos en la tabla `teams`
        DB::table('teams')->insert([
            ['name' => 'Mercedes', 'logo' => 'mercedes.png'],
            ['name' => 'Red Bull Racing', 'logo' => 'redbull.png'],
            ['name' => 'Ferrari', 'logo' => 'ferrari.png'],
            ['name' => 'McLaren', 'logo' => 'mclaren.png'],
            ['name' => 'Aston Martin', 'logo' => 'astonmartin.png'],
        ]);

        // Borramos todos los datos de la tabla `drivers` antes de insertar nuevos datos
        DB::table('drivers')->delete();

        // Insertar datos en la tabla `drivers`
        DB::table('drivers')->insert([
            ['name' => 'Lewis Hamilton', 'team_id' => 1, 'photo' => 'hamilton.png'],
            ['name' => 'George Russell', 'team_id' => 1, 'photo' => 'russell.png'],
            ['name' => 'Max Verstappen', 'team_id' => 2, 'photo' => 'verstappen.png'],
            ['name' => 'Liam Lawson', 'team_id' => 2, 'photo' => 'lawson.png'],
            ['name' => 'Charles Leclerc', 'team_id' => 3, 'photo' => 'leclerc.png'],
            ['name' => 'Carlos Sainz', 'team_id' => 3, 'photo' => 'sainz.png'],
            ['name' => 'Lando Norris', 'team_id' => 4, 'photo' => 'norris.png'],
            ['name' => 'Oscar Piastri', 'team_id' => 4, 'photo' => 'piastri.png'],
            ['name' => 'Fernando Alonso', 'team_id' => 5, 'photo' => 'alonso.png'],
            ['name' => 'Lance Stroll', 'team_id' => 5, 'photo' => 'stroll.png'],
        ]);

        // Borramos todos los datos de la tabla `circuits` antes de insertar nuevos datos
        DB::table('circuits')->delete();

        // Insertar datos en la tabla `circuits`
        DB::table('circuits')->insert([
            ['name' => 'Circuit de Monaco', 'location' => 'Monaco', 'length' => 3.337, 'lap_record' => '1:14.260'],
            ['name' => 'Silverstone Circuit', 'location' => 'United Kingdom', 'length' => 5.891, 'lap_record' => '1:27.097'],
            ['name' => 'Suzuka International Racing Course', 'location' => 'Japan', 'length' => 5.807, 'lap_record' => '1:30.983'],
            ['name' => 'Circuit of the Americas', 'location' => 'USA', 'length' => 5.513, 'lap_record' => '1:36.169'],
            ['name' => 'Monza Circuit', 'location' => 'Italy', 'length' => 5.793, 'lap_record' => '1:21.046'],
        ]);

        // Borramos todos los datos de la tabla `races` antes de insertar nuevos datos
        DB::table('races')->delete();

        // Insertar datos en la tabla `races`
        DB::table('races')->insert([
            ['name' => 'Monaco Grand Prix', 'date' => '2025-05-25', 'circuit_id' => 1],
            ['name' => 'British Grand Prix', 'date' => '2025-07-06', 'circuit_id' => 2],
            ['name' => 'Japanese Grand Prix', 'date' => '2025-10-05', 'circuit_id' => 3],
            ['name' => 'United States Grand Prix', 'date' => '2025-10-19', 'circuit_id' => 4],
            ['name' => 'Italian Grand Prix', 'date' => '2025-09-07', 'circuit_id' => 5],
        ]);

        // Borramos todos los datos de la tabla `standings` antes de insertar nuevos datos
        DB::table('standings')->delete();

        // Insertar datos en la tabla `standings`
        DB::table('standings')->insert([
            ['driver_id' => 1, 'team_id' => 1, 'points' => 200, 'position' => 1],
            ['driver_id' => 3, 'team_id' => 2, 'points' => 180, 'position' => 2],
            ['driver_id' => 5, 'team_id' => 3, 'points' => 150, 'position' => 3],
            ['driver_id' => 7, 'team_id' => 4, 'points' => 120, 'position' => 4],
            ['driver_id' => 9, 'team_id' => 5, 'points' => 100, 'position' => 5],
        ]);

        // Borramos todos los datos de la tabla `circuit_race` antes de insertar nuevos datos
        DB::table('circuit_race')->delete();

        // Insertar datos en la tabla `circuit_race`
        DB::table('circuit_race')->insert([
            ['circuit_id' => 1, 'race_id' => 1],
            ['circuit_id' => 2, 'race_id' => 2],
            ['circuit_id' => 3, 'race_id' => 3],
            ['circuit_id' => 4, 'race_id' => 4],
            ['circuit_id' => 5, 'race_id' => 5],
        ]);

    }
}
