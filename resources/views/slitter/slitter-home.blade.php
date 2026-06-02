@extends('layouts.app')

@section('pageTitle', 'Slitter Home')
@section('pageName', 'Slitter')
@section('millTrackingActiveLink', 'active activeUnderline')
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



<div class="simpleflex">
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('slit-coil-lookup') }}" >
        <h4 class="text-center mt-2">SLIT COIL LOOKUP</h4>
    </a>
    </div>

    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('slitter-main-dashboard') }}" >
            <h4 class="text-center mt-2">DASHBOARD</h4>
        </a>
    </div>


    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('slitter-stoppage-analysis-dashboard')}}">
            <h4 class="text-center mt-2">Slitter Stoppage Analysis Dashboard</h4>
        </a>
    </div>

</div>

@endsection
@section('functionalScripts')



@endsection
