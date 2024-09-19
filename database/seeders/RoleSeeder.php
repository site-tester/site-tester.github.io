<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Role Table
        $roles = ['Content Manager', 'Barangay', 'Normal User'];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        //Assign Users a Role
        $normal = User::where('email', 'jdoe@email.com')->first();
        $normalRole = Role::where('name', 'Normal User')->first();
        $normal->assignRole($normalRole);

        $barangay = User::where('email', 'barangay@email.com')->first();
        $barangayRole = Role::where('name', 'Barangay')->first();
        $barangay->assignRole($barangayRole);

        $cms = User::where('email', 'cms@email.com')->first();
        $cmsRole = Role::where('name', 'Content Manager')->first();
        $cms->assignRole($cmsRole);

    }
}
