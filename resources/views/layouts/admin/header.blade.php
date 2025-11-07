<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!-- Begin: Header Menu -->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    {{-- @auth
                        @if(Auth::user()->role == 'admin')
                            <!-- Admin Menu -->
                            <li class="menu-item {{ request()->is('admin/statistics*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('admin.statistics.index') }}" class="menu-link">
                                    <span class="menu-text">Statistics</span>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('admin/users*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('admin.users.index') }}" class="menu-link">
                                    <span class="menu-text">Users</span>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('admin/brands*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('admin.brands.index') }}" class="menu-link">
                                    <span class="menu-text">Brands</span>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('admin/laptops*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('admin.laptops.index') }}" class="menu-link">
                                    <span class="menu-text">Laptops</span>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('admin/orders*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('admin.orders.index') }}" class="menu-link">
                                    <span class="menu-text">Orders</span>
                                </a>
                            </li>
                        @else
                            <!-- User Menu -->
                            <li class="menu-item {{ request()->is('dashboard') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('dashboard') }}" class="menu-link">
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('user/laptops*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('user.laptops.index') }}" class="menu-link">
                                    <span class="menu-text">Laptops</span>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('user/wishlist*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('user.wishlist.index') }}" class="menu-link">
                                    <span class="menu-text">Wishlist</span>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('user/orders*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{ route('user.orders.index') }}" class="menu-link">
                                    <span class="menu-text">My Orders</span>
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
                    @endauth --}}
                </ul>
            </div>
        </div>
        <!-- End: Header Menu -->

        <!-- Begin: Topbar -->
        <div class="topbar">
            {{-- @auth
                @if(Auth::user()->role == 'user')
                    <!-- Search Bar (User only) -->
                    <div class="topbar-item mr-3">
                        <form action="{{ route('user.laptops.index') }}" method="GET" class="d-flex">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Search laptops..."
                                   value="{{ request('search') }}"
                                   style="width: 200px;">
                        </form>
                    </div>

                    <!-- Wishlist Icon (User only) -->
                    <div class="topbar-item mr-3">
                        <a href="{{ route('user.wishlist.index') }}" class="btn btn-icon btn-clean btn-lg position-relative">
                            <i class="flaticon2-heart icon-lg"></i>
                            <span class="label label-sm label-light-primary label-rounded font-weight-bolder position-absolute top-0 right-0" id="wishlist-count">
                                {{ Auth::check() ? \App\Models\Wishlist::where('user_id', Auth::id())->count() : 0 }}
                            </span>
                        </a>
                    </div>

                    <!-- Cart Icon (User only) -->
                    <div class="topbar-item mr-3">
                        <a href="{{ route('user.cart.index') }}" class="btn btn-icon btn-clean btn-lg position-relative">
                            <i class="flaticon2-shopping-cart-1 icon-lg"></i>
                            <span class="label label-sm label-light-danger label-rounded font-weight-bolder position-absolute top-0 right-0" id="cart-count">
                                {{ Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->sum('quantity') : 0 }}
                            </span>
                        </a>
                    </div>
                @endif
            @endauth --}}

            @include('layouts.admin.navbar')
        </div>
        <!-- End: Topbar -->
    </div>
</div>
