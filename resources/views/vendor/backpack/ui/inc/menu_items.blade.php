{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}
    </a>
</li>

@can('browse_notification')
{{-- <li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('notification') }}">
        <i class="la la-exclamation-triangle nav-icon"></i>
        Notification
        @if (auth()->user()->unreadNotifications->count() > 0)
        <div class="text-bg-danger border rounded px-1 m-1">
            {{ auth()->user()->unreadNotifications->count() }}
        </div>
        @endif
    </a>
</li> --}}
<x-backpack::menu-item title="Notifications" icon="la la-question" :link="backpack_url('notification')" />
@endcan

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
    {{-- <x-backpack::menu-dropdown title="Manage Pages" icon="la la-cubes">
        <x-backpack::menu-dropdown-header title="Page CRUD" />
        <x-backpack::menu-dropdown-item title='Pages' icon='la la-file-text' :link="backpack_url('page')" />
        <x-backpack::menu-dropdown-item title='Landing' icon='la la-plane' :link="backpack_url('')" />
        <x-backpack::menu-dropdown-item title='Events' icon='la la-trophy' :link="backpack_url('')" />
        <x-backpack::menu-dropdown-item title='News' icon='la la-newspaper-o' :link="backpack_url('')" />
        <x-backpack::menu-dropdown-item title='Announcements' icon='la la-life-buoy' :link="backpack_url('')" />
        <x-backpack::menu-dropdown-item title="Abouts" icon="la la-question" :link="backpack_url('about')" />
        <x-backpack::menu-dropdown-item title="Contacts" icon="la la-question" :link="backpack_url('contact')" />
        <x-backpack::menu-dropdown-item title='Terms and Conditions' icon='la la-sticky-note' :link="backpack_url('terms')" />
    </x-backpack::menu-dropdown> --}}
    <x-backpack::menu-item title='Pages' icon='la la-file-o' :link="backpack_url('page')" />
@endcan
{{-- <x-backpack::menu-header title="Manage Content" /> --}}
{{-- <x-backpack::menu-item title='Events' icon='la la-trophy' :link="backpack_url('')" />
<x-backpack::menu-item title='News' icon='la la-newspaper-o' :link="backpack_url('')" /> --}}
{{-- <x-backpack::menu-item title='Announcements' icon='la la-life-buoy' :link="backpack_url('')" /> --}}
{{-- END CMS --}}

{{-- Notification ToDo --}}


{{-- End Notification --}}
@can('browse_barangay')
    <x-backpack::menu-dropdown title="Manage Barangay" icon="la la-cubes">
        <x-backpack::menu-dropdown-item title="Barangay Lists" icon="la la-question" :link="backpack_url('barangay')" />
    </x-backpack::menu-dropdown>
@endcan
@can('browse_donate')
    <x-backpack::menu-dropdown title="Manage Donation" icon="la la-cubes">
        <x-backpack::menu-dropdown-item title="Donation Status " icon="la la-question" :link="backpack_url('donation')" />
    </x-backpack::menu-dropdown>
@endcan
@can('browse_inventory')
    <x-backpack::menu-dropdown title="Manage Inventory" icon="la la-cubes">
        <x-backpack::menu-dropdown-item title="Inventory Lists" icon="la la-question" :link="backpack_url('item')" />
    </x-backpack::menu-dropdown>
@endcan



