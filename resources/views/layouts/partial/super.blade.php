<!-- if user has 'Super' role assigned to them. -->

@if (Auth::user()->hasRole("SuperSuper") || Auth::user()->hasRole("GlobalSettingAdmin"))


    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            System
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
    @if (Auth::user()->hasRole("SuperSuper"))
                <a class="dropdown-item" href="{{ route('rhs-changelog-view') }}">Changelog View</a>
                <a class="dropdown-item" href="{{ route('users.index')}}">Users</a>
                <a class="dropdown-item" href="{{ route('roles.index')}}">Roles</a>
                <a class="dropdown-item" href="{{ route('logon-activity')}}">Logon Activity</a>
                <a class="dropdown-item" href="<?php echo $rootUrl; ?>/log-viewer/logs">System
                    Logs</a>
                <a class="dropdown-item" href="{{ route('admin-tools-home')}}">Admin Tools</a>
                <a class="dropdown-item" href="{{ route('admin-tools-dashboard')}}">Admin Dash</a>
                <a class="dropdown-item" href="{{ route('pivot-configs.index')}}">Pivot Config Manager</a>

     @endif
        @if (Auth::user()->hasRole("GlobalSettingAdmin") || Auth::user()->hasRole("SuperSuper"))
                <a class="dropdown-item" href="{{ route('global-settings.index')}}">Global Settings</a>
        @endif


        </div>
        </li>

        @include('layouts.partial.pages-in-development')

    @endif

