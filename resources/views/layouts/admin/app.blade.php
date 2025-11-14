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
                            {{-- @auth
                                @if (Auth::user()->role == 'admin')
                                    <!-- Admin Sidebar -->
                                    <li class="menu-item {{ Request::is('admin/statistics*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.statistics.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-architecture-and-city"></i>
                                            </span>
                                            <span class="menu-text">Dashboard</span>
                                        </a>
                                    </li>

                                    <li class="menu-section">
                                        <h4 class="menu-text">Management</h4>
                                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/users*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.users.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-user-outline-symbol"></i>
                                            </span>
                                            <span class="menu-text">Users</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/brands*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.brands.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-list-2"></i>
                                            </span>
                                            <span class="menu-text">Brands</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/laptops*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.laptops.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-laptop"></i>
                                            </span>
                                            <span class="menu-text">Laptops</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/orders*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.orders.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-shopping-cart-1"></i>
                                            </span>
                                            <span class="menu-text">Orders</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('admin/reviews*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.reviews.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-chat-1"></i>
                                            </span>
                                            <span class="menu-text">Reviews</span>
                                        </a>
                                    </li>
                                @else
                                    <!-- User Sidebar -->
                                    <li class="menu-item {{ Request::is('dashboard') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('dashboard') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-architecture-and-city"></i>
                                            </span>
                                            <span class="menu-text">Dashboard</span>
                                        </a>
                                    </li>

                                    <li class="menu-section">
                                        <h4 class="menu-text">Shopping</h4>
                                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                    </li>

                                    <li class="menu-item {{ Request::is('user/laptops*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('user.laptops.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-laptop"></i>
                                            </span>
                                            <span class="menu-text">Laptops</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('user/cart*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('user.cart.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-shopping-cart-1"></i>
                                            </span>
                                            <span class="menu-text">Shopping Cart</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('user/orders*') || Request::is('user/checkout*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('user.orders.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-box-1"></i>
                                            </span>
                                            <span class="menu-text">My Orders</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('user/reviews*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('user.reviews.index') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-chat-1"></i>
                                            </span>
                                            <span class="menu-text">My Reviews</span>
                                        </a>
                                    </li>

                                    <li class="menu-section">
                                        <h4 class="menu-text">Account</h4>
                                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                    </li>

                                    <li class="menu-item {{ Request::is('user/profile*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('user.profile') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon2-user"></i>
                                            </span>
                                            <span class="menu-text">My Profile</span>
                                        </a>
                                    </li>

                                    <li class="menu-item {{ Request::is('user/change-password*') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('user.change-password') }}" class="menu-link">
                                            <span class="svg-icon menu-icon">
                                                <i class="flaticon-lock"></i>
                                            </span>
                                            <span class="menu-text">Change Password</span>
                                        </a>
                                    </li>
                                @endif
                            @else
                                <!-- Guest Sidebar -->
                                <li class="menu-item {{ Request::is('/') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="/" class="menu-link">
                                        <span class="svg-icon menu-icon">
                                            <i class="flaticon2-architecture-and-city"></i>
                                        </span>
                                        <span class="menu-text">Home</span>
                                    </a>
                                </li>
                            @endauth --}}
                            <li class="menu-section">
                                <h4 class="menu-text">Management System</h4>
                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                            </li>

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
                                <a href="#" class="menu-link">
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
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
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
