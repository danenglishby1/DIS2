@extends('layouts.app')

@section('pageTitle', 'Casing')
@section('pageName', 'Casing Home')
@section('casingActiveLink', 'active activeUnderline')
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


    <div class="simpleflex">
        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('casing-furnace-dashboard')}}">
                <h4 class="text-center mt-2">Furnace Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('casing-cooling-dashboard')}}">
                <h4 class="text-center mt-2">Cooling Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('casing-temperature-control')}}">
                <h4 class="text-center mt-2">Furnace Temp Control</h4>
            </a>
        </div>

{{--        <div class="fl1-300">--}}
{{--            <a class="flex-text-button-fill" href="{{ route('casing-cooling-summary')}}">--}}
{{--                <h4 class="text-center mt-2">Cooling Summary</h4>--}}
{{--            </a>--}}
{{--        </div>--}}


        {{--        <div class="fl1-300">--}}
        {{--            <a class="flex-text-button-fill" href="{{ route('straightness-analysis')}}">--}}
        {{--                <h4 class="text-center mt-2">Straightness Analysis</h4>--}}
        {{--            </a>--}}
        {{--        </div>--}}
    </div>




@endsection
