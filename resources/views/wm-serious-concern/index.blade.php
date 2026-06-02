@extends('layouts.app')

@section('pageTitle', 'WM Serious Concern')
@section('pageName', 'WM Serious Concern')
@section('weldMillActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <style>
        .pipeSelector {
            display: flex;
            flex-wrap: wrap;
            width: 275px;
            text-align: center;
        }

        .pipeSelector > div {
            flex: 1 0 50px;
            border: 1px solid #ccc;
            cursor: pointer;

        }

        .highlighted {
            background: #f6c23e
        }
        .text-wrap{
            white-space:normal;
        }
        .width-200{
            width:200px;
        }

        select {
            width: 80px;
        }
    </style>

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
    <form method="post" id="wm-serious-concern" action="{{ route('wm-serious-concern.store') }}"
          enctype="multipart/form-data">
        @csrf
        <div class="simpleflex" style="justify-content: space-around">

        </div>

        <div class="simpleflex" style="margin-top: 10px">
            <div class="form-group">
                <label>Week</label>
                <input type="number" class="form-control" name="week" id="week" value="{{date('W')}}" required>
            </div>
            <div class="form-group">
                <label>Coil</label>
                <input type="text" class="form-control" name="coilNo" id="coilNo" required>
            </div>
            <div class="form-group">
                <label>OD</label>
                <input type="number" step="any" class="form-control" id="od" name="od" required>
            </div>
            <div class="form-group">
                <label>Thickness</label>
                <input type="number" step="any" class="form-control" id="thickness" name="thickness" required>
            </div>
            <div class="form-group">
                <label>Grade</label>
                <input type="text" class="form-control" name="grade" id="grade" required>
            </div>

            <div class="form-group">
                <label>Reason</label>
                <select class="form-control" name="reason">
                    <option value="ID">ID</option>
                    <option value="OD">OD</option>
                    <option value="SURFACE CONDITION">SURFACE CONDITION</option>
                    <option value="DIMENSION">DIMENSION</option>
                    <option value="STRAIGHTNESS">STRAIGHTNESS</option>
                    <option value="TWST">TWST</option>
                    <option value="CONCAVITY/CONVEXITY">CONCAVITY/CONVEXITY</option>
                    <option value="END CONDITION">END CONDITION</option>
                    <option value="TRACKING LINE">TRACKING LINE</option>
                    <option value="ANNEALING">ANNEALING</option>
                    <option value="SEAM TWIST">SEAM TWIST</option>
                    <option value="FLASH RINGS">FLASH RINGS</option>
                    <option value="PRODUCT MARKING">PRODUCT MARKING</option>
                </select>
            </div>

            <div class="form-group">
                <label>Process Route</label>
                <select class="form-control" name="processRoute" required>
                    <option value="">Please Select</option>
                    <option value="COLD CHS">COLD CHS</option>
                    <option value="COLD RHS">COLD RHS</option>
                    <option value="HOT RHS">HOT RHS</option>
                    <option value="HOT CHS">HOT CHS</option>
                    <option value="PRESSURE PIPE">PRESSURE PIPE</option>
                </select>
            </div>


            <div class="form-group">
                <label>Person Consulted</label>
                <input type="text" class="form-control" name="personConsulted" required>
            </div>

            <div class="form-group">
                <label>Comments</label>
                <input type="text" class="form-control" name="comments" required>
            </div>

            <div>
                <h4>Pipes</h4>
                <div class="pipeSelector" id="pipeSelector">

                </div>
            </div>


            <input type="hidden" value="" name="pipes" id="pipes">

            <input type="file" id="img" name="file" accept="image/*">


            {{--            <input type="hidden" id="user" name="user" value="{{$user}}">--}}


            <div class="form-group" style="margin-top: 31px;">
                <input class="form-control btn btn-primary" id="dim-veri-submit" type="submit" value="Submit">
            </div>
        </div>
    </form>

    <hr/>

    <table id="serious-concern-table" class="table table-striped table-bordered">
        <thead>
        <tr class="sub-header">
            <th>Week</th>
            <th>Coil</th>
            <th>OD</th>
            <th>Thick</th>
            <th>Grade</th>
            <th>Reason</th>
            <th>Process Route</th>
            <th>Comments</th>
            <th>Pipes</th>
            <th>Complete</th>
            <th>Created At</th>
            <th>Img</th>
            <th>Raised By</th>
            <th>Reported To</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>

        @foreach($seriousConcerns as $row)
            <tr>
                <td>{{$row['WEEK']}}</td>
                <td>{{$row['COIL']}}</td>
                <td>{{$row['OD']}}</td>
                <td>{{$row['THICKNESS']}}</td>
                <td>{{$row['GRADE']}}</td>
                <td>{{$row['REASON']}}</td>
                <td>{{$row['PROCESS_ROUTE']}}</td>

                <td>{{$row['COMMENTS']}}</td>

                <td>
                    @php
                        $array =  explode(';', rtrim($row['PIPES'], ";"));

                        foreach ($array as $item) {
                         echo "<li>$item</li>";
                        }
                    @endphp
                </td>
                <td>{{$row['COMPLETE_STATUS']}}</td>
                <td>{{$row['created_at']}}</td>
                <td>
                    @if ($row["FILE_PATH"] !== "")
                        <a class="macroImageLink" target="_blank"
                           href="{{asset('public/storage/wm-serious-concern/'.$row["FILE_PATH"])}}"><img
                                style="width:100px; height: 50px;"
                                src="{{asset('public/storage/wm-serious-concern/'.$row["FILE_PATH"])}}"/></a>
                    @endif
                </td>

                <td>{{$row['USER']["name"]}}</td>
                <td>{{$row['REPORTED_TO_USER']}}</td>
                <td><a href="{{ route('wm-serious-concern.show',$row["id"])}}" class="btn btn-primary">View</a></td>

                <td>
                    <a href="{{ route('wm-serious-concern.edit',$row["id"])}}" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    @if($userId == 17 || $userId == 47 || $userId == 16  || $userId == 4 || $userId == 15 || $userId == 17 || $userId == 25 || $userId == 139)
                        <form method="post" class="delete-form"
                              action="{{ route('wm-serious-concern.destroy', $row["id"])}}">
                            @csrf
                            @method('DELETE')
                            <input id="delete-button" class="btn btn-danger" type="submit" value="Delete">
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <th>Week</th>
        <th>Coil</th>
        <th>OD</th>
        <th>Thick</th>
        <th>Grade</th>
        <th>Reason</th>
        <th>Process Route</th>
        <th>Comments</th>
        <th>Pipes</th>
        <th>Complete</th>
        <th>Created At</th>
        <th>Img</th>
        <th>Raised By</th>
        <th>Reported To</th>
        <th>View</th>
        <th>Edit</th>
        <th>Delete</th>
        </tfoot>
    </table>


@endsection
@section('functionalScripts')
    <script src="{{asset('public/js/FormValueObjectMap.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>

    <script src="{{ asset('public/libraries/sweetalert/swal.js')}}"></script>

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
         * Add .00 to any numeric input
         * */
        $(':input[type="number"]').change(function () {
            this.value = parseFloat(this.value).toFixed(2);
        });


        /**
         * Handle delete form submission,
         * Ask for confirmation before proceeding with the deletion
         * */
        $('.delete-form').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    this.submit();
                }
            })
        });

        /**
         * Handle dimensional verification form submission.
         * Calculate offset, peaking and oor from existing values. Submit via ajax to db.
         * After submission complete, clear the form.
         * */
        $('#wm-serious-concern').on('submit', function (e) {
            e.preventDefault();
            var inputs = $(this).serializeObject();
            var pipesSelected = [];
            var pipesSelectedString = "";
            $('.highlighted').each(function (index) {
                pipesSelected.push($(this).text()) + ";";

                pipesSelectedString += $(this).text().trim() + ";";
            });
            inputs.pipesSelected = pipesSelected;
            $('#pipes').val(pipesSelectedString);
            this.submit();
        });

        /**
         * Get coil info from api once coil no input.
         * After coil no field is left, send api call.
         * If data found, fill fields, if not, alert the user.
         * */
        $('#coilNo').on('focusout', function () {
            console.log("fired");
            $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
            $.ajax({
                type: 'POST',
                url: rootUrl + '/api/GetCoilDetailAndPipeNumbers',
                data: {"week": $('#week').val(), "coilNo": $('#coilNo').val()},
                success: function (response) {

                    var parsedResponse = $.parseJSON(response);
                    console.log(parsedResponse);
                    if (parsedResponse.length > 0) {
                        $('#thickness').val(parsedResponse[0].BLOCK_THICK);
                        $('#od').val(parsedResponse[0].BLOCK_OD);
                        $('#grade').val(parsedResponse[0].COIL_COIL_QUALITY);
                        VetMeasurementsAgainstOD(parsedResponse[0].BLOCK_OD);
                        $('#pipeSelector').empty();
                        for (let i = 0; i < parsedResponse.length; i++) {
                            console.log(parsedResponse[i].TRACK_CODE);

                            $('#pipeSelector').append('<div class="pipesFromCoil">' + parsedResponse[i].TRACK_CODE + '</div>');

                        }
                        $('#pipeSelector').append('<div class="selectAllPipesFromCoil">Select All</div>');

                    } else {
                        alert("Coil Not Found");
                        $('#thickness').val("");
                        $('#od').val("");
                        $('#grade').val("");
                    }

                },
                complete: function () {
                    $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
            });

        });


        $("body").on("click", ".pipesFromCoil", function () {
            console.log($(this).hasClass('highlighted'));

            if ($(this).hasClass('highlighted')) {
                $(this).removeClass('highlighted');
            } else {
                $(this).addClass('highlighted');
            }


        });

        $("body").on("click", ".selectAllPipesFromCoil", function () {
            console.log($(this).hasClass('highlighted'));



            if ($('.pipesFromCoil').hasClass('highlighted')) {
                $('.pipesFromCoil').removeClass('highlighted');
            } else {
                $('.pipesFromCoil').addClass('highlighted');
            }
        });


        /**
         * function to vet if post fins / post weld values are within tolerance (Within 10%)
         * */
        function VetMeasurementsAgainstOD(od) {
            $('.odMeasurement').each(function (i, obj) {
                console.log(obj);
                if ($(obj).val() > (od * 1.1)) {
                    $(obj).css('background', 'orange');
                    Swal.fire('High Measurement(s) detected - Please check orange values');
                }
            });
        }


        /**
         * Datatable intialization and config.
         */

        var table = $('#serious-concern-table').DataTable({
            dom: 'Bfrtip',

            columnDefs: [
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-200'>" + data + "</div>";
                    },
                    targets: 7
                }
            ],
            buttons: ['print', 'excel'],
            "order": [10, "desc"],
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

@endsection
