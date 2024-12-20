<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Sample data for barangays in Parañaque
        $barangays = [
            [//1
                'name' => 'Baclaran',
                'barangay_rep_id' => 3,
                'location' => 'Baclaran, Parañaque City',
                'fire_risk_level' => 'high', // Replace with actual risk level
            ],
            [//2
                'name' => 'Don Galo',
                'barangay_rep_id' => 4,
                'location' => 'Don Galo, Parañaque City',
                'fire_risk_level' => 'medium', // Replace with actual risk level
            ],
            [//3
                'name' => 'La Huerta',
                'barangay_rep_id' => 5,
                'location' => 'La Huerta, Parañaque City',
                'fire_risk_level' => 'low', // Replace with actual risk level
            ],
            [//4
                'name' => 'San Dionisio',
                'barangay_rep_id' => 6,
                'location' => 'San Dionisio, Parañaque City',
                'fire_risk_level' => 'medium', // Replace with actual risk level
            ],
            [//5
                'name' => 'San Isidro',
                'barangay_rep_id' => 7,
                'location' => 'San Isidro, Parañaque City',
                'fire_risk_level' => 'low', // Replace with actual risk level
            ],
            [//6
                'name' => 'Sto. Niño',
                'barangay_rep_id' => 8,
                'location' => 'Sto. Niño, Parañaque City',
                'fire_risk_level' => 'high', // Replace with actual risk level
            ],
            [//7
                'name' => 'Tambo',
                'barangay_rep_id' => 9,
                'location' => 'Tambo, Parañaque City',
                'fire_risk_level' => 'medium', // Replace with actual risk level
            ],
            [//8
                'name' => 'Vitalez',
                'barangay_rep_id' => 10,
                'location' => 'Vitalez, Parañaque City',
                'fire_risk_level' => 'low', // Replace with actual risk level
            ],
            [//9
                'name' => 'BF',
                'barangay_rep_id' => 11,
                'location' => 'BF, Parañaque City',
                'fire_risk_level' => 'low', // Replace with actual risk level
            ],
            [//10
                'name' => 'Don Bosco',
                'barangay_rep_id' => 12,
                'location' => 'Don Bosco, Parañaque City',
                'fire_risk_level' => 'medium', // Replace with actual risk level
            ],
            [//11
                'name' => 'Marcelo Green',
                'barangay_rep_id' => 13,
                'location' => 'Marcelo Green, Parañaque City',
                'fire_risk_level' => 'low', // Replace with actual risk level
            ],
            [//12
                'name' => 'Merville',
                'barangay_rep_id' => 14,
                'location' => 'Merville, Parañaque City',
                'fire_risk_level' => 'medium', // Replace with actual risk level
            ],
            [//13
                'name' => 'Moonwalk',
                'barangay_rep_id' => 15,
                'location' => 'Moonwalk, Parañaque City',
                'fire_risk_level' => 'high', // Replace with actual risk level
            ],
            [//14
                'name' => 'San Antonio',
                'barangay_rep_id' => 16,
                'location' => 'San Antonio, Parañaque City',
                'fire_risk_level' => 'low', // Replace with actual risk level
            ],
            [//15
                'name' => 'San Martin de Porres',
                'barangay_rep_id' => 17,
                'location' => 'San Martin de Porres, Parañaque City',
                'fire_risk_level' => 'medium', // Replace with actual risk level
            ],
            [//16
                'name' => 'Sun Valley',
                'barangay_rep_id' => 18,
                'location' => 'Sun Valley, Parañaque City',
                'fire_risk_level' => 'low', // Replace with actual risk level
            ],
        ];


        // Insert data into the barangays table
        DB::table('barangays')->insert($barangays);
    }
}
