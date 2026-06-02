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


    <div>
        <table id="pando-list" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>Reference1</th>
                <th>Req Del DT</th>
                <th>Comment</th>
                <th>Log Created At</th>
            </tr>
            </thead>
            <tbody>
            <!-- Note: $wipArray is 3 keys deep.-->
            @foreach($data as $row)
                    <td>{{$row["Reference1"]}}</td>
                    <td>{{$row["Requested_Del_From_Date_Time"]}}</td>
                    <td>{{$row["Comments"]}}</td>
                    <td>{{$row["created_at"]}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <th>Reference1</th>
            <th>Req Del DT</th>
            <th>Comment</th>
            <th>Log Created At</th>
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
