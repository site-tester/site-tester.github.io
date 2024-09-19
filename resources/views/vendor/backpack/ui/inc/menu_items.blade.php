{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}
    </a>
</li>

@can('browse_auth')
    <x-backpack::menu-dropdown title="Manage User" icon="la la-user">
        <x-backpack::menu-dropdown-header title="Authentication" />
        @can('browse_user')
            <x-backpack::menu-dropdown-item title="Users" icon="la la-user-plus" :link="backpack_url('user')" />
        @endcan
        @can('browse_roles')
            <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
        @endcan
        @can('browse_permissions')
            <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
        @endcan
    </x-backpack::menu-dropdown>
@endcan

{{-- CMS --}}
@can('browse_cms')
    <x-backpack::menu-dropdown title="Manage Pages" icon="la la-cubes">
        <x-backpack::menu-dropdown-header title="Page CRUD" />
        <x-backpack::menu-dropdown-item title='Pages' icon='la la-file-text' :link="backpack_url('page')" />
        <x-backpack::menu-dropdown-item title='Landing' icon='la la-plane' :link="backpack_url('')" />
        <x-backpack::menu-dropdown-item title='Terms and Conditions' icon='la la-sticky-note' :link="backpack_url('')" />

    </x-backpack::menu-dropdown>
@endcan
{{-- <x-backpack::menu-header title="Manage Content" /> --}}
<x-backpack::menu-item title='Events' icon='la la-trophy' :link="backpack_url('')" />
<x-backpack::menu-item title='News' icon='la la-newspaper-o' :link="backpack_url('')" />
<x-backpack::menu-item title='Announcements' icon='la la-life-buoy' :link="backpack_url('')" />
{{-- END CMS --}}

{{-- Notification ToDo--}}
<x-backpack::menu-item title='Notifications' icon='la la-exclamation-triangle' :link="backpack_url('')" />
{{-- End Notification --}}
