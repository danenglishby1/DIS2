@extends('layouts.app')

@section('pageTitle', 'Slitter Home')
@section('pageName', 'Slit Coil Lookup')
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
    <div class="col-sm-12">
        <a href="{{ route('wm-macros.create')}}" class="btn btn-primary mb-2">Create New</a>






        <table id="macro-table" class="table table-striped">
            <thead>
            <th>Parent Coil No</th>
            <th>Cast</th>
            <th>Coil Order</th>
            <th>Width</th>
            <th>Thick</th>
            <th>Qual</th>
            <th>Receipt Date</th>
            <th>Adv Weight</th>
            <th>Actual Weight</th>
            <th>Slit Datetime</th>
            <th>Slit Date</th>
            <th>Child Coil 1 No</th>
            <th>Child Coil 1 Width</th>
            <th>Child Coil 1 Weight</th>
            <th>Child Coil 1 Location</th>
            <th>Child Coil 2 No</th>
            <th>Child Coil 2 Width</th>
            <th>Child Coil 2 Weight</th>
            <th>Child Coil 2 Location</th>
            <th>Child Coil 3 No</th>
            <th>Child Coil 3 Width</th>
            <th>Child Coil 3 Weight</th>
            <th>Child Coil 3 Location</th>
            </thead>
            <tbody>
            @foreach($coilHistory as $r)
                <tr>
                    <td>{{$r["COIL_COIL_NO"]}}</td>
                    <td>{{$r["COIL_CAST_NO"]}}</td>
                    <td>{{$r["COIL_COIL_ORDER"]}}</td>
                    <td>{{$r["COIL_COIL_WIDTH"]}}</td>
                    <td>{{$r["COIL_COIL_THICK"]}}</td>
                    <td>{{$r["COIL_COIL_QUALITY"]}}</td>
                    <td>{{substr($r["COIL_RPT_DATE"], 4,2) . "-" . substr($r["COIL_RPT_DATE"], 2,2) . "-" . substr($r["COIL_RPT_DATE"], 0,2)}}</td>
                    <td>{{$r["COIL_ADV_WEIGHT"]}}</td>
                    <td>{{$r["COIL_ACT_WEIGHT"]}}</td>
                    <td> {{substr($r["COIL_SLITDATE_DATETIME"], 0,10)}}</td>
                    <td>{{substr($r["COIL_SLITDATE_DATETIME"], 0, 19)}}</td>
                    <td>{{$r["CHILD_COIL1"]}}</td>
                    <td>{{$r["CHILD_COIL_COIL_1_WIDTH"]}}</td>
                    <td>{{$r["CHILD_COIL_1_WEIGHT"]}}</td>
                    <td>{{$r["CHILD_COIL_1_LOCATION"]}}</td>
                    <td>{{$r["CHILD_COIL2"]}}</td>
                    <td>{{$r["CHILD_COIL_COIL_2_WIDTH"]}}</td>
                    <td>{{$r["CHILD_COIL_2_WEIGHT"]}}</td>
                    <td>{{$r["CHILD_COIL_2_LOCATION"]}}</td>
                    <td>{{$r["CHILD_COIL3"]}}</td>
                    <td>{{$r["CHILD_COIL_COIL_3_WIDTH"]}}</td>
                    <td>{{$r["CHILD_COIL_3_WEIGHT"]}}</td>
                    <td>{{$r["CHILD_COIL_3_LOCATION"]}}</td>

                    </tr>
            @endforeach
            </tbody>
            <tfoot>
            <th>Parent Coil No</th>
            <th>Cast</th>
            <th>Coil Order</th>
            <th>Width</th>
            <th>Thick</th>
            <th>Qual</th>
            <th>Receipt Date</th>
            <th>Adv Weight</th>
            <th>Actual Weight</th>
            <th>Slit Datetime</th>
            <th>Slit Date</th>
            <th>Child Coil 1 No</th>
            <th>Child Coil 1 Width</th>
            <th>Child Coil 1 Weight</th>
            <th>Child Coil 1 Location</th>
            <th>Child Coil 2 No</th>
            <th>Child Coil 2 Width</th>
            <th>Child Coil 2 Weight</th>
            <th>Child Coil 2 Location</th>
            <th>Child Coil 3 No</th>
            <th>Child Coil 3 Width</th>
            <th>Child Coil 3 Weight</th>
            <th>Child Coil 3 Location</th>
            </tfoot>
        </table>
        <div>
        </div>
    </div>
    @endsection
    @section('functionalScripts')
        <script>

            $('form.delete-form').one('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $(this).submit();
                    }
                })

            });
        </script>

        <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
        {{--            <!-- Extension scripts for datatables print functionality -->--}}
                    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
                    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
                    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
                    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>

        <script>
            /**
             * Add ajax header for CSRF Token
             * */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /**
             * Datatable intialization and config.
             */

            var table = $('#macro-table').DataTable({
                dom: 'Bfrtip',
                 buttons: ['print', 'excel'],
                "order": [5, "desc"],

                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }
            });

            table.on('draw', function () {
                table.columns().indexes().each(function (idx) {
                    var select = $(table.column(idx).footer()).find('select');

                    if (select.val() === '') {
                        select
                            .empty()
                            .append('<option value=""/>');

                        table.column(idx, {search: 'applied'}).data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                    }
                });
            });

        </script>

        <script>



            function BuildNewRows(data) {
                var crsfToken = "{{@csrf_token()}}";
                var tablesRows = "";
                for (const [key, value] of Object.entries(data)) {
                    // console.log(key, value);
                    tablesRows += "<tr>" +

                        "<td>" + (data[key].WEEK_YEAR !== null ? data[key].WEEK_YEAR.padStart(2, "0") : "") + (data[key].COIL !== null ? data[key].COIL.toString().padStart(3, "0") : "") + (data[key].PIPE !== null ? data[key].PIPE.toString().padStart(2, "0") : "") + "</td>" +
                        "<td>" + data[key].DIAM_RANGE + "</td>" +
                        "<td>" + data[key].THK + "</td>" +
                        "<td>" + data[key].QUALITY + "</td>" +
                        "<td>" + (data[key].COMMENT == null ? "" : data[key].COMMENT) + "</td>" +
                        "<td>" + data[key].CREATED_AT + "</td>" +
                        "<td>" + (data[key].IMAGE !== "" ? "<a target='_blank' href='" +rootUrl + "/public/storage/macros/"+ data[key].IMAGE + "'><img style='width:100px; height: 50px;' src='" +rootUrl + "/public/storage/macros/"+ data[key].IMAGE + "'/></a>" : "") + "</td>"+
                        "<td>" +
                        "  <div style='display: flex;'>" +
                        "  <a href='"+rootUrl+"/wm-macros/"+data[key].id+"' class='btn btn-primary m-1'>View</a>" +
                        "  <a href='"+rootUrl+"/wm-macros/"+data[key].id+"/edit' class='btn btn-warning m-1'>Edit</a>" +
                        "<form method='post' class='delete-form' action='"+rootUrl+"/wm-macros/"+data[key].id+"'>" +
                        "  <input type='hidden' name='_token' value='"+crsfToken+"'> " +
                        "<input type='hidden' name='_method' value='DELETE'> " +
                        "<button class='btn btn-danger m-1' type='submit'>Delete</button>" +
                        "                                </form>" +
                        "                            </div>" +
                        "</td>"+
                        "</tr>";

                }

                return tablesRows;
            }
        </script>



        <script>
            $('#exportDataLink').click(function(e) {
                console.log(window.dtFrom);
                window.location.href = rootUrl + "/api/exportMacroDataToCSV?dtFrom=" + window.dtFrom + "&dtTo=" + window.dtTo;
                $('.ajax-loader').css('display', 'none');
            });
        </script>

@endsection
