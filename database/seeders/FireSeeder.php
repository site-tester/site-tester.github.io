<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fires')->insert([
            [
                'barangay' => 'San Dionisio',
                'total_incidents' => 116,
                'high_severity_incidents' => 8,
                'casualties' => 6,
                'injuries' => 17,
                'families_affected' => 598,
                'damages_php' => 33257850,
                'risk_level' => 'High'
            ],
            [
                'barangay' => 'San Isidro',
                'total_incidents' => 71,
                'high_severity_incidents' => 15,
                'casualties' => 0,
                'injuries' => 8,
                'families_affected' => 324,
                'damages_php' => 3082310,
                'risk_level' => 'Medium'
            ],
            [
                'barangay' => 'Baclaran',
                'total_incidents' => 25,
                'high_severity_incidents' => 6,
                'casualties' => 0,
                'injuries' => 0,
                'families_affected' => 22,
                'damages_php' => 737000,
                'risk_level' => 'Low'
            ],
            [
                'barangay' => 'Tambo',
                'total_incidents' => 56,
                'high_severity_incidents' => 10,
                'casualties' => 8,
                'injuries' => 0,
                'families_affected' => 95,
                'damages_php' => 9606200,
                'risk_level' => 'Medium'
            ],
            [
                'barangay' => 'Sto. Niño',
                'total_incidents' => 43,
                'high_severity_incidents' => 10,
                'casualties' => 1,
                'injuries' => 10,
                'families_affected' => 102,
                'damages_php' => 951300,
                'risk_level' => 'Medium'
            ],
            [
                'barangay' => 'San Antonio',
                'total_incidents' => 73,
                'high_severity_incidents' => 10,
                'casualties' => 0,
                'injuries' => 8,
                'families_affected' => 403,
                'damages_php' => 526537000,
                'risk_level' => 'High'
            ],
            [
                'barangay' => 'Don Galo',
                'total_incidents' => 30,
                'high_severity_incidents' => 5,
                'casualties' => 0,
                'injuries' => 9,
                'families_affected' => 65,
                'damages_php' => 4810500,
                'risk_level' => 'Medium'
            ],
            [
                'barangay' => 'Moonwalk',
                'total_incidents' => 40,
                'high_severity_incidents' => 7,
                'casualties' => 1,
                'injuries' => 1,
                'families_affected' => 456,
                'damages_php' => 4458500,
                'risk_level' => 'Medium'
            ],
            [
                'barangay' => 'BF Homes',
                'total_incidents' => 73,
                'high_severity_incidents' => 15,
                'casualties' => 2,
                'injuries' => 3,
                'families_affected' => 111,
                'damages_php' => 1589850,
                'risk_level' => 'Medium'
            ],
            [
                'barangay' => 'Sun Valley',
                'total_incidents' => 22,
                'high_severity_incidents' => 3,
                'casualties' => 0,
                'injuries' => 1,
                'families_affected' => 24,
                'damages_php' => 129000,
                'risk_level' => 'Low'
            ],
            [
                'barangay' => 'Don Bosco',
                'total_incidents' => 47,
                'high_severity_incidents' => 10,
                'casualties' => 1,
                'injuries' => 4,
                'families_affected' => 226,
                'damages_php' => 1512500,
                'risk_level' => 'Medium'
            ],
            [
                'barangay' => 'Merville',
                'total_incidents' => 20,
                'high_severity_incidents' => 4,
                'casualties' => 1,
                'injuries' => 2,
                'families_affected' => 120,
                'damages_php' => 305000,
                'risk_level' => 'Low'
            ],
            [
                'barangay' => 'SMDP',
                'total_incidents' => 9,
                'high_severity_incidents' => 2,
                'casualties' => 0,
                'injuries' => 0,
                'families_affected' => 24,
                'damages_php' => 200000,
                'risk_level' => 'Low'
            ],
            [
                'barangay' => 'Marcelo Green',
                'total_incidents' => 19,
                'high_severity_incidents' => 4,
                'casualties' => 0,
                'injuries' => 2,
                'families_affected' => 145,
                'damages_php' => 381000,
                'risk_level' => 'Low'
            ],
            [
                'barangay' => 'La Huerta',
                'total_incidents' => 16,
                'high_severity_incidents' => 4,
                'casualties' => 0,
                'injuries' => 0,
                'families_affected' => 9,
                'damages_php' => 10000700,
                'risk_level' => 'Low'
            ],
            [
                'barangay' => 'Vitalez',
                'total_incidents' => 3,
                'high_severity_incidents' => 1,
                'casualties' => 0,
                'injuries' => 0,
                'families_affected' => 5,
                'damages_php' => 220000,
                'risk_level' => 'Low'
            ]
        ]);
    }
}
