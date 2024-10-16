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
            [
                'name' => 'Baclaran',
                'barangay_rep_id' => 3,
                'location' => 'Baclaran, Parañaque City',
            ],
            [
                'name' => 'Don Galo',
                'barangay_rep_id' => 4,
                'location' => 'Don Galo, Parañaque City',
            ],
            [
                'name' => 'La Huerta',
                'barangay_rep_id' => 5,
                'location' => 'La Huerta, Parañaque City',
            ],
            [
                'name' => 'San Dionisio',
                'barangay_rep_id' => 6,
                'location' => 'San Dionisio, Parañaque City',
            ],
            [
                'name' => 'San Isidro',
                'barangay_rep_id' => 7,
                'location' => 'San Isidro, Parañaque City',
            ],
            [
                'name' => 'Sto. Niño',
                'barangay_rep_id' => 8,
                'location' => 'Sto. Niño, Parañaque City',
            ],
            [
                'name' => 'Tambo',
                'barangay_rep_id' => 9,
                'location' => 'Tambo, Parañaque City',
            ],
            [
                'name' => 'Vitalez',
                'barangay_rep_id' => 10,
                'location' => 'Vitalez, Parañaque City',
            ],
            [
                'name' => 'BF',
                'barangay_rep_id' => 11,
                'location' => 'BF, Parañaque City',
            ],
            [
                'name' => 'Don Bosco',
                'barangay_rep_id' => 12,
                'location' => 'Don Bosco, Parañaque City',
            ],
            [
                'name' => 'Marcelo Green',
                'barangay_rep_id' => 13,
                'location' => 'Marcelo Green, Parañaque City',
            ],
            [
                'name' => 'Merville',
                'barangay_rep_id' => 14,
                'location' => 'Merville, Parañaque City',
            ],
            [
                'name' => 'Moonwalk',
                'barangay_rep_id' => 15,
                'location' => 'Moonwalk, Parañaque City',
            ],
            [
                'name' => 'San Antonio',
                'barangay_rep_id' => 16,
                'location' => 'San Antonio, Parañaque City',
            ],
            [
                'name' => 'San Martin de Porres',
                'barangay_rep_id' => 17,
                'location' => 'San Martin de Porres, Parañaque City',
            ],
            [
                'name' => 'Sun Valley',
                'barangay_rep_id' => 18,
                'location' => 'Sun Valley, Parañaque City',
            ],
        ];

        // Insert data into the barangays table
        DB::table('barangays')->insert($barangays);
    }
}
