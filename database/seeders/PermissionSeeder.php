<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'browse_dashboard',
            // Auth
            'browse_auth',
            'read_auth',
            'edit_auth',
            'add_auth',
            'delete_auth',

            // CMS Permissions
            // User
            'browse_user',
            'read_user',
            'edit_user',
            'add_user',
            'delete_user',

            // Roles
            'browse_roles',
            'read_roles',
            'edit_roles',
            'add_roles',
            'delete_roles',

            // Permissions
            'browse_permissions',
            'read_permissions',
            'edit_permissions',
            'add_permissions',
            'delete_permissions',

            // CMS
            'browse_cms',
            'read_cms',
            'edit_cms',
            'add_cms',
            'delete_cms',

            // End CMS Permissions


            // Barangay Permissions

            // Donate
            'browse_donate',
            'read_donate',
            'edit_donate',
            'add_donate',
            'delete_donate',

            'browse_barangay',
            'read_barangay',
            'edit_barangay',
            'add_barangay',
            'delete_barangay',

            // Inventory Management
            'browse_inventory',
            'read_inventory',
            'edit_inventory',
            'add_inventory',
            'delete_inventory',

            // End Barangay Permissions

            // New Permissions
            'browse_disaster_report',
            'browse_disaster_report_verification',
            'browse_dashboard_municipal',
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign Permission to specific Role
        // Define the Barangay-specific permissions
        $barangayPermissions = [
            'browse_donate',
            'read_donate',
            'edit_donate',
            'add_donate',
            'delete_donate',
            'browse_inventory',
            'read_inventory',
            'edit_inventory',
            'add_inventory',
            'delete_inventory',
            'browse_dashboard',
            'browse_disaster_report',
        ];

        $cmsPermissions = [
            'browse_cms',
            'read_cms',
            'edit_cms',
            'add_cms',
            'delete_cms',
        ];

        $adminPermissions = [
            'browse_dashboard_municipal',
            'browse_auth',
            'read_auth',
            'edit_auth',
            'add_auth',
            'delete_auth',
            'browse_user',
            'read_user',
            'edit_user',
            'add_user',
            'delete_user',
            'browse_roles',
            'read_roles',
            'edit_roles',
            'add_roles',
            'delete_roles',
            'browse_permissions',
            'read_permissions',
            'edit_permissions',
            'add_permissions',
            'delete_permissions',
            'browse_barangay',
            'read_barangay',
            'edit_barangay',
            'add_barangay',
            'delete_barangay',
            'browse_disaster_report_verification',
        ];

        // Get the Barangay Representative role
        $brgyRole = Role::findByName('Barangay Representative');
        $brgyRole->givePermissionTo($barangayPermissions);

        // Get the Content Manager role
        $cmsRole = Role::findByName('Content Manager');
        // Assign all existing permissions to Content Manager Role
        $cmsRole->givePermissionTo($cmsPermissions);

        // Get the Municipal Admin role
        $adminRole = Role::findByName('Municipal Admin');
        // Assign all existing permissions to Municipal Admin Role
        $adminRole->givePermissionTo($adminPermissions);
    }
}
