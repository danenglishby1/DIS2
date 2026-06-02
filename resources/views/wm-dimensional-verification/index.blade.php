@extends('layouts.app')

@section('pageTitle', 'Dimensional Verification')
@section('pageName', 'Dimensional Verification')
@section('weldMillActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <style>
        .pipe-diagram-open {
            position: relative;
        }

        .pipe-diagram-closed {
            position: relative;
        }

        input#post-fins-b {
            width: 70px;

        }

        input#post-fins-c {
            position: absolute;
            width: 70px;
            right: 30px;
        }

        input#post-fins-d {
            position: absolute;
            width: 70px;
            left: 100px;
        }

        input#post-weld-a {
            position: absolute;
            width: 70px;
            left: 50%;
            top: 2px;
        }

        input#post-weld-b {
            width: 70px;
        }

        input#post-weld-c {
            position: absolute;
            width: 70px;
            right: 30px;
        }

        input#post-weld-d {
            position: absolute;
            width: 70px;
            left: 100px;
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
    <form id="dim-verification">
        <div class="simpleflex" style="justify-content: space-around">
            <div class="pipe-diagram-open">
                <div><h4>Post Fins</h4></div>
                <input id="post-fins-b" type="number" step="any" name="postFinsB" class="odMeasurement" placeholder="B" required>
                <input id="post-fins-c" type="number" step="any" name="postFinsC" class="odMeasurement" placeholder="C" required>
                <input id="post-fins-d" type="number" step="any" name="postFinsD" class="odMeasurement" placeholder="D" required>
                <img src="{{asset('public/images/pipe-diagram-open.png')}}"/>
            </div>
            <div class="pipe-diagram-closed" style="margin-top: -8px;">
                <div><h4>Post Weld</h4></div>
                <input id="post-weld-a" type="number" step="any" name="postWeldA" class="odMeasurement" placeholder="A" required>
                <input id="post-weld-b" type="number" step="any" name="postWeldB" class="odMeasurement" placeholder="B" required>
                <input id="post-weld-c" type="number" step="any" name="postWeldC" class="odMeasurement" placeholder="C" required>
                <input id="post-weld-d" type="number" step="any" name="postWeldD" class="odMeasurement" placeholder="D" required>
                <img src="{{asset('public/images/pipe-diagram-closed.png')}}"/>
            </div>
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
                <label>Round/Square</label>
                <select name="roundSquare" class="form-control">
                    <option value="Round">Round</option>
                    <option value="Square">Square</option>
                </select>
            </div>
            <div class="form-group">
                <label>Sizes</label>
                <input type="text" class="form-control" name="sizes">
            </div>
            <div class="form-group">
                <label>Comments</label>
                <input type="text" class="form-control" name="comments">
            </div>

            <input type="hidden" id="peaking" name="peaking">
            <input type="hidden" id="oor" name="oor">
            <input type="hidden" id="offset" name="offset">
            <input type="hidden" id="user" name="user" value="{{$user}}">


            <div class="form-group" style="margin-top: 31px;">
                <input class="form-control btn btn-primary" id="dim-veri-submit" type="submit" value="Submit">
            </div>
        </div>
    </form>

    <hr/>

    <table id="dim-table" class="table table-striped table-bordered">
        <thead>
        <tr class="sub-header">
            <th>Week</th>
            <th>Coil</th>
            <th>OD</th>
            <th>Thick</th>
            <th>B</th>
            <th>C</th>
            <th>D</th>
            <th>Offset</th>
            <th>A</th>
            <th>B</th>
            <th>C</th>
            <th>D</th>
            <th>OOR</th>
{{--            <th>Peaking</th>--}}
            <th>Grade</th>
            <th>Round/Square</th>
            <th>Sizes</th>
            <th>Comments</th>
            <th>Date</th>
            <th>User</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <tr>
            <th colspan="4">Coil Details</th>
            <th colspan="4">Post Fins</th>
            <th colspan="6">Post Weld</th>
            <th colspan="6">Additional Info</th>
            <th colspan="2">Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach($dimensionalData as $row)
            <tr>
                <td>{{$row['WEEK']}}</td>
                <td>{{$row['COIL']}}</td>
                <td>{{$row['OD']}}</td>
                <td>{{$row['THICKNESS']}}</td>
                <td>{{$row['POST_FINS_B']}}</td>
                <td>{{$row['POST_FINS_C']}}</td>
                <td>{{$row['POST_FINS_D']}}</td>
                <td {{($row['POST_FINS_OFFSET'] > 1.0 || $row['POST_FINS_OFFSET'] < -1.0 ? "style=background:red;color:white;" : "ddd")}}>{{round($row['POST_FINS_OFFSET'],2)}}</td>
                <td>{{$row['POST_WELD_A']}}</td>
                <td>{{$row['POST_WELD_B']}}</td>
                <td>{{$row['POST_WELD_C']}}</td>
                <td>{{$row['POST_WELD_D']}}</td>
                <td>{{$row['POST_WELD_OOR']}}</td>
{{--                <td>{{$row['POST_WELD_PEAK']}}</td>--}}
                <td>{{$row['GRADE']}}</td>
                <td>{{$row['ROUND_SQUARE']}}</td>
                <td>{{$row['SIZES']}}</td>
                <td>{{$row['COMMENTS']}}</td>
                <td>{{$row['created_at']}}</td>
                <td>{{$row['USER']}}</td>
                <td>
                    <a href="{{ route('wm-dimensional-verification.edit',$row["id"])}}" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <form method="post" class="delete-form"
                          action="{{ route('wm-dimensional-verification.destroy', $row["id"])}}">
                        @csrf
                        @method('DELETE')
                        <input id="delete-button" class="btn btn-danger" type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <th>Week</th>
        <th>Coil</th>
        <th>OD</th>
        <th>Thick</th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
        <th>Offset</th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
        <th>D</th>
        <th>OOR</th>
{{--        <th>Peaking</th>--}}
        <th>Grade</th>
        <th>Round/Square</th>
        <th>Sizes</th>
        <th>Comments</th>
        <th>Date</th>
        <th>User</th>
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
        $(':input[type="number"]').change(function(){
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
        $('#dim-verification').on('submit', function (e) {
            e.preventDefault();
            var inputs = $(this).serializeObject();

            console.log(inputs);

            $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
            $.ajax({
                type: 'GET',
                url: rootUrl + '/wm-dimensional-verification/create',
                data: inputs,
                success: function (response) {
                    var parsedResponse = $.parseJSON(response);

                    if (parsedResponse.success) {
                        alert('Log Added');
                        $('#dim-verification').trigger("reset");
                        window.location.href = rootUrl + '/wm-dimensional-verification'
                    } else {
                        alert('Log not added, please try again or contact Danny Englishby');
                    }
                },
                complete: function () {
                    $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                }
            });
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
                url: rootUrl + '/api/GetCoilDetail',
                data: {"week": $('#week').val(), "coilNo": $('#coilNo').val()},
                success: function (response) {

                    var parsedResponse = $.parseJSON(response);
                    console.log(parsedResponse);
                    if (parsedResponse.length > 0) {
                        $('#thickness').val(parsedResponse[0].BLOCK_THICK);
                        $('#od').val(parsedResponse[0].BLOCK_OD);
                        $('#grade').val(parsedResponse[0].COIL_COIL_QUALITY);

                        VetMeasurementsAgainstOD(parsedResponse[0].BLOCK_OD);
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


        /**
         * function to vet if post fins / post weld values are within tolerance (Within 10%)
         * */
        function VetMeasurementsAgainstOD(od) {
            $('.odMeasurement').each(function(i, obj) {
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

        var table = $('#dim-table').DataTable({
            dom: 'Bfrtip',
            buttons: ['print', 'excel'],
            "order": [17, "desc"],
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
