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
        $roles = ['Municipal Admin', 'Content Manager', 'Barangay Representative', 'Normal User'];

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
        $barangayRole = Role::where('name', 'Barangay Representative')->first();
        $barangay->assignRole($barangayRole);

        $barangay2 = User::where('email', 'barangay2@email.com')->first();
        $barangay2Role = Role::where('name', 'Barangay Representative')->first();
        $barangay2->assignRole($barangay2Role);

        $barangay = User::where('email', 'barangay3@email.com')->first();
        $barangayRole = Role::where('name', 'Barangay Representative')->first();
        $barangay->assignRole($barangayRole);

        $barangay2 = User::where('email', 'barangay4@email.com')->first();
        $barangay2Role = Role::where('name', 'Barangay Representative')->first();
        $barangay2->assignRole($barangay2Role);

        $barangay = User::where('email', 'barangay5@email.com')->first();
        $barangayRole = Role::where('name', 'Barangay Representative')->first();
        $barangay->assignRole($barangayRole);

        $barangay2 = User::where('email', 'barangay6@email.com')->first();
        $barangay2Role = Role::where('name', 'Barangay Representative')->first();
        $barangay2->assignRole($barangay2Role);

        $barangay = User::where('email', 'barangay7@email.com')->first();
        $barangayRole = Role::where('name', 'Barangay Representative')->first();
        $barangay->assignRole($barangayRole);

        $barangay2 = User::where('email', 'barangay8@email.com')->first();
        $barangay2Role = Role::where('name', 'Barangay Representative')->first();
        $barangay2->assignRole($barangay2Role);

        $barangay = User::where('email', 'barangay9@email.com')->first();
        $barangayRole = Role::where('name', 'Barangay Representative')->first();
        $barangay->assignRole($barangayRole);

        $barangay2 = User::where('email', 'barangay10@email.com')->first();
        $barangay2Role = Role::where('name', 'Barangay Representative')->first();
        $barangay2->assignRole($barangay2Role);

        $barangay = User::where('email', 'barangay11@email.com')->first();
        $barangayRole = Role::where('name', 'Barangay Representative')->first();
        $barangay->assignRole($barangayRole);

        $barangay2 = User::where('email', 'barangay12@email.com')->first();
        $barangay2Role = Role::where('name', 'Barangay Representative')->first();
        $barangay2->assignRole($barangay2Role);

        $barangay = User::where('email', 'barangay13@email.com')->first();
        $barangayRole = Role::where('name', 'Barangay Representative')->first();
        $barangay->assignRole($barangayRole);

        $barangay2 = User::where('email', 'barangay14@email.com')->first();
        $barangay2Role = Role::where('name', 'Barangay Representative')->first();
        $barangay2->assignRole($barangay2Role);

        $barangay = User::where('email', 'barangay15@email.com')->first();
        $barangayRole = Role::where('name', 'Barangay Representative')->first();
        $barangay->assignRole($barangayRole);

        $barangay2 = User::where('email', 'barangay16@email.com')->first();
        $barangay2Role = Role::where('name', 'Barangay Representative')->first();
        $barangay2->assignRole($barangay2Role);

        $cms = User::where('email', 'cms@email.com')->first();
        $cmsRole = Role::where('name', 'Content Manager')->first();
        $cms->assignRole($cmsRole);

        $admin = User::where('email', 'admin@email.com')->first();
        $adminRole = Role::where('name', 'Municipal Admin')->first();
        $admin->assignRole($adminRole);

        // $admin = User::where('email', 'admin@email.com')->first();
        // $adminRole = Role::where('name', 'System Admin')->first();
        // $admin->assignRole($adminRole);

    }
}
