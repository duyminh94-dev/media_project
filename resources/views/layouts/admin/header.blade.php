<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!-- Begin: Header Menu -->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    <!-- Admin Menu Only -->
                    <li class="menu-item {{ request()->is('admin/users*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                        <a href="{{ route('admin.users.index') }}" class="menu-link">
                            <span class="menu-text">Users</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/doctors*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                        <a href="{{ route('admin.doctors.index') }}" class="menu-link">
                            <span class="menu-text">Doctors</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/patients*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                        <a href="{{ route('admin.patients.index') }}" class="menu-link">
                            <span class="menu-text">Patients</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/appointments*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                        <a href="{{ route('admin.appointments.index') }}" class="menu-link">
                            <span class="menu-text">Appointments</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/availabilities*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                        <a href="{{ route('admin.availabilities.index') }}" class="menu-link">
                            <span class="menu-text">Schedules</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/specialties*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                        <a href="{{ route('admin.specialties.index') }}" class="menu-link">
                            <span class="menu-text">Specialties</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/cities*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                        <a href="{{ route('admin.cities.index') }}" class="menu-link">
                            <span class="menu-text">Cities</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End: Header Menu -->

        <!-- Begin: Topbar -->
        <div class="topbar">
            @include('layouts.admin.navbar')
        </div>
        <!-- End: Topbar -->
    </div>
</div>
