@extends('layouts.app')

@section('pageTitle', 'End Laser Summary')
@section('pageName', 'End Laser Summary')
@section('roundsFinishingActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}" />
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
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


@section('overrideStartEndDate')
    start = moment();
    end = moment();

    window.dtFrom = start.format('Y-MM-DD 00:00:01');
    window.dtTo = end.format('Y-MM-DD 23:59:59'); // Set dt from/to as global.
@endsection
@section('dateRangePickerOnApplyCallback')
    window.dtFrom = dtFrom;
    window.dtTo = dtTo;
    $.ajax({
    type: 'POST',
    data: {'dtFrom': dtFrom, 'dtTo': dtTo},
    url: rootUrl+'/api/GetRFSummaryData',
    dataType: 'json',
    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
    $('.ajax-loader').css('display', 'block');
    },
    success: function (data) {
    console.log(data.data);


    // Clear table object before creating new instance.
    table.destroy();
    // Build up HTML with BuildNewRows() function
    var newRows = BuildNewRows(data.data);
    // empty table.
    $('#end-laser-table').find('tbody').empty();
    // append new rows from api.
    $('#end-laser-table').find('tbody').append(newRows);

    table = $('#end-laser-table').DataTable({
    dom: 'Bfrtip',
    buttons: ['print', 'excel'],
    "order": [[ 1, "desc" ]]
    });

    },
    complete: function () {
    $('.ajax-loader').css('display', 'none');
    }
    });
@endsection

<div class="filters" style="justify-content: normal;">
    @include('layouts.templates.daterangepicker')
</div>
<div class="mb-3"></div>

    <div class="row">
        <div class="col-xl-12 col-lg-12">

            <table id="end-laser-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>PipeId</th>
                    <th>DateTime</th>
                    <th>LeadingEnd</th>
                    <th>ODAvg</th>
                    <th>ODMax</th>
                    <th>ODMin</th>
                    <th>ODOutOfTol</th>
                    <th>IDAvg</th>
                    <th>IDMax</th>
                    <th>IDMin</th>
                    <th>IDOutOfTol</th>
                    <th>WTAvg</th>
                    <th>WTMax</th>
                    <th>WTMin</th>
                    <th>WTOutOfTol</th>
                    <th>Ovality</th>
                    <th>TolOdPlus</th>
                    <th>TolOdMinus</th>
                    <th>TolIdPlus</th>
                    <th>TolIdMinus</th>
                    <th>TolWtPlus</th>
                    <th>TolWtMinus</th>
                    <th>NominalOd</th>
                    <th>NominalId</th>
                    <th>NominalWt</th>
                    <th>SeamAngle</th>
                    <th>SeamFound</th>
                    <th>OD1</th>
                    <th>OD2</th>
                    <th>OD3</th>
                    <th>OD4</th>
                    <th>OD5</th>
                    <th>OD6</th>
                    <th>OD7</th>
                    <th>OD8</th>
                    <th>OD9</th>
                    <th>OD10</th>
                    <th>OD11</th>
                    <th>OD12</th>
                    <th>OD13</th>
                    <th>OD14</th>
                    <th>OD15</th>
                    <th>OD16</th>
                    <th>ID1</th>
                    <th>ID2</th>
                    <th>ID3</th>
                    <th>ID4</th>
                    <th>ID5</th>
                    <th>ID6</th>
                    <th>ID7</th>
                    <th>ID8</th>
                    <th>ID9</th>
                    <th>ID10</th>
                    <th>ID11</th>
                    <th>ID12</th>
                    <th>ID13</th>
                    <th>ID14</th>
                    <th>ID15</th>
                    <th>ID16</th>
                    <th>WT1</th>
                    <th>WT2</th>
                    <th>WT3</th>
                    <th>WT4</th>
                    <th>WT5</th>
                    <th>WT6</th>
                    <th>WT7</th>
                    <th>WT8</th>
                    <th>WT9</th>
                    <th>WT10</th>
                    <th>WT11</th>
                    <th>WT12</th>
                    <th>WT13</th>
                    <th>WT14</th>
                    <th>WT15</th>
                    <th>WT16</th>
                </tr>
                </thead>
                <tbody>
                @foreach($endLaserData as $key => $value)

                    <tr>
                        <td>{{$value["PipeId"]}}</td>
                        <td>{{$value["DateTime"]}}</td>
                        <td>{{$value["LeadingEnd"]}}</td>
                        <td>{{round($value["ODAvg"],4)}}</td>
                        <td>{{round($value["ODMax"],4)}}</td>
                        <td>{{round($value["ODMin"],4)}}</td>
                        <td>{{$value["ODOutOfTol"]}}</td>
                        <td>{{round($value["IDAvg"],4)}}</td>
                        <td>{{round($value["IDMax"],4)}}</td>
                        <td>{{round($value["IDMin"],4)}}</td>
                        <td>{{$value["IDOutOfTol"]}}</td>
                        <td>{{round($value["WTAvg"],4)}}</td>
                        <td>{{round($value["WTMax"],4)}}</td>
                        <td>{{round($value["WTMin"],4)}}</td>
                        <td>{{$value["WTOutOfTol"]}}</td>
                        <td>{{round($value["Ovality"],4)}}</td>
                        <td>{{round($value["TolOdPlus"],4)}}</td>
                        <td>{{round($value["TolOdMinus"],4)}}</td>
                        <td>{{round($value["TolIdPlus"],4)}}</td>
                        <td>{{round($value["TolIdMinus"],4)}}</td>
                        <td>{{round($value["TolWtPlus"],4)}}</td>
                        <td>{{round($value["TolWtMinus"],4)}}</td>
                        <td>{{round($value["NominalOd"],4)}}</td>
                        <td>{{round($value["NominalId"],4)}}</td>
                        <td>{{round($value["NominalWt"],4)}}</td>
                        <td>{{round($value["SeamAngle"],4)}}</td>
                        <td>{{$value["SeamFound"]}}</td>
                        <td>{{round($value["OD1"], 4)}}</td>
                        <td>{{round($value["OD2"], 4)}}</td>
                        <td>{{round($value["OD3"], 4)}}</td>
                        <td>{{round($value["OD4"], 4)}}</td>
                        <td>{{round($value["OD5"], 4)}}</td>
                        <td>{{round($value["OD6"], 4)}}</td>
                        <td>{{round($value["OD7"], 4)}}</td>
                        <td>{{round($value["OD8"], 4)}}</td>
                        <td>{{round($value["OD9"], 4)}}</td>
                        <td>{{round($value["OD10"], 4)}}</td>
                        <td>{{round($value["OD11"], 4)}}</td>
                        <td>{{round($value["OD12"], 4)}}</td>
                        <td>{{round($value["OD13"], 4)}}</td>
                        <td>{{round($value["OD14"], 4)}}</td>
                        <td>{{round($value["OD15"], 4)}}</td>
                        <td>{{round($value["OD16"], 4)}}</td>
                        <td>{{round($value["ID1"], 4)}}</td>
                        <td>{{round($value["ID2"], 4)}}</td>
                        <td>{{round($value["ID3"], 4)}}</td>
                        <td>{{round($value["ID4"], 4)}}</td>
                        <td>{{round($value["ID5"], 4)}}</td>
                        <td>{{round($value["ID6"], 4)}}</td>
                        <td>{{round($value["ID7"], 4)}}</td>
                        <td>{{round($value["ID8"], 4)}}</td>
                        <td>{{round($value["ID9"], 4)}}</td>
                        <td>{{round($value["ID10"], 4)}}</td>
                        <td>{{round($value["ID11"], 4)}}</td>
                        <td>{{round($value["ID12"], 4)}}</td>
                        <td>{{round($value["ID13"], 4)}}</td>
                        <td>{{round($value["ID14"], 4)}}</td>
                        <td>{{round($value["ID15"], 4)}}</td>
                        <td>{{round($value["ID16"], 4)}}</td>
                        <td>{{round($value["WT1"], 4)}}</td>
                        <td>{{round($value["WT2"], 4)}}</td>
                        <td>{{round($value["WT3"], 4)}}</td>
                        <td>{{round($value["WT4"], 4)}}</td>
                        <td>{{round($value["WT5"], 4)}}</td>
                        <td>{{round($value["WT6"], 4)}}</td>
                        <td>{{round($value["WT7"], 4)}}</td>
                        <td>{{round($value["WT8"], 4)}}</td>
                        <td>{{round($value["WT9"], 4)}}</td>
                        <td>{{round($value["WT10"], 4)}}</td>
                        <td>{{round($value["WT11"], 4)}}</td>
                        <td>{{round($value["WT12"], 4)}}</td>
                        <td>{{round($value["WT13"], 4)}}</td>
                        <td>{{round($value["WT14"], 4)}}</td>
                        <td>{{round($value["WT15"], 4)}}</td>
                        <td>{{round($value["WT16"], 4)}}</td>
                    </tr>

                @endforeach

            </table>
        </div>
    </div>


@endsection
@section('functionalScripts')
    <script src="{{ asset('public/libraries/date-range-picker/moment.min.js')}}"></script>
    <script src="{{ asset('public/libraries/date-range-picker/daterangepicker.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/js/ajaxDateFromToPost.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <script>
        var table;
        $(document).ready(function() {
           table = $('#end-laser-table').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'excel'],
                "order": [[ 1, "desc" ]]
            });
        });

        function BuildNewRows(data) {
            var crsfToken = "{{@csrf_token()}}";
            var tablesRows = "";
            for (var i = 0; i < data.length; i++) {
                console.log(data[i]);
                tablesRows+= "<tr>";
                tablesRows+= "<td>"+data[i].PipeId+"</td>"+
                "<td>"+data[i].DateTime+"</td>"+
                "<td>"+data[i].LeadingEnd+"</td>"+
                "<td>"+parseFloat(data[i].ODAvg).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ODMax).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ODMin).toFixed(4)+"</td>"+
                "<td>"+data[i].ODOutOfTol+"</td>"+
                "<td>"+parseFloat(data[i].IDAvg).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].IDMax).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].IDMin).toFixed(4)+"</td>"+
                "<td>"+data[i].IDOutOfTol+"</td>"+
                "<td>"+parseFloat(data[i].WTAvg).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WTMax).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WTMin).toFixed(4)+"</td>"+
                "<td>"+data[i].WTOutOfTol+"</td>"+
                "<td>"+parseFloat(data[i].Ovality).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].TolOdPlus).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].TolOdMinus).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].TolIdPlus).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].TolIdMinus).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].TolWtPlus).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].TolWtMinus).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].NominalOd).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].NominalId).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].NominalWt).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].SeamAngle).toFixed(4)+"</td>"+
                "<td>"+data[i].SeamFound+"</td>"+
                "<td>"+parseFloat(data[i].OD1).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD2).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD3).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD4).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD5).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD6).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD7).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD8).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD9).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD10).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD11).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD12).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD13).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD14).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD15).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].OD16).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID1).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID2).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID3).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID4).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID5).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID6).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID7).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID8).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID9).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID10).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID11).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID12).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID13).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID14).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID15).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].ID16).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT1).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT2).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT3).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT4).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT5).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT6).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT7).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT8).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT9).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT10).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT11).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT12).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT13).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT14).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT15).toFixed(4)+"</td>"+
                "<td>"+parseFloat(data[i].WT16).toFixed(4)+"</td>"+
                "</tr>";
            }

            return tablesRows;
        }

    </script>
@endsection
