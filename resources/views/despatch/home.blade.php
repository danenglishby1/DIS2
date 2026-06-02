@extends('layouts.app')

@section('pageTitle', 'Despatch Home')
@section('pageName', 'Despatch Home Home')
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
            <a class="flex-text-button-fill" href="{{ route('desp-dashboard') }}">
                <h4 class="text-center mt-2">Main Despatch Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('desp-order-tracking-dashboard') }}">
                <h4 class="text-center mt-2">Order Tracking Despatch Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('desp-rfd-dashboard') }}">
                <h4 class="text-center mt-2">RFD Despatch Dashboard</h4>
            </a>
        </div>


        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('desp-non-prime-stock-dashboard') }}">
                <h4 class="text-center mt-2">NonPrime Stock Despatch Dashboard</h4>
            </a>
        </div>

    </div>




@endsection
