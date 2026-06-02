@extends('layouts.app')

@section('pageTitle', 'Energy Tick List')
@section('pageName', 'Energy Tick List')
@section('homeActiveLink', 'active activeUnderline')
@section('css')

@endsection
@section('content')
    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
        <div class="alert alert-success" role="alert">
{{ session('status') }}
            </div>
@endif

        You are logged in!
    </div>
</div>
</div>
</div> -->
    <!-- Content Row -->


    @if(in_array($userId, $adminUsers))
    <div class="simpleflex">

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl_mill.index')}}">
                <h4 class="text-center mt-2">ETL Mills</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl_area.index')}}">
                <h4 class="text-center mt-2">ETL Areas</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl_asset.index')}}">
                <h4 class="text-center mt-2">ETL Assets</h4>
            </a>
        </div>

{{--        <div class="fl1-300">--}}
{{--            <a class="flex-text-button-fill" href="{{ route('etl_mill_area.index')}}">--}}
{{--                <h4 class="text-center mt-2">ETL Mill Areas</h4>--}}
{{--            </a>--}}
{{--        </div>--}}

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl_mill_area_asset.index')}}">
                <h4 class="text-center mt-2">ETL Mill Area Assets</h4>
            </a>
        </div>
    </div>
    @endif
    <div class="simpleflex">



        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl-weld-mill')}}">
                <h4 class="text-center mt-2">Tick List - Weld Mill</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl-rhs')}}">
                <h4 class="text-center mt-2">Tick List - RHS</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl-rounds-finishing')}}">
                <h4 class="text-center mt-2">Tick List - Rounds Fin</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl-casing')}}">
                <h4 class="text-center mt-2">Tick List - Casing</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl-despatch')}}">
                <h4 class="text-center mt-2">Tick List - Despatch</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl-production-services')}}">
                <h4 class="text-center mt-2">Tick List - Prod Services</h4>
            </a>
        </div>

{{--        <div class="fl1-300">--}}
{{--            <a class="flex-text-button-fill" href="{{ route('etl-engineering')}}">--}}
{{--                <h4 class="text-center mt-2">Tick List - Engineering</h4>--}}
{{--            </a>--}}
{{--        </div>--}}

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl-dashboard')}}">
                <h4 class="text-center mt-2">Tick List - Dashboard</h4>
            </a>
        </div>




        @if($userId == 4 || $userId == 5)

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('etl-man')}}">
                <h4 class="text-center mt-2">Man Tick List</h4>
            </a>
        </div>
@endif
    </div>

    {{--        @if(in_array($userId, $allowableUsers))--}}
{{--            <div class="fl1-300">--}}
{{--                <a class="flex-text-button-fill" href="{{ route('moc-department.index')}}">--}}
{{--                    <h4 class="text-center mt-2">Manage Departments</h4>--}}
{{--                </a>--}}
{{--            </div>--}}


{{--            <div class="fl1-300">--}}
{{--                <a class="flex-text-button-fill" href="{{ route('moc-control.index')}}">--}}
{{--                    <h4 class="text-center mt-2">Manage Controls</h4>--}}
{{--                </a>--}}
{{--            </div>--}}

{{--            <div class="fl1-300">--}}
{{--                <a class="flex-text-button-fill" href="{{ route('moc-area-relation.index')}}">--}}
{{--                    <h4 class="text-center mt-2">Manage Area Relations</h4>--}}
{{--                </a>--}}
{{--            </div>--}}

{{--            <div class="fl1-300">--}}
{{--                <a class="flex-text-button-fill" href="{{ route('moc-department-authoriser.index')}}">--}}
{{--                    <h4 class="text-center mt-2">Manage Department Authorisers</h4>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--    @endif--}}


@endsection
