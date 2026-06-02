




@if (Auth::check())
    @php
        $userRoles = Auth::user()->roles;
        $userHasPlanningRole = false;
        foreach($userRoles as $role) {
            if ($role->name == "Planning") {
                $userHasPlanningRole = true;
            }
        }
    @endphp


    @if($userHasPlanningRole)
        {{--    <hr class="sidebar-divider">--}}
        {{--    <!-- Heading -->--}}
        {{--    <div class="sidebar-heading">--}}
        {{--        Planning--}}
        {{--    </div>--}}
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link @yield('stockReportActiveLink')" href="{{ route('stock-report')}}">
                <span>Stock Report</span></a>
        </li>
    @endif
@endif
