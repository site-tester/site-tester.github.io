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
            // $roleAdmin = Role::where('name', 'super_admin')->firstOrFail();
            // $roleCMS = Role::where('name', 'content_manager')->firstOrFail();
            // $roleUser = Role::where('name', 'user')->firstOrFail();

            // User::create([
            //     'name'           => 'Admin',
            //     'email'          => 'admin@admin.com',
            //     'password'       => bcrypt('password'),
            //     'remember_token' => Str::random(60),
            //     'role_id'        => $roleAdmin->id,
            // ]);

            // User::create([
            //     'name'           => 'Content Manager',
            //     'email'          => 'cms@email.com',
            //     'password'       => bcrypt('password'),
            //     'remember_token' => Str::random(60),
            //     'role_id'        => $roleCMS->id,
            // ]);

            User::create([
                'name'           => 'John Doe',
                'is_admin'       => 0,
                'is_barangay'    => 0,
                'email'          => 'jdoe@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                // 'role_id'        => $roleUser->id,
            ]);

            User::create([
                'name'           => 'Content Manager',
                'is_admin'       => 1,
                'is_barangay'    => 0,
                'email'          => 'cms@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                // 'role_id'        => $roleUser->id,
            ]);

            User::create([
                'name'           => 'Barangay Rep',
                'is_admin'       => 0,
                'is_barangay'    => 1,
                'email'          => 'barangay@email.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                // 'role_id'        => $roleUser->id,
            ]);
        }
    }
}
