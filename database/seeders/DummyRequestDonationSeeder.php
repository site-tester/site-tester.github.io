<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyRequestDonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangays = range(1, 16);
        $statuses = ['Pending Approval', 'Approved'];

        $preferredDonationTypes = [
            ['Food'],
            ['NonFood'],
            ['Medicine'],
            ['Food', 'NonFood'],
            ['Food', 'Medicine'],
            ['NonFood', 'Medicine'],
            ['Food', 'NonFood', 'Medicine']
        ];

        $disasterTypes = ['Flood', 'Fire', 'Earthquake'];

        $immediateNeedsFood = ['Water', 'Canned Goods', 'Rice', 'Bread'];
        $immediateNeedsNonFood = ['Clothes', 'Blankets', 'Tents'];
        $immediateNeedsMedicine = ['Paracetamol', 'Bandages', 'Antibiotics'];

        foreach ($barangays as $barangayId) {
            for ($i = 0; $i < 2; $i++) {
                DB::table('request_donations')->insert([
                    'reported_by' => fake()->name(),
                    'incident_date' => fake()->date(),
                    'incident_time' => fake()->time(),
                    'barangay_id' => $barangayId,
                    'exact_location' => fake()->address(),
                    'preffered_donation_type' => json_encode(json_encode(fake()->randomElement($preferredDonationTypes))),
                    'disaster_type' => json_encode(json_encode([fake()->randomElement($disasterTypes)])),
                    'caused_by' => fake()->word(),
                    'immediate_needs_food' => fake()->randomElement($immediateNeedsFood),
                    'immediate_needs_nonfood' => fake()->randomElement($immediateNeedsNonFood),
                    'immediate_needs_medicine' => fake()->randomElement($immediateNeedsMedicine),
                    'overview' => fake()->sentence(),
                    'date_requested' => fake()->date(),
                    'affected_family' => fake()->numberBetween(1, 50),
                    'affected_person' => fake()->numberBetween(1, 200),
                    'vulnerability' => fake()->randomElement(['High', 'Moderate', 'Low']),
                    'attachments' => json_encode(['attachment1.jpg', 'attachment2.pdf']),
                    'status' => ($i < 1 && $barangayId <= 5) ? $statuses[0] : $statuses[1], // 10 Pending, rest Approved
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
