<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyDonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 50) as $index) {
            DB::table('donations')->insert([
                'anonymous' => $faker->boolean,
                'donor_id' => 1,
                'barangay_id' => $faker->numberBetween(1, 16), // Adjust based on the number of barangays
                'transfered_by' => $faker->optional()->name,
                'approved_by' => $faker->optional()->name,
                'received_by' => $faker->optional()->name,
                'distributed_by' => $faker->optional()->name,
                'type' => json_encode(json_encode($faker->randomElements(['Food', 'Non-food', 'Medical'], $faker->numberBetween(1, 3)))),
                'donation_date' => $faker->date,
                'donation_time' => $faker->time('H:i:s'),
                'proof_document' => $faker->optional()->fileExtension, // Placeholder for file name
                'remarks' => $faker->optional()->sentence,
                'status' => $faker->randomElement([
                    'Pending Approval',
                    'Approved',
                    'Rejected',
                    'Received',
                    'Distributed',
                ]),
                'mark_as_done' => $faker->optional()->date,
                'created_at' => $faker->dateTimeBetween('-1 week', 'now'),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
