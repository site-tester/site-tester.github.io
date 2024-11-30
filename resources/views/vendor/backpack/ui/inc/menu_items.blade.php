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
@php
    $unreadPendingDonationNotification = auth()
        ->user()
        ->unreadNotifications()
        ->where('data->notification_to', 'Donation Approval Tab')
        ->where('data->donation_status', 'Pending Approval')
        ->exists();

    $unreadPendingDisasterRequestNotification = auth()
        ->user()
        ->unreadNotifications()
        ->where('data->notification_to', 'Admin Request Approval Tab')
        ->where('data->request_status', 'Pending Approval')
        ->exists();
@endphp
@can('browse_donate')
    <li class="nav-item dropdown {{ request()->is('admin/donation*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="true">
            <i class="nav-icon d-block d-lg-none d-xl-block la la-hand-holding-heart"></i>
            <span>Donations</span>
            {{-- Badge for Dropdown Notification --}}
            @if ($unreadPendingDonationNotification)
                <span class="ms-auto bg-danger border border-danger rounded-circle p-1 m-1"
                    style="position: absolute; right: 1.2rem;">
                    <span class="visually-hidden">New alerts</span>
                </span>
            @endif
        </a>

        <div class="dropdown-menu {{ request()->is('admin/donation*') ? 'active show' : '' }}" data-bs-popper="static">

            <a class="dropdown-item {{ request()->fullUrlIs(backpack_url('donation?show=Pending')) ? 'active' : '' }}"
                href="{{ backpack_url('donation?show=Pending') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-stamp"></i>
                <span>Donation Approval</span>

                @if ($unreadPendingDonationNotification)
                    <span class="ms-auto bg-danger border border-danger rounded-circle p-1 m-1">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                @endif

            </a>

            <a class="dropdown-item {{ request()->fullUrlIs(backpack_url('donation?show=Active')) ? 'active' : '' }}"
                href="{{ backpack_url('donation?show=Active') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-toggle-on"></i>
                <span>Active Donations</span>
            </a>
            <a class="dropdown-item {{ request()->fullUrlIs(backpack_url('donation?show=History')) ? 'active' : '' }}"
                href="{{ backpack_url('donation?show=History') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-history"></i>
                <span>Donation History</span>
            </a>
        </div>
    </li>
@endcan

@can('browse_disaster_report')
    <li class="nav-item dropdown {{ request()->is('admin/disaster-request*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="true">
            <i class="nav-icon d-block d-lg-none d-xl-block la la-house-damage"></i>
            <span>Disaster Request</span>
        </a>
        <div class="dropdown-menu {{ request()->is('admin/disaster-request*') ? 'active show' : '' }}"
            data-bs-popper="static">

            <a class="dropdown-item {{ request()->fullUrlIs(backpack_url('disaster-request/create')) ? 'active' : '' }}"
                href="{{ backpack_url('disaster-request/create') }}">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-plus">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M12 11l0 6" />
                    <path d="M9 14l6 0" />
                </svg>&nbsp;
                <span>Create Form</span>
            </a>

            <a class="dropdown-item {{ request()->fullUrlIs(backpack_url('disaster-request?show=Active')) ? 'active' : '' }}"
                href="{{ backpack_url('disaster-request?show=Active') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-toggle-on"></i>
                <span>Active Disaster Request</span>
            </a>

            <a class="dropdown-item {{ request()->fullUrlIs(backpack_url('disaster-request?show=History')) ? 'active' : '' }}"
                href="{{ backpack_url('disaster-request?show=History') }}">
                <i class="nav-icon d-block d-lg-none d-xl-block la la-history"></i>
                <span>Request History</span>
            </a>
        </div>
    </li>
@endcan

@can('browse_inventory')
    {{-- <x-backpack::menu-dropdown title="Manage Inventory" icon="la la-cubes"> --}}
    {{-- <x-backpack::menu-item title="Transfer" icon="la la-cubes" :link="backpack_url('donation-transfer')" /> --}}
    {{-- </x-backpack::menu-dropdown> --}}
    <li class="nav-item {{ request()->fullUrlIs(backpack_url('transfer-donation/*')) ? 'active' : '' }}">
        <a class="nav-link {{ request()->fullUrlIs(backpack_url('transfer-donation/*')) ? 'active' : '' }}" href="{{ backpack_url('transfer-donation') }}">
            <i class="la la-cubes nav-icon"></i>
            <span>Transfer</span>
        </a>
    </li>
@endcan

@can('browse_disaster_report_verification')
    {{-- <x-backpack::menu-dropdown-header title="* Ongoing Disaster Report Verification *" /> --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ backpack_url('disaster-report-verification') }}">
            <i class="la la-house-damage nav-icon"></i>
            <span>Disaster Report Verification</span>

            @if ($unreadPendingDisasterRequestNotification)
                <span class="ms-auto bg-danger border border-danger rounded-circle p-1 m-1">
                    <span class="visually-hidden">New alerts</span>
                </span>
            @endif
        </a>
    </li>
@endcan
