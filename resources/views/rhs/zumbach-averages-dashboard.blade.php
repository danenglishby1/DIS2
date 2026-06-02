@extends('layouts.app')

@section('pageTitle', 'Zumbach Averages Dashboard')
@section('pageName', 'Zumbach Averages Dashboard')

@section('content')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>

@endsection
@section('overrideStartEndDate')
    start = moment().subtract(1, 'day').startOf('day');
    end = moment().endOf('day');

    var urlParams = new URLSearchParams(window.location.search);
    var dtFrom = urlParams.get('dtFrom');
    var dtTo = urlParams.get('dtTo');

    if (dtFrom !== null) {
    start = moment(dtFrom);
    end = moment(dtTo);
    }
@endsection
@section('dateRangePickerOnApplyCallback')


    window.dtFrom = dtFrom;
    window.dtTo = dtTo;

    window.location.href = rootUrl + "/despatch/wfshipping?dtFrom="+dtFrom+"&dtTo="+dtTo;

@endsection

<div style="text-align: center;
    margin-top: -50px;">
    <h2>Zumbach Averages Dashboard</h2>
</div>


<div class="filters" style="justify-content: normal;">
    @include('layouts.templates.daterangepicker')
</div>
<div class="mb-3"></div>



@endsection

@section('functionalScripts')


    <script>

    </script>

@endsection
