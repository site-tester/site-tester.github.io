{{-- This file is used for menu items by any Backpack v6 theme --}}
@canAny(['browse_dashboard', 'browse_dashboard_municipal'])
    <li class="nav-item">
        <a class="nav-link" href="{{ backpack_url('dashboard') }}">
            <i class="la la-home nav-icon"></i>
            {{ trans('backpack::base.dashboard') }}
        </a>
    </li>
@endcanAny

@can('browse_cms')
    <x-backpack::menu-item title='Content Management' icon='la la-file-o' :link="backpack_url('page')" />
@endcan

{{-- @can('browse_notification')
    <li class="nav-item">
        <a class="nav-link" href="{{ backpack_url('notification') }}">
            <i class="la la-exclamation-triangle nav-icon"></i>
            Notification
            @if (auth()->user()->unreadNotifications->count() > 0)
                <div class="text-bg-danger border rounded px-1 m-1">
                    {{ auth()->user()->unreadNotifications->count() }}
                </div>
            @endif
        </a>
    </li>
    <x-backpack::menu-item title="Notifications" icon="la la-question" :link="backpack_url('notification')" />
@endcan --}}

@can('browse_auth')
    <x-backpack::menu-dropdown title="User Management" icon="la la-user">
        <x-backpack::menu-dropdown-header title="Authentication" />
        @can('browse_user')
            <x-backpack::menu-dropdown-item title="Users" icon="la la-user-plus" :link="backpack_url('users')" />
        @endcan
        @can('browse_barangay')
            <x-backpack::menu-dropdown-item title="Barangays" icon="la la-home" :link="backpack_url('barangay')" />
        @endcan
        @can('browse_roles')
            <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
        @endcan
        @can('browse_permissions')
            <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
        @endcan
    </x-backpack::menu-dropdown>
@endcan

{{-- <x-backpack::menu-header title="Manage Content" /> --}}
{{-- <x-backpack::menu-item title='Events' icon='la la-trophy' :link="backpack_url('')" /> --}}
{{-- <x-backpack::menu-item title='News' icon='la la-newspaper-o' :link="backpack_url('')" /> --}}
{{-- <x-backpack::menu-item title='Announcements' icon='la la-life-buoy' :link="backpack_url('')" /> --}}
{{-- END CMS --}}

{{-- Notification ToDo --}}


{{-- End Notification --}}
{{-- @can('browse_barangay')
    <x-backpack::menu-dropdown title="Manage Barangay" icon="la la-cubes">
        <x-backpack::menu-dropdown-item title="Barangay Lists" icon="la la-question" :link="backpack_url('barangay')" />
    </x-backpack::menu-dropdown>
@endcan --}}
@can('browse_cms')
    <x-backpack::menu-dropdown title="News/Events" icon="la la-newspaper">
        <x-backpack::menu-dropdown-header title="News/Events" />
        <x-backpack::menu-dropdown-item title="News/Events" icon="la la-newspaper-o" :link="backpack_url('article')" />
        <x-backpack::menu-dropdown-item title="Categories" icon="la la-list" :link="backpack_url('category')" />
        <x-backpack::menu-dropdown-item title="Tags" icon="la la-tag" :link="backpack_url('tag')" />
    </x-backpack::menu-dropdown>
@endcan
@can('browse_inventory')
    {{-- <x-backpack::menu-dropdown title="Manage Inventory" icon="la la-cubes"> --}}
    <x-backpack::menu-item title="Inventory" icon="la la-cubes" :link="backpack_url('item')" />
    {{-- </x-backpack::menu-dropdown> --}}
@endcan

@can('browse_donate')
    <li class="nav-item dropdown {{ request()->is('admin/donation*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="true">
            <i class="nav-icon d-block d-lg-none d-xl-block la la-hand-holding-heart"></i>
            <span>Donations</span>

            {{-- Badge for Dropdown Notification --}}
            <span class="ms-auto bg-danger border border-danger rounded-circle p-1 m-1"
                style="position: absolute; right: 1.2rem;">
                <span class="visually-hidden">New alerts</span>
            </span>

        </a>

        <div class="dropdown-menu {{ request()->is('admin/donation*') ? 'active show' : '' }}" data-bs-popper="static">
            <x-backpack::menu-dropdown-header title="* Ongoing Donation Approval *" />
            {{-- Dropdown Items --}}
            <a class="dropdown-item {{ request()->fullUrlIs(backpack_url('donation?show=Pending')) ? 'active' : '' }}" href="{{ backpack_url('donation?show=Pending') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-stamp"></i>
                <span>Donation Approval</span>
                <span class="ms-auto bg-danger border border-danger rounded-circle p-1 m-1">
                    <span class="visually-hidden">New alerts</span>
                </span>
            </a>
            <x-backpack::menu-dropdown-header title="* Ongoing Active Donation *" />
            <a class="dropdown-item {{ request()->fullUrlIs(backpack_url('donation?show=Active')) ? 'active' : '' }}" href="{{ backpack_url('donation?show=Active') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-toggle-on"></i>
                <span>Active Donations</span>
            </a>
            <x-backpack::menu-dropdown-header title="* Ongoing Donation History *" />
            <a class="dropdown-item" href="{{ backpack_url('') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-history"></i>
                <span>Donation History</span>
            </a>
        </div>
    </li>
@endcan

@can('browse_disaster_report')
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="true">
            <i class="nav-icon d-block d-lg-none d-xl-block la la-house-damage"></i>
            <span>Disaster Request</span>
        </a>
        <div class="dropdown-menu " data-bs-popper="static">
            <x-backpack::menu-dropdown-header title="* Ongoing Create Form *" />
            <a class="dropdown-item" href="{{ backpack_url('disaster-request/create') }}">
                {{-- <i class="nav-icon d-block d-lg-none d-xl-block la la-plus-square"></i> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-plus">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M12 11l0 6" />
                    <path d="M9 14l6 0" />
                  </svg>&nbsp;
                <span>Create Form</span>
            </a>

            <x-backpack::menu-dropdown-header title="* Ongoing Active Disaster Report *" />
            <a class="dropdown-item" href="{{ backpack_url('disaster-request') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-toggle-on"></i>
                <span>Active Disaster Request</span>
            </a>

            <x-backpack::menu-dropdown-header title="* Ongoing Report history *" />
            <a class="dropdown-item" href="{{ backpack_url('') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-history"></i>
                <span>Request History</span>
            </a>
        </div>
    </li>
@endcan

@can('browse_disaster_report_verification')
    <x-backpack::menu-dropdown-header title="* Ongoing Disaster Report Verification *" />
    <li class="nav-item">
        <a class="nav-link" href="{{ backpack_url('disaster-report-verification') }}">
            <i class="la la-house-damage nav-icon"></i>
            <span>Disaster Report Verification</span>

            <span class="ms-auto bg-danger border border-danger rounded-circle p-1 m-1">
                <span class="visually-hidden">New alerts</span>
            </span>

        </a>
    </li>

    {{-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="true">
            <i class="nav-icon d-block d-lg-none d-xl-block la la-house-damage"></i>
            <span>Disaster Report Verification</span>

            <span class="ms-auto bg-danger border border-danger rounded-circle p-1 m-1"
                style="position: absolute; right: 1.2rem;">
                <span class="visually-hidden">New alerts</span>
            </span>
        </a>
        <div class="dropdown-menu " data-bs-popper="static">

            <a class="dropdown-item" href="{{ backpack_url('') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-plus-square"></i>
                <span>Create Form</span>
            </a>
            <a class="dropdown-item" href="{{ backpack_url('') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-toggle-on"></i>
                <span>Active Disaster Report</span>
            </a>
            <a class="dropdown-item" href="{{ backpack_url('') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-history"></i>
                <span>Report History</span>
            </a>
        </div>
    </li> --}}
@endcan
