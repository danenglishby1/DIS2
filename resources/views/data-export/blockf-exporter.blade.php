@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'BLOCKS Data Export')
@section('dataExportsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/select2/select2.min.css')}}"/>
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




<h3>Export Data (Prev 2 Years MAX)</h3>
<hr />


    @section('dateRangePickerOnApplyCallback')

        window.location.href = rootUrl + "/api/BlockfExport?dtFrom="+dtFrom+"&dtTo="+dtTo+"&machine="+$('#machine').val();

    @endsection

<div class="form-group">
<label>Machine</label>
    <select class="form-control" name="machine[]" multiple="multiple" id="machine">
        <option value="all">All</option>
        <option value="101">Weld Mill Len Check</option>
        <option value="200">Hydrotester</option>
        <option value="201">RP20</option>
        <option value="203">M&R Final Alloc</option>
        <option value="204">NDT Site 2</option>
        <option value="300">RHS Furnace</option>
        <option value="302">RHS Saw</option>
        <option value="400">Heurty Furnace</option>
    </select>

</div>
<label>Date Range</label>
        @include('layouts.templates.daterangepicker')



@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/select2/select2.min.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $('#machine').select2();
    });
</script>


@endsection
