@extends('layouts.app')

@section('pageTitle', 'ChangeLog')
@section('pageName', 'RHS ChangeLog')
@section('rhsActiveLink', 'active activeUnderline')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <style>
        label {
            font-size: 20px;
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

    <hr/>

    <div class="flex-justify-right">

        <div class="fl1">
            <form id="rhs-change-log-form">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="initials">Initials</label>
                        <input type="text" class="form-control  form-control-lg" id="initials" name="initials"
                               aria-describedby="initials" required>
                    </div>
                </div>
                <hr/>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="size">Size</label>
                        <select class="form-control  form-control-lg" id="size" name="size" aria-describedby="size" required>
                            <option value="0">None</option>
                            <option value="150x150">150x150</option>
                            <option value="160x160">160x160</option>
                            <option value="180x180">180x180</option>
                            <option value="200x120">200x120</option>
                            <option value="200x150">200x150</option>
                            <option value="200x200">200x200</option>
                            <option value="220x120">220x120</option>
                            <option value="220x220">220x220</option>
                            <option value="250x100">250x100</option>
                            <option value="250x150">250x150</option>
                            <option value="250x250">250x250</option>
                            <option value="260x140">260x140</option>
                            <option value="260x180">260x180</option>
                            <option value="260x260">260x260</option>
                            <option value="300x100">300x100</option>
                            <option value="300x150">300x150</option>
                            <option value="300x200">300x200</option>
                            <option value="300x300">300x300</option>
                            <option value="350x150">350x150</option>
                            <option value="350x250">350x250</option>
                            <option value="350x350">350x350</option>
                            <option value="398x199">398x199</option>
                            <option value="400x120">400x120</option>
                            <option value="400x150">400x150</option>
                            <option value="400x200">400x200</option>
                            <option value="400x300">400x300</option>
                            <option value="400x400">400x400</option>
                            <option value="450x150">450x150</option>
                            <option value="450x250">450x250</option>
                            <option value="452x251">452x251</option>
                            <option value="500x200">500x200</option>
                            <option value="500x300">500x300</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="thick">Thickness</label>
                        <select class="form-control  form-control-lg" id="thick" name="thick" aria-describedby="thick"
                                >
                            <option value="0">None</option>
                            <option value="5">5</option>
                            <option value="6.3">6.3</option>
                            <option value="7.1">7.1</option>
                            <option value="8">8</option>
                            <option value="8.8">8.8</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12.5">12.5</option>
                            <option value="14.2">14.2</option>
                            <option value="16">16</option>
                            <option value="20">20</option>

                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="concern">Concern</label>
                        <select class="form-control  form-control-lg" id="concern" name="concern"
                                aria-describedby="concern" >
                            <option value="">None</option>
                            <option value="Varying Radius">Varying Radius</option>
                            <option value="Radius out of specification (OOS)">Radius out of specification (OOS)</option>
                            <option value="Dimension Small">Dimension Small</option>
                            <option value="Dimension Large">Dimension Large</option>
                            <option value="Twist">Twist</option>
                            <option value="Concavity">Concavity</option>
                            <option value="Convexity">Convexity</option>
                            <option value="Upturn">Upturn</option>
                            <option value="Downturn">Downturn</option>
                            <option value="Roll Mark">Roll Mark</option>
                            <option value="Lip">Lip</option>
                            <option value="Fin">Fin</option>
                            <option value="D Shape">D Shape</option>
                            <option value="Hook End">Hook End</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="sectionArea">Section Area</label>
                        <select class="form-control form-control-lg" id="sectionArea" name="sectionArea"
                                aria-describedby="sectionArea" >
                            <option value="">None</option>
                            <option value="North">North</option>
                            <option value="South">South</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="topBottom">Top / Bottom</label>
                        <select class="form-control form-control-lg" id="topBottom" name="topBottom"
                                aria-describedby="topBottom" >
                            <option value="">None</option>
                            <option value="Top">Top</option>
                            <option value="Bottom">Bottom</option>
                            <option value="Both">Both</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="standAdjusted">Stand Adjusted</label>
                        <select class="form-control form-control-lg" id="standAdjusted" name="standAdjusted"
                                aria-describedby="standAdjusted" >
                            <option value="0">None</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="millArea">Mill Area</label>
                        <select class="form-control form-control-lg" id="millArea" name="millArea"
                                aria-describedby="millArea" >
                            <option value="">None</option>
                            <option value="Side Box">Side Box</option>
                            <option value="Top Rolls">Roll Heights</option>
                            <option value="Top Rolls">Statics</option>
                        </select>
                    </div>

                </div>

                <div class="form-row">


                    <div class="form-group col-md-2">
                        <label for="inOut">In / Out</label>
                        <select class="form-control form-control-lg" id="inOut" name="inOut" aria-describedby="inOut">
                            <option value="">None</option>
                            <option value="In">In</option>
                            <option value="Out">Out</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="millimeters">MM</label>
                        <select class="form-control form-control-lg" id="millimeters" name="millimeters"
                                aria-describedby="millimeters" >
                            <option value="0">None</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="sectionOk">Section OK?</label>
                        <select class="form-control form-control-lg" id="sectionOk" name="sectionOk"
                                aria-describedby="sectionOk" >
                            <option value="">None</option>
                            <option value="Y">Y</option>
                            <option value="N">N</option>
                        </select>
                    </div>

                </div>
                <hr/>
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea class="form-control form-control-lg" id="comments" name="comments"
                              aria-describedby="comments"></textarea>
                </div>
                <input type="hidden" value="{{$loggedInUser}}" name="loggedInUserName">
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection

@section('functionalScripts')
    <script src="{{ asset('public/js/jquery-3.3.1.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/dataTables.bootstrap4.js')}}"></script>
    <!-- Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/print.js')}}"></script>
    <script src="{{ asset('public/libraries/datatables/extensions/jszip.min.js')}}"></script>
    <script src="{{ asset('public/js/FormValueObjectMap.js')}}"></script>
    <script src="{{ asset('public/libraries/sweetalert/swal.js')}}"></script>


    <script>

        /**
         * Datatable intialization and config.
         */

        // var table = $('#outstandingDefectTable').DataTable({
        //     dom: 'Bfrtip',
        //     buttons: ['print', 'excel'],
        //     initComplete: function () {
        //         this.api().columns().every(function () {
        //             var column = this;
        //             var select = $('<select><option value=""></option></select>')
        //                 .appendTo($(column.footer()).empty())
        //                 .on('change', function () {
        //                     var val = $.fn.dataTable.util.escapeRegex(
        //                         $(this).val()
        //                     );
        //
        //                     column
        //                         .search(val ? '^' + val + '$' : '', true, false)
        //                         .draw();
        //                 });
        //
        //             column.data().unique().sort().each(function (d, j) {
        //                 select.append('<option value="' + d + '">' + d + '</option>')
        //             });
        //         });
        //     }
        // });
        //
        //
        // table.on('draw', function () {
        //     table.columns().indexes().each(function (idx) {
        //         var select = $(table.column(idx).footer()).find('select');
        //
        //         if (select.val() === '') {
        //             select
        //                 .empty()
        //                 .append('<option value=""/>');
        //
        //             table.column(idx, {search: 'applied'}).data().unique().sort().each(function (d, j) {
        //                 select.append('<option value="' + d + '">' + d + '</option>');
        //             });
        //         }
        //     });
        // });


        // Listen to changes on routing drop down.
        //
        //     $(table.column(2).footer()).find('select').on('change', function (e) {
        //
        //         var routingPositionSelected = this.value;
        //
        //         // If routing pos selected isn't blank, then show buttons.
        //         console.log(routingPositionSelected);
        //         if (routingPositionSelected == "") {
        //             $('.all-pipe-list-buttons').css('display', 'none');
        //         } else {
        //             $('.all-pipe-list-buttons').css('display', 'flex');
        //         }
        //
        //         //Update buttons and links
        //
        //         $('#allPipeByPositionListLink').attr('href', rootUrl + '/mngr-tracking/pipe-list?routingPos=' + routingPositionSelected);
        //         $('#allPipeByPositionListLink').find('button').html(routingPositionSelected + " - (ALL)");
        //
        //         $('#exStockPipeByPositionListLink').attr('href', rootUrl + '/mngr-tracking/pipe-list?routingPos=' + routingPositionSelected + '&exStock=true');
        //         $('#exStockPipeByPositionListLink').find('button').html(routingPositionSelected + " - (Ex-Stock Only)");
        //
        //
        //     });
        // });
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#rhs-change-log-form').submit(function (e) {
                e.preventDefault();

                var formData = $('#rhs-change-log-form').serializeObject();
                console.log(formData);


                $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
                $.ajax({
                    type: 'POST',
                    url: rootUrl + '/api/AddRHSChangeLotEntry',
                    data: {'formData': formData},
                    success: function (response) {
                        var parsedResponse = $.parseJSON(response);

                        if (parsedResponse.success) {
                            alert('Log Added');
                            $('#rhs-change-log-form').trigger("reset");
                        } else {
                            alert('Log not added, please try again or contact Danny Englishby');
                        }
                    },
                    complete: function () {
                        $('.ajax-loader').css("display", "none"); // remove spinner loader once done.
                    }
                });
            });

        });


    </script>

@endsection
