<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <title>@yield('title', 'Admin Medical')</title>

    <style>
        /* Toggle button styling for Available Days (Mon–Sun) */
        .btn-check {
            position: absolute;
            clip: rect(0, 0, 0, 0);
            width: 1px;
            height: 1px;
            margin: -1px;
            overflow: hidden;
            white-space: nowrap;
            border: 0;
            padding: 0;
        }

        .btn-check+.btn {
            border-radius: 12px;
            padding: 8px 16px;
            transition: all 0.2s ease-in-out;
        }

        /* Default (unchecked) state */
        .btn-check:not(:checked)+.btn {
            background-color: #fff;
            color: #3699FF;
            border-color: #3699FF;
        }

        /* Checked (active) state */
        .btn-check:checked+.btn {
            background-color: #3699FF;
            /* theme primary */
            color: #fff;
            border-color: #3699FF;
        }

        /* Remove hover and focus effects completely */
        .btn-check+.btn:hover,
        .btn-check+.btn:focus,
        .btn-check:not(:checked)+.btn:hover,
        .btn-check:not(:checked)+.btn:focus,
        .btn-check:checked+.btn:hover,
        .btn-check:checked+.btn:focus {
            background-color: inherit !important;
            color: inherit !important;
            border-color: inherit !important;
            box-shadow: none !important;
        }

        /* Optional: remove focus outline entirely for clean UI */
        .btn-check:focus+.btn,
        .btn-check+.btn:focus {
            box-shadow: none !important;
        }
    </style>

</head>

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <a href="#">
            <img alt="Logo" src="{{ asset('images/logo/logo_admin.png') }}" class="h-50px" />
        </a>
        <div class="d-flex align-items-center">
            <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                <span></span>
            </button>
        </div>
    </div>

    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">

            <!-- Begin: Aside -->
            <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
                <div class="brand flex-column-auto" id="kt_brand">
                    <a href="#" class="brand-logo">
                        <img alt="Logo" src="{{ asset('images/logo/logo_admin.png') }}" class="w-200px h-60px" />
                    </a>
                    <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                        <span class="svg-icon svg-icon-xl">
                            <i class="ki ki-double-arrow-back icon-sm"></i>
                        </span>
                    </button>
                </div>

                <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1">
                        <ul class="menu-nav">
                            @auth
                                @if (auth()->user()->role == 'admin')
                                    <li class="menu-item {{ Request::is('admin/users*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.users.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-user"></i>
                                            </span>
                                            <span class="menu-text">Users</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/doctors*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.doctors.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="fas fa-user-md"></i>
                                            </span>
                                            <span class="menu-text">Doctors</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/patients*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.patients.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-user-outline-symbol"></i>
                                            </span>
                                            <span class="menu-text">Patients</span>
                                        </a>
                                    </li>

                                    <li class="menu-section">
                                        <h4 class="menu-text">Medical Management</h4>
                                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/appointments*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.appointments.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-calendar-8"></i>
                                            </span>
                                            <span class="menu-text">Appointments</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/availabilities*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.availabilities.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-calendar-3"></i>
                                            </span>
                                            <span class="menu-text">Doctor Schedules</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/specialties*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.specialties.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-list-3"></i>
                                            </span>
                                            <span class="menu-text">Specialties</span>
                                        </a>
                                    </li>

                                    <li class="menu-section">
                                        <h4 class="menu-text">Locations</h4>
                                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/cities*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.cities.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-location"></i>
                                            </span>
                                            <span class="menu-text">Cities</span>
                                        </a>
                                    </li>

                                    <li class="menu-section">
                                        <h4 class="menu-text">Settings</h4>
                                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/reset-password*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.reset-password.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-lock"></i>
                                            </span>
                                            <span class="menu-text">Reset Password</span>
                                        </a>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                @include('layouts.admin.header')

                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
                        <div
                            class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <div class="d-flex align-items-center flex-wrap mr-1">
                                <div class="d-flex align-items-baseline flex-wrap mr-5">
                                    <h5 class="text-dark font-weight-bold my-1 mr-5">@yield('page-title', 'Dashboard')</h5>
                                    <ul
                                        class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                        <li class="breadcrumb-item">
                                            <a href="#" class="text-muted">Dashboard</a>
                                        </li>
                                        @yield('breadcrumb')
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column-fluid">
                        <div class="container-fluid">
                            @if (session('success'))
                                <div id="flash-success" class="alert alert-success mx-4 mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <script>
                                    (function() {
                                        var el = document.getElementById('flash-success');
                                        if (!el) return;

                                        var timeoutMs = 3000;
                                        setTimeout(function() {
                                            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                                                try {
                                                    (new bootstrap.Alert(el)).close();
                                                    return;
                                                } catch (e) {}
                                            }
                                            el.style.transition = 'opacity .4s ease';
                                            el.style.opacity = '0';
                                            setTimeout(function() {
                                                if (el && el.parentNode) el.parentNode.removeChild(el);
                                            }, 400);
                                        }, timeoutMs);
                                    })();
                                </script>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @yield('content')
                        </div>
                    </div>
                </div>

                @include('layouts.admin.footer')
            </div>

        </div>
    </div>

    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    }
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    @stack('scripts')
</body>

</html>
