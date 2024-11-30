<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
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

        $emails = [
            'bbaclaran@email.com',
            'bdongalo@email.com',
            'blahuerta@email.com',
            'bsandionisio@email.com',
            'bsanisidro@email.com',
            'bstnino@email.com',
            'btambo@email.com',
            'bvitalez@email.com',
            'bbf@email.com',
            'bdonbosco@email.com',
            'bmarcelogreen@email.com',
            'bmerville@email.com',
            'bmoonwalk@email.com',
            'bsanantonio@email.com',
            'bsunvalley@email.com'
        ];
        
        foreach ($emails as $email) {
            $barangay = User::where('email', $email)->first();
            $barangayRole = Role::where('name', 'Barangay Representative')->first();
            $barangay->assignRole($barangayRole);
        }

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
