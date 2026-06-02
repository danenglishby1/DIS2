@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'Mill Tracking')
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
    <a class="flex-text-button-fill" href="{{ route('pipe-list', ["all"=>"true"]) }}" >
        <h4 class="text-center mt-2">ALL WIP</h4>
    </a>
    </div>
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('wip') }}" >
        <h4 class="text-center mt-2">ALL WIP (BY SIZE)</h4>
    </a>
    </div>
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('pipe-list-dept', ["dept"=>"Finishing"]) }}" >
        <h4 class="text-center mt-2">FINISHING WIP</h4>
    </a>
    </div>
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('pipe-list-dept', ["dept"=>"Despatch"]) }}" >
        <h4 class="text-center mt-2">DESPATCH WIP</h4>
    </a>
    </div>
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('pipe-list-dept', ["dept"=>"Casing"]) }}" >
        <h4 class="text-center mt-2">CASING WIP</h4>
    </a>
    </div>
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('pipe-list-dept', ["dept"=>"Weld Mill"]) }}" >
        <h4 class="text-center mt-2">WELD MILL WIP</h4>
    </a>
    </div>
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('pipe-list-dept', ["dept"=>"RHS"]) }}" >
        <h4 class="text-center mt-2">RHS WIP</h4>
    </a>
    </div>
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('pipe-list-dept', ["dept"=>"NDT"]) }}" >
        <h4 class="text-center mt-2">NDT WIP</h4>
    </a>
    </div>
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('pipe-list-dept', ["dept"=>"Prod Serv"]) }}" >
        <h4 class="text-center mt-2">PROD SERV WIP</h4>
    </a>
    </div>
    <div class="fl1-300">
    <a class="flex-text-button-fill" href="{{ route('stock-pipe-list') }}" >
        <h4 class="text-center mt-2">STOCK WIP</h4>
    </a>
    </div>

    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('scrap-dg-pipe-list') }}" >
            <h4 class="text-center mt-2">SCRAP / DG LIST</h4>
        </a>
    </div>


    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('throughput') }}" >
            <h4 class="text-center mt-2">THROUGHPUT/CYCLE TIME</h4>
        </a>
    </div>

    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('coil-desp-not-received') }}" >
            <h4 class="text-center mt-2">COIL DESP NOT RECEIVED</h4>
        </a>
    </div>

    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('test-piece-result-distribution') }}" >
            <h4 class="text-center mt-2">TEST RESULT DISTRIBUTION</h4>
        </a>
    </div>

    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('production-stats') }}" >
            <h4 class="text-center mt-2">PRODUCTION STATS</h4>
        </a>
    </div>

    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('test-piece-order-pipe-tracking') }}" >
            <h4 class="text-center mt-2">TEST PIECE ORDER PIPE TRACKING</h4>
        </a>
    </div>

    <div class="fl1-300">
        <a class="flex-text-button-fill" href="{{ route('mill-pen-tracking') }}" >
            <h4 class="text-center mt-2">MILL PEN TRACKING</h4>
        </a>
    </div>

</div>

@endsection
@section('functionalScripts')



@endsection
