@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'Linehist Report Data Export')
@section('dataExportsActiveLink', 'active activeUnderline')
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

    <hr/>

    <p>Please enter criteria and submit for download.</p>

    {{--    @section('dateRangePickerOnApplyCallback')--}}

    {{--        window.location.href = rootUrl + "/api/rhsStraightnessDataExport?dtFrom="+dtFrom+"&dtTo="+dtTo;--}}

    {{--    @endsection--}}

    {{--        @include('layouts.templates.daterangepicker')--}}


    <div class="form-group">
        <label for="blockNo">Block No</label>
        <input type="number" class="form-control"  name="blockNo" id="blockNo">

        <label for="rollWeek">Roll Week</label>
        <input type="number" class="form-control" step="any" name="rollWeek" id="rollWeek" placeholder="YYWW">


        <label for="millLine">Mill Line</label>
        <input type="number" class="form-control"  name="millLine" id="millLine">



        <button class="btn btn-primary mt-2" id="querySubmitBtn">Submit</button>
    </div>

@endsection




@section('functionalScripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#querySubmitBtn').click(function () {
            var blockNo = $('#blockNo').val();
            var rollWeek = $('#rollWeek').val();
            var millLine = $('#millLine').val();

            console.log(blockNo, rollWeek, millLine);

            window.location.href = rootUrl + "/api/linehistReportDataExport?blockNo=" + blockNo + "&rollWeek=" + rollWeek + "&millLine=" + millLine;
        });

        // window.location.href = rootUrl + "/api/WeldMillStoppageDataExport?dtFrom="+dtFrom+"&dtTo="+dtTo;
        $('.ajax-loader').css('display', 'none');


    </script>


@endsection
