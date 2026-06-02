<!-- if user has 'Super' role assigned to them. -->
@if (Auth::user()->hasRole("Super"))

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

            <a class="collapse-item" href="{{ route('logon-activity')}}">Logon Activity</a>
        </div>
    </li>

    @include('layouts.partial.pages-in-development')

@endif
