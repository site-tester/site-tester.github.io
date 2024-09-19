<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAndProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserProfile::create([
            'user_id' => '2',
            'contact_number' => '09123456789',
            'address' => '123 Dos Castillas Street, Barangay 143, Sampaloc, Manila',
            'other_details' => 'We Bear Bears Fondation',
        ]);
    }
}
