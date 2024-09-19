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
            // Browse
            'browse_auth',
            'browse_user',
            'browse_roles',
            'browse_permissions',
            'browse_cms',
            'browse_landing',
            'browse_terms',
            'browse_events',
            'browse_news',
            'browse_announcements',
            'browse_notification',
            'browse_donate',
            // Read
            'read_auth',
            'read_user',
            'read_roles',
            'read_permissions',
            'read_cms',
            'read_landing',
            'read_terms',
            'read_events',
            'read_news',
            'read_announcements',
            'read_notification',
            'read_donate',
            // Edit
            'edit_auth',
            'edit_user',
            'edit_roles',
            'edit_permissions',
            'edit_cms',
            'edit_landing',
            'edit_terms',
            'edit_events',
            'edit_news',
            'edit_announcements',
            'edit_notification',
            'edit_donate',
            // Add
            'add_auth',
            'add_user',
            'add_roles',
            'add_permissions',
            'add_cms',
            'add_landing',
            'add_terms',
            'add_events',
            'add_news',
            'add_announcements',
            'add_notification',
            'add_donate',
            // Delete
            'delete_auth',
            'delete_user',
            'delete_roles',
            'delete_permissions',
            'delete_cms',
            'delete_landing',
            'delete_terms',
            'delete_events',
            'delete_news',
            'delete_announcements',
            'delete_notification',
            'delete_donate',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Get the content manager role
        $cmsRole = Role::findByName('Content Manager');

        // Assign all existing permissions
        $cmsRole->givePermissionTo(Permission::all());
    }
}
