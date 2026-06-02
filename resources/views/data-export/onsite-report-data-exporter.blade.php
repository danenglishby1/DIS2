@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'Onsite Report Data Export')
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
        <label for="size1">Size1</label>
        <input type="number" class="form-control" step="any" name="size1" id="size1">

        <label for="size2">Size2</label>
        <input type="number" class="form-control" step="any" name="size2" id="size2">


        <label for="thickness">Thickness</label>
        <input type="text" class="form-control" step="any" name="thickness" id="thickness"
               placeholder="">

        <label for="processRoute">Process Route</label>
        <select class="form-control" name="processRoute" id="processRoute">
            <option value="R">R</option>
            <option value="B">B</option>
            <option value="F">F</option>
            <option value="H">H</option>
            <option value="L">L</option>
            <option value="N">N</option>
            <option value="O">O</option>
            <option value="P">P</option>
            <option value="Q">Q</option>
            <option value="T">T</option>
            <option value="V">V</option>
            <option value="X">X</option>
            <option value="Z">Z</option>
        </select>

        <label for="trimmed">Trim</label>
        <select class="form-control" name="trimmed" id="trimmed">
            <option value="N/A">N/A</option>
            <option value="Y">Y</option>
            <option value="N">N</option>
        </select>

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
            var size1 = $('#size1').val();
            var size2 = $('#size2').val();
            var thickness = $('#thickness').val();
            var processRoute = $('#processRoute').val();
            var trimmed = $('#trimmed').val();

            console.log(size1, size2, thickness, processRoute, trimmed);

            window.location.href = rootUrl + "/api/OnsiteReportDataExport?size1=" + size1 + "&size2=" + size2 + "&thickness=" + thickness + "&processRoute=" + processRoute + "&trimmed=" + trimmed;
        });

        // window.location.href = rootUrl + "/api/WeldMillStoppageDataExport?dtFrom="+dtFrom+"&dtTo="+dtTo;
        $('.ajax-loader').css('display', 'none');


    </script>


@endsection
