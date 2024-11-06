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

            // Landing
            'browse_landing',
            'read_landing',
            'edit_landing',
            'add_landing',
            'delete_landing',

            // Terms
            'browse_terms',
            'read_terms',
            'edit_terms',
            'add_terms',
            'delete_terms',

            // Events
            'browse_events',
            'read_events',
            'edit_events',
            'add_events',
            'delete_events',

            // News
            'browse_news',
            'read_news',
            'edit_news',
            'add_news',
            'delete_news',

            // Announcements
            'browse_announcements',
            'read_announcements',
            'edit_announcements',
            'add_announcements',
            'delete_announcements',

            // End CMS Permissions


            // Barangay Permissions

            // Notification
            'browse_notification',
            'read_notification',
            'edit_notification',
            'add_notification',
            'delete_notification',

            // Donate
            'browse_donate',
            'read_donate',
            'edit_donate',
            'add_donate',
            'delete_donate',

            // Donations Management
            // 'browse_donations',
            // 'read_donations',
            // 'edit_donations',
            // 'add_donations',
            // 'delete_donations',

            'browse_donations_status',
            'read_donations_status',
            'edit_donations_status',
            'add_donations_status',
            'delete_donations_status',

            'browse_barangay',
            'read_barangay',
            'edit_barangay',
            'add_barangay',
            'delete_barangay',

            'browse_donation_transparency_board',
            'read_donation_transparency_board',
            'edit_donation_transparency_board',
            'add_donation_transparency_board',
            'delete_donation_transparency_board',

            // Inventory Management
            'browse_inventory',
            'read_inventory',
            'edit_inventory',
            'add_inventory',
            'delete_inventory',

            'browse_generate_inventory_report',

            // Donor Coordination
            'read_donation_history',

            // Logging and Documentation
            'generate_donation_report',
            'update_donation_log',

            // End Barangay Permissions
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign Permission to specific Role
        // Define the Barangay-specific permissions
        $barangayPermissions = [
            'browse_notification',
            'read_notification',
            'edit_notification',
            'add_notification',
            'delete_notification',
            'browse_donate',
            'read_donate',
            'edit_donate',
            'add_donate',
            'delete_donate',
            'browse_donations_status',
            'read_donations_status',
            'edit_donations_status',
            'add_donations_status',
            'delete_donations_status',
            'browse_donation_transparency_board',
            'read_donation_transparency_board',
            'edit_donation_transparency_board',
            'add_donation_transparency_board',
            'delete_donation_transparency_board',
            'browse_inventory',
            'read_inventory',
            'edit_inventory',
            'add_inventory',
            'delete_inventory',
            'browse_generate_inventory_report',
            'read_donation_history',
            'generate_donation_report',
            'update_donation_log',
            'browse_dashboard',
        ];

        $cmsPermissions = [
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
            'browse_cms',
            'read_cms',
            'edit_cms',
            'add_cms',
            'delete_cms',
            'browse_landing',
            'read_landing',
            'edit_landing',
            'add_landing',
            'delete_landing',
            'browse_terms',
            'read_terms',
            'edit_terms',
            'add_terms',
            'delete_terms',
            'browse_events',
            'read_events',
            'edit_events',
            'add_events',
            'delete_events',
            'browse_news',
            'read_news',
            'edit_news',
            'add_news',
            'delete_news',
            'browse_announcements',
            'read_announcements',
            'edit_announcements',
            'add_announcements',
            'delete_announcements',
            'browse_barangay',
            'read_barangay',
            'edit_barangay',
            'add_barangay',
            'delete_barangay',
            // 'browse_notification',
            // 'read_notification',
            // 'edit_notification',
            // 'add_notification',
            // 'delete_notification',

        ];

        // $cmsPermissions = [
        //     'browse_auth',
        //     'read_auth',
        //     'edit_auth',
        //     'add_auth',
        // ];


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
        $adminRole->givePermissionTo($cmsPermissions);
    }
}
