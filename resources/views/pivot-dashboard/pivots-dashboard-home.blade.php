@extends('layouts.app-pivots')

@section('pageTitle', 'Pivots')
@section('pageName', 'Pivots')
@section('css')

    <script type="text/javascript" src="{{ asset('public/js/pivotJS/plotly.basic.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pivot.css')}}"/>
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

    <div class="simpleflex">
        <div class="fl1-300">
            <div class="flex-text-button-fill">
            <a href="{{ route('weld-mill-stoppages-pivot')}}">

                <h4 class="text-center mt-2">WeldMill Stop Pivot</h4>
            </a>
            </div>
        </div>

        <div class="fl1-300">
            <div class="flex-text-button-fill">
            <a href="{{ route('coil-pipe-pivot')}}">

                <h4 class="text-center mt-2">CoilPipe Tracking Pivot</h4>
            </a>
            </div>
        </div>

        <div class="fl1-300">
            <div class="flex-text-button-fill">
            <a href="{{ route('tracking-pivot')}}">
                <h4 class="text-center mt-2">WIP Tracking Pivot</h4>
            </a>
            </div>
        </div>

        <div class="fl1-300">
            <div class="flex-text-button-fill">
                <a href="{{ route('surplus-tracking-pivot')}}">
                    <h4 class="text-center mt-2">Surplus Tracking Pivot</h4>
                </a>
            </div>
        </div>

        <div class="fl1-300">
            <div class="flex-text-button-fill">
                <a href="{{ route('stock-tracking-pivot')}}">
                    <h4 class="text-center mt-2">Stock Tracking Pivot</h4>
                </a>
            </div>
        </div>

        <div class="fl1-300">
            <div class="flex-text-button-fill">
                <a href="{{ route('order-tracking-pivot')}}">
                    <h4 class="text-center mt-2">Order Tracking Pivot</h4>
                </a>
            </div>
        </div>

        <div class="fl1-300">
            <div class="flex-text-button-fill">
                <a href="{{ route('coil-tracking-pivot')}}">
                    <h4 class="text-center mt-2">Coil Stocks Pivot</h4>
                </a>
            </div>
        </div>

    </div>

@endsection
