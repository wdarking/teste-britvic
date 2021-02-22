<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // dev user
        \App\Models\User::factory()->create([
            'name' => 'Developer',
            'email' => 'dev@dev.com',
            'document' => '12345678909',
            'password' => Hash::make('dev')
        ]);

        \App\Models\Vehicle::factory()->createMany([
            ['name' => 'Fusca', 'year' => '1960', 'model' => 'A1', 'brand' => 'Volkswagen'],
            ['name' => 'Ferrari F8', 'year' => '2016', 'model' => 'A1', 'brand' => 'Ferrari'],
            ['name' => 'Hyundai HB20', 'year' => '2014', 'model' => 'A1', 'brand' => 'Hyundai'],
        ]);
    }
}
