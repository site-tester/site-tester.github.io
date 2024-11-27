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
                'name'           => 'Baclaran Representative',
                'email'          => 'bbaclaran@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Don Galo Representative',
                'email'          => 'bdongalo@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'La huerta Representative',
                'email'          => 'blahuerta@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'San Dionisio Representative',
                'email'          => 'bsandionisio@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'San Isidro Representative',
                'email'          => 'bsanisidro@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Santo Niño Representative',
                'email'          => 'bstnino@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Tambo Representative',
                'email'          => 'btambo@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Vitalez Representative',
                'email'          => 'bvitalez@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'BF Representative',
                'email'          => 'bbf@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Don Bosco Representative',
                'email'          => 'bdonbosco@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Marcelo Green Representative',
                'email'          => 'bmarcelogreen@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Merville Representative',
                'email'          => 'bmerville@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Moonwalk Representative',
                'email'          => 'bmoonwalk@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'San Antonio Representative',
                'email'          => 'bsanantonio@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'San Martin de Porres Representative',
                'email'          => 'bsanmartin@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);

            User::create([
                'name'           => 'Sun Valley Representative',
                'email'          => 'bsunvalley@email.com',
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
