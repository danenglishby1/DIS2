@extends('layouts.app')

@section('pageTitle', 'Weld Mill')
@section('pageName', 'Weld Mill Home')
@section('weldMillActiveLink', 'active activeUnderline')
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
            <a class="flex-text-button-fill" href="{{ route('weld-mill-main-dashboard') }}">
                <h4 class="text-center mt-2">Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('plc-weld-head-dashboard') }}">
                <h4 class="text-center mt-2">Weld PLC Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('annealer-dashboard') }}">
                <h4 class="text-center mt-2">Annealer Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('annealer-pre-start-checks.index') }}">
                <h4 class="text-center mt-2">Annealer Pre Start Checks</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('wm-dimensional-verification.index') }}">
                <h4 class="text-center mt-2">Weld Head Dim Verification</h4>
            </a>
        </div>



        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('wm-stoppage-analysis-dashboard')}}">
                <h4 class="text-center mt-2">Stoppage Analysis Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('wm-manual-measure-analysis')}}">
                <h4 class="text-center mt-2">Manual Measure Analysis</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('wm-gauge-change.index')}}">
                <h4 class="text-center mt-2">Gauge Changes</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('wm-serious-concern.index')}}">
                <h4 class="text-center mt-2">Serious Concerns (QR WM 705)</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('hook-and-camber-coil-data')}}">
                <h4 class="text-center mt-2">Hook & Camber Data Interface</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('weld-mill-stoppage-comment-adder')}}">
                <h4 class="text-center mt-2">Weld Mill Stoppage Comment Adder</h4>
            </a>
        </div>


{{--        <div class="fl1-300">--}}
{{--            <a class="flex-text-button-fill" href="{{ route('wm-macros.index') }}">--}}
{{--                <h4 class="text-center mt-2">Macros</h4>--}}
{{--            </a>--}}
{{--        </div>--}}


    </div>




@endsection
