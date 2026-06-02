@extends('layouts.app')

@section('pageTitle', 'RHS Stretch Factors')
@section('pageName', 'RHS Stretch Factors')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/libraries/select2/select2.min.css') }}" rel="stylesheet">

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
@section('overrideStartEndDate')
    start = moment().day('Sunday');
    end = moment().day('Saturday');

    window.dtFrom = start.format('Y-MM-DD 00:00:01');
    window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.


@endsection
@section('dateRangePickerOnApplyCallback')
    window.dtFrom = dtFrom;
    window.dtTo = dtTo;
    $.ajax({
    type: 'POST',
    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
    url: rootUrl+'/api/get-rhs-stetch-factor-data',
    dataType: 'json',
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    success: function (data) {
    console.log(data);
{{--    FormatDataAndBuildCharts(data.furnaceChartData);--}}
    globalTable.destroy();
    var rows = BuildTableRows(data.furnaceStatRawData);
    InjectTableRows(rows);
    InitiateTable();

    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection
<div class="filters" style="justify-content: normal;margin-bottom: 10px;">


    <label>Size/Thick Picker : </label>
    <select name="sizeThickSelector" id="sizeThickSelector">
        @foreach ($strfactData as $v)

        <option value="{{$v["PIPE_SIZE1"]}}_{{$v["PIPE_SIZE2"]}}_{{$v["BLOCK_THICK"]}}">S1: {{$v["PIPE_SIZE1"]}} S2: {{$v["PIPE_SIZE2"]}} THK: {{$v["BLOCK_THICK"]}}</option>

        @endforeach
    </select>

    <button id="getDataBtn">Get Data</button>

</div>


<div class="row">
    <div class="col-xl-12 col-lg-12">

                <table id="stretchFactor-table" class="table table-striped">
                    <thead>
                    <th>Section</th>
                    <th>Pipe No</th>
                    <th>Roll Week</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>Thk</th>
                    <th>WM Length</th>
                    <th>STRM Length</th>
                    <th>Allocated Length</th>
                    <th>Current Length</th>
                    <th>FES Losses</th>
                    <th>RES Losses</th>
                    <th>FES + RES Losses</th>
                    <th>TPM Losses</th>
                    <th>Stretch (M)</th>
                    <th>Stretch Actual %</th>
                    <th>Tandem Stretch Factor %</th>
                    <th>Scrap Allowance</th>
                    </thead>
                    <tbody>
                    @foreach($straightnessFactorAllData as $k => $v)
                        <tr>
                            <td>{{$k}}</td>
                            <td>{{$v["TRACK_CODE"]}}</td>
                            <td>{{$v["ROLL_WEEK"]}}</td>
                            <td>{{$v["SIZE1"]}}</td>
                            <td>{{$v["SIZE2"]}}</td>
                            <td>{{$v["THK"]}}</td>
                            <td>{{$v["WELDMILL_LENGTH"]}}</td>
                            <td>{{$v["STRM_LENGTH"]}}</td>
                            <td>{{$v["ALLOCATED_LENGTH"]}}</td>
                            <td>{{$v["PIPE_LENGTH"]}}</td>
                            <td>{{$v["FES_LOSSES"]}}</td>
                            <td>{{$v["RES_LOSSES"]}}</td>
                            <td>{{$v["PIPE_LOSSES"]}}</td>
                            <td>{{$v["TPM_LOSSES"]}}</td>
                            <td>{{$v["STRM_LENGTH"] - $v["WELDMILL_LENGTH"]}}</td>
                            <td>{{ round(($v["STRM_LENGTH"] - $v["WELDMILL_LENGTH"]) / $v["WELDMILL_LENGTH"] * 100, 2) }}%</td>
                            <td>{{$v["STRETCH_FACTOR"]}}</td>
                            <td>{{$v["SCRAP_ALLOWANCE"]}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <th>Section</th>
                    <th>Pipe No</th>
                    <th>Roll Week</th>
                    <th>S1</th>
                    <th>S2</th>
                    <th>Thk</th>
                    <th>WM Length</th>
                    <th>STRM Length</th>
                    <th>Allocated Length</th>
                    <th>Current Length</th>
                    <th>FES Losses</th>
                    <th>RES Losses</th>
                    <th>FES + RES Losses</th>
                    <th>TPM Losses</th>
                    <th>Stretch (M)</th>
                    <th>Stretch Actual %</th>
                    <th>Tandem Stretch Factor %</th>
                    <th>Scrap Allowance</th>
                    </tfoot>
                </table>
                <div>
                </div>
            </div>

</div>


@endsection
@section('functionalScripts')

    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    {{--            <!-- Extension scripts for datatables print functionality -->--}}
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <script src="{{ asset('public/libraries/select2/select2.min.js')}}"></script>


    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




        $( "#getDataBtn" ).on( "click", function() {

            console.log("clicked");


            var sizeThickStrArr = $('#sizeThickSelector').val().split('_');
            console.log(sizeThickStrArr)
            let sdfsdf = "";

            let url = rootUrl + "/rhs/stretch-factors?s1=" + sizeThickStrArr[0] + "&s2=" + sizeThickStrArr[1] + "&thk=" + sizeThickStrArr[2];
            window.location.href = url;

        });



            $(document).ready( function () {

                var table = $('#stretchFactor-table').DataTable({
                    dom: 'Bfrtip',
                     buttons: ['print', 'excel'],

                    initComplete: function () {
                        count = 0;
                        this.api().columns().every( function () {
                            var title = this.header();
                            //replace spaces with dashes
                            title = $(title).html().replace(/[\W]/g, '-');
                            var column = this;
                            var select = $('<select id="' + title + '" class="select2" ></select>')
                                .appendTo( $(column.footer()).empty() )
                                .on( 'change', function () {
                                    //Get the "text" property from each selected data
                                    //regex escape the value and store in array
                                    var data = $.map( $(this).select2('data'), function( value, key ) {
                                        return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                                    });

                                    //if no data selected use ""
                                    if (data.length === 0) {
                                        data = [""];
                                    }

                                    //join array into string with regex or (|)
                                    var val = data.join('|');

                                    //search for the option(s) selected
                                    column
                                        .search( val ? val : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' );
                            } );

                            //use column title as selector and placeholder
                            $('#' + title).select2({
                                multiple: true,
                                closeOnSelect: false,
                                placeholder: "Select a " + title
                            });

                            //initially clear select otherwise first option is selected
                            $('.select2').val(null).trigger('change');
                        } );
                    }
                });
            } );


    </script>
@endsection
