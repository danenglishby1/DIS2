@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'Order Tracking')
@section('orderTrackingActiveLink', 'active activeUnderline')
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
    <a class="flex-text-button-fill" href="{{ route('order-pipe-list-view') }}" >
        <h4 class="text-center mt-2">Order Pipe List View</h4>
    </a>
    </div>

    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('block-pipe-list-view') }}" >
            <h4 class="text-center mt-2">Block Pipe List View</h4>
        </a>
    </div>
</div>

@endsection
@section('functionalScripts')



@endsection
