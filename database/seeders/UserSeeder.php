<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() == 0) {

            User::create([
                'name'           => 'John Doe',
                'email'          => 'jdoe@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Content Manager',
                'email'          => 'cms@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep',
                'email'          => 'barangay@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 2',
                'email'          => 'barangay2@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 3',
                'email'          => 'barangay3@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 4',
                'email'          => 'barangay4@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 5',
                'email'          => 'barangay5@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 6',
                'email'          => 'barangay6@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 7',
                'email'          => 'barangay7@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 8',
                'email'          => 'barangay8@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 9',
                'email'          => 'barangay9@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 10',
                'email'          => 'barangay10@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 11',
                'email'          => 'barangay11@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 12',
                'email'          => 'barangay12@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 13',
                'email'          => 'barangay13@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 14',
                'email'          => 'barangay14@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 15',
                'email'          => 'barangay15@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Barangay Rep 16',
                'email'          => 'barangay16@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Municipal Admin',
                'email'          => 'admin@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);
        }
    }
}
