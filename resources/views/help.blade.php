@extends('layouts.app')

@section('pageTitle', 'Help')
@section('pageName', 'Help')
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
    <h3>Line Chart Help</h3>
    <hr/>
    <div class="simpleflex">

        <div>
            <h4 class="help-titles">Toggling data series</h4>
            <video width="100%" height="200" controls style="border: 1px solid #c0c1c8">
                <source src="{{ asset('/public/video/TogglingDataSeries.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="mt-4">
            <h4 class="help-titles">Zooming in on data</h4>
            <video width="100%" height="200" controls style="border: 1px solid #c0c1c8">
                <source src="{{ asset('/public/video/ZoomingInOnData.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <?php
//        try {





        ?>

        {{--        <div class="col-sm">--}}
        {{--                    <a href="">--}}
        {{--                    <img class="img-thumbnail"  src="{{ asset('/public/images/20-weld-mill.jpg') }}" />--}}
        {{--                    <h4 class="text-center mt-2">Weld Mill</h4>--}}
        {{--                    </a>--}}
        {{--              </div>--}}

        {{--              <div class="col-sm">--}}
        {{--                    <a href="">--}}
        {{--                        <img class="img-thumbnail"  src="{{ asset('/public/images/20-weld-mill.jpg') }}" /> --}}
        {{--                        <h4 class="text-center mt-2">Weld Mill</h4>--}}
        {{--                    </a>--}}
        {{--                  </div>--}}


    </div>




@endsection
