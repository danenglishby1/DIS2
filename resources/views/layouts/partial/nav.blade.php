@if (Auth::check())
    @php
        $userRoles = Auth::user()->roles;
        $userHasCustomerServiceRole = false;
        $userHasPAndORole = false;
        $userHasRestrictedRole = false;
        foreach($userRoles as $role) {
            if ($role->name == "Customer Services" || $role->name == "P&O") {
                $userHasCustomerServiceRole = true;
                 $userHasPAndORole = true;
            }

            if ($role->name == "Restricted") {
                $userHasRestrictedRole = true;
            }
        }
    @endphp
@endif




<nav class="navbar navbar-expand-lg navbar-light bg-white shadow" style="margin-bottom: 3em;">

    <a class="navbar-brand" href="{{ route('home') }}"><img src="{{asset('public/images/tata-brand-logo-small.png')}}"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            @if (Auth::check())

                @if(!$userHasCustomerServiceRole || !$userHasPAndORole)
                    <li class="nav-item @yield('homeActiveLink')">
                        <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Mill & Categories
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('weld-mill-home') }}">Weld</a>

                            <a class="dropdown-item" href="{{ route('rhs-home') }}">RHS</a>

                            <a class="dropdown-item" href="{{ route('casing-home') }}">Casing</a>

                            <a class="dropdown-item" href="{{ route('rounds-finishing-home') }}">RF</a>

                            <a class="dropdown-item" href="{{ route('mngr-tracking-home') }}">MillTracking</a>

                            <a class="dropdown-item" href="{{ route('order-tracking-home') }}">OrderTracking</a>

                            <a class="dropdown-item" href="{{ route('engineering-home') }}">Journey to Reliability
                                (J2R)</a>

                            <a class="dropdown-item" href="{{ route('despatch') }}">Despatch</a>

                            <a class="dropdown-item" href="{{ route('quality') }}">Quality</a>

                            <a class="dropdown-item" href="{{ route('slitter-home') }}">Slitter</a>
                        </div>
                    </li>



                    {{--                <li class="nav-item @yield('weldMillActiveLink')">--}}
                    {{--                    <a class="nav-link" href="{{ route('weld-mill-home') }}">Weld</a>--}}
                    {{--                </li>--}}
                    {{--                <li class="nav-item @yield('rhsActiveLink')">--}}
                    {{--                    <a class="nav-link" href="{{ route('rhs-home') }}">RHS</a>--}}
                    {{--                </li>--}}

                    {{--                <li class="nav-item @yield('casingActiveLink')">--}}
                    {{--                    <a class="nav-link" href="{{ route('casing-home') }}">Casing</a>--}}
                    {{--                </li>--}}

                    {{--                <li class="nav-item @yield('roundsFinishingActiveLink')">--}}
                    {{--                    <a class="nav-link" href="{{ route('rounds-finishing-home') }}">RF</a>--}}
                    {{--                </li>--}}

                    {{--                <li class="nav-item @yield('millTrackingActiveLink')">--}}
                    {{--                    <a class="nav-link" href="{{ route('mngr-tracking-home') }}">MillTracking</a>--}}
                    {{--                </li>--}}
                    {{--                <li class="nav-item @yield('orderTrackingActiveLink')">--}}
                    {{--                    <a class="nav-link" href="{{ route('order-tracking-home') }}">OrderTracking</a>--}}
                    {{--                </li>--}}
                    <li class="nav-item @yield('pivotsActiveLink')">
                        <a class="nav-link" href="{{ route('pivots-home') }}">Pivots</a>
                    </li>
                    <li class="nav-item @yield('dataExportsActiveLink')">
                        <a class="nav-link" href="{{ route('data-exports') }}">DataExports</a>
                    </li>
                    <li class="nav-item @yield('dataExportsActiveLink')">
                        <a class="dropdown-item" href="{{ route('moc-home')}}">MoC</a>
                    </li>

                    <li class="nav-item @yield('dataExportsActiveLink')">
                        <a class="dropdown-item" href="{{ route('ncr-home')}}">NCR</a>
                    </li>

                    @include('layouts.partial.planning-menu')

                    @include('layouts.partial.admin')

                    @include('layouts.partial.super')
                    @if($userHasRestrictedRole)
                        @include('layouts.partial.restricted')
                    @endif

                @endif



            @endif
            @if (Auth::check())
                @if($userHasCustomerServiceRole)
                    {{--    <hr class="sidebar-divider">--}}
                    {{--    <!-- Heading -->--}}
                    {{--    <div class="sidebar-heading">--}}
                    {{--        Planning--}}
                    {{--    </div>--}}
                <!-- Nav Item - Dashboard -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            In Development
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('collected-data-view')}}">P & O</a>
                            <a class="dropdown-item" href="{{ route('delivery-performance-dashboard-collected')}}">P & O
                                Dash Collected</a>

                        </div>
                    </li>

                @endif
            @endif



            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest

        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-page-name">@yield('pageName')</li>
        </ul>

    </div>
</nav>
