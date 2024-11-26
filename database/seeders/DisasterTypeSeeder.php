<?php

namespace Database\Seeders;

use App\Models\DisasterType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisasterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $disasters = ['Flood', 'Fire', 'Earthquake'];

        foreach ($disasters as $disaster) {
            DisasterType::create([
                'name' => $disaster,
            ]);
        }
    }
}
