<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!-- Begin: Header Menu -->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    @auth
                        @if(Auth::user()->role == 'admin')
                            <!-- Admin Menu -->
                            <li class="menu-item {{ request()->is('admin/users*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('admin.users.index') }}" class="menu-link">
                                    <span class="menu-text">Users</span>
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
                        @elseif(Auth::user()->role == 'doctor')
                            <!-- Doctor Menu -->
                            <li class="menu-item {{ request()->is('doctors/dashboard') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('doctors.dashboard') }}" class="menu-link">
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>
                        @else
                            <!-- Patient Menu -->
                            <li class="menu-item {{ request()->is('patient/dashboard') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('patient.dashboard') }}" class="menu-link">
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('patient/doctors*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('patient.doctors') }}" class="menu-link">
                                    <span class="menu-text">Doctors</span>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('patient/appointments*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('patient.appointments') }}" class="menu-link">
                                    <span class="menu-text">My Appointments</span>
                                </a>
                            </li>
                        @endif
                    @else
                        <!-- Guest Menu -->
                        <li class="menu-item menu-item-active" aria-haspopup="true">
                            <a href="{{ url('/') }}" class="menu-link">
                                <span class="menu-text">Home</span>
                            </a>
                        </li>
                    @endauth
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
