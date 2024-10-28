<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FloodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $floodData = [
            ['barangay_id' => 4, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 4, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 5, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 5, 'flood_level' => 'WAIST LEVEL', 'severity_score' => 6],
            ['barangay_id' => 5, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 5, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 5, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 6, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 6, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 10, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 16, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 16, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 4, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 4, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 5, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 6, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 10, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 10, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 10, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 10, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 10, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 11, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 11, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 1, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 1, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 1, 'flood_level' => 'WAIST LEVEL', 'severity_score' => 6],
            ['barangay_id' => 1, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 1, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 5, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 5, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 5, 'flood_level' => 'WAIST LEVEL', 'severity_score' => 6],
            ['barangay_id' => 6, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 6, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 7, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 8, 'flood_level' => 'WAIST LEVEL', 'severity_score' => 6],
            ['barangay_id' => 8, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 8, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 8, 'flood_level' => 'WAIST LEVEL', 'severity_score' => 6],
            ['barangay_id' => 9, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 10, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 11, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 13, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 13, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'WAIST LEVEL', 'severity_score' => 6],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'WAIST LEVEL', 'severity_score' => 6],
            ['barangay_id' => 15, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 16, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 16, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 16, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 16, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 16, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 10, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 4, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],//
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 6, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 6, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 6, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 8, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 11, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 12, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 16, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 4, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 1, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 4, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 5, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 5, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 6, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 13, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 14, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 14, 'flood_level' => 'WAIST LEVEL', 'severity_score' => 6],
            ['barangay_id' => 14, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 1, 'flood_level' => 'GUTTER LEVEL', 'severity_score' => 2],
            ['barangay_id' => 1, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 1, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 1, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],
            ['barangay_id' => 1, 'flood_level' => 'KNEE LEVEL', 'severity_score' => 4],


        ];

        foreach ($floodData as $data) {
            DB::table('floods')->insert([
                'barangay_id' => $data['barangay_id'],
                'flood_level' => $data['flood_level'],
                'severity_score' => $data['severity_score'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
