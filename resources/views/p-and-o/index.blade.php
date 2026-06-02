@extends('layouts.app')

@section('pageTitle', 'p & o')
@section('pageName', 'p & o')
@section('orderTrackingActiveLink', 'active activeUnderline')

@section('css')
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
</div>           PCI47820210614/710
</div> -->
    <div class="text-center">
        <h3>Oustanding Loads Collected To Be Delivered</h3>
    </div>

    <div class="lastUpdated text-right">
        <div style="margin:auto">Last Updated At: {{$data[0]["file_modified_datetime"]}}</div>
    </div>

    <div>
        <table id="pando-list" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>Order Number</th>
                <th>Reference1</th>
                <th>Customer Name</th>
                <th>Order Status</th>
                <th>User_Comments</th>
                <th>Collection Town</th>
                <th>Delivery Town</th>
                <th>Req Col DT</th>
                <th>Original Req Del DT</th>
                <th>Req Del DT</th>
                <th>Actual Col Date Time</th>
                <th>Actual Del Date Time</th>
                <th>Collection Place</th>
                <th>Reference2</th>
                <th>Updated At</th>
            </tr>
            </thead>
            <tbody>
            <!-- Note: $wipArray is 3 keys deep.-->
            @foreach($data as $row)
                @if($row["DateHasChanged"] == "Yes")
                    @if($row["DaysDiffFromDateChange"] > 1)
                        <tr style="background: #ffb8be">
                    @else
                        <tr style="background: #fff3b8">
                    @endif
                @else
                    <tr>
                @endif
                    <td>{{$row["Order_Number"]}}</td>
                    <td><a href="<?php echo $rootUrl; ?>/p_and_o/p_and_o_log?reference={{$row["Reference1"]}}">{{$row["Reference1"]}}</a></td>
                    <td>{{$row["Delivery_Place"]}}</td>
                    <td>{{$row["Order_Status"]}}</td>
                    <td style="display: grid"  data-id="{{$row["id"]}}" data-reference1="{{$row["Reference1"]}}" data-reqdeldate="{{$row["Requested_Del_From_Date_Time"]}}">
                        {{$row["Comments"]}}
                        <input class="userComment" placeholder="Add New Comments" type="text" name="comments">
                        <button style="margin-top: 2px;" class="saveComment btn-primary">Save</button>
                    </td>
                    <td>{{$row["Collection_Town"]}}</td>
                    <td>{{$row["Delivery_Town"]}}</td>
                    <td>{{$row["Requested_Col_From_Date_Time"]}}</td>
                    <td>{{$row["Original_Requested_Del_From_Date_Time"]}}</td>
                    <td>{{$row["Requested_Del_From_Date_Time"]}}</td>
                    <td>{{$row["Actual_Col_Date_Time"]}}</td>
                    <td>{{$row["Actual_Del_Date_Time"]}}</td>
                    <td>{{$row["Collection_Place"]}}</td>
                    <td>{{$row["Reference2"]}}</td>
                    <td>{{$row["file_read_datetime"]}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <th>Order Number</th>
            <th>Reference1</th>
            <th>Customer Name</th>
            <th>Order Status</th>
            <th>User_Comments</th>
            <th>Collection Town</th>
            <th>Delivery Town</th>
            <th>Req Col DT</th>
            <th>Original Req Del DT</th>
            <th>Req Del DT</th>
            <th>Actual Col Date Time</th>
            <th>Actual Del Date Time</th>
            <th>Collection Place</th>
            <th>Reference2</th>
            <th>Updated At</th>
            </tfoot>
        </table>

{{--    </div>--}}
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
         * Datatable intialization and config.
         */

        var table = $('#pando-list').DataTable({
            dom: 'Bfrtip',
            buttons: ['print', 'excel'],
            "order": [[9, "desc"]],
            "columnDefs": [
                { "width": "200px", "targets": 12 }
            ],
            "scrollX": true,
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


        $('.saveComment').click(function () {
           console.log("fired");

           var recordId = $(this).parent().data('id');
           var reqDelDate = $(this).parent().data('reqdeldate');
           var reference1 = $(this).parent().data('reference1');
           var comment = $(this).prev('input').val();
           console.log(recordId);

           if (comment !== "") {
               console.log("new comment");
               console.log(comment);
               $.ajax({
                   type: "GET",
                   url: rootUrl + "/api/updateRecordComments",
                   data: {
                       "recordId": recordId,
                       "comment": comment,
                       "reqdeldate": reqDelDate,
                       "reference1": reference1,
                   },
                   dataType: "json",
                   success: function (data) {
                       console.log(data);
                       if (data.status == "success") {
                           Swal.fire(
                               'Updated!',
                               'Record has been updated.',
                               'success'
                           )
                           $(this).closest('td');

                       } else {
                           Swal.fire(
                               'Error during update!',
                               'Please try again or contact administrators.',
                               'error'
                           )
                           comment.val("");
                       }
                   }
               });
           }
        });
    </script>
@endsection
