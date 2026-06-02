@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'Data Exports')
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




<h3>Export Data (Prev 2 Years MAX)</h3>
<hr />

    <p>Please select date range and apply for download.</p>

    @section('dateRangePickerOnApplyCallback')

        window.location.href = rootUrl + "/api/WeldMillStoppageDataExport?dtFrom="+dtFrom+"&dtTo="+dtTo;
        $('.ajax-loader').css('display', 'none');
    @endsection

        @include('layouts.templates.daterangepicker')


@endsection
@section('functionalScripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


@endsection
