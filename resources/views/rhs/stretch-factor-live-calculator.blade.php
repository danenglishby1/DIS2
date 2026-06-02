@extends('layouts.app')

@section('pageTitle', 'RHS Stretch Factor Calculator')
@section('pageName', 'RHS Stretch Factors Calculator')
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



    <h2 style="text-align:center;">Stretch Calculation : (Output Length - Input Length) / Input Length * 100</h2>
    <hr />
    <div id="average" style="width:100%"><h2 style="text-align: center">Avgerage Stretch:<span id="averageStretch"></span></h2></div>




        <table class="table" id="stretchFactorCalculator">

            <thead>
            <th>THK</th>
            <th>Size</th>
            <th>Pipe No</th>
            <th>Section No</th>
            <th>Date</th>
            <th>RHS In Length</th>
            <th>RHS Out Length</th>
            <th>Stretch</th>
            <th>Stretch %</th>

            </thead>
            <tbody>

                @for($i = 1; $i < 11; $i++)
                    <tr>
                <td><input type="text" name="thickness{{$i}}" id="thickness{{$i}}" placeholder="Pipe{{$i}} Thick"/> </td>
                <td><input type="text" name="size{{$i}}" id="size{{$i}}" placeholder="Pipe{{$i}} Size" /> </td>
                <td><input type="text" name="pipeNo{{$i}}" id="pipeNo{{$i}}" placeholder="Pipe{{$i}} Number" /> </td>
                <td><input type="text" name="sectionNo{{$i}}" id="sectionNo{{$i}}" placeholder="Section{{$i}} Number" /> </td>
                <td><input type="date" name="sectionDate{{$i}}" id="sectionDate{{$i}}" placeholder="Date{{$i}}" /> </td>
                <td><input type="text" name="rhsInLength{{$i}}" id="rhsInLength{{$i}}" placeholder="In Length"/> </td>
                <td><input type="text" name="rhsOutLength{{$i}}" id="rhsOutLength{{$i}}" placeholder="Out Length"/> </td>
                <td><input type="text" name="stretch{{$i}}" id="stretch{{$i}}" placeholder="Stretch"/> </td>
                <td><input type="text" name="stretchPercent{{$i}}" id="stretchPercent{{$i}}" placeholder="% "/> </td>
                    </tr>
                @endfor

            </tbody>

            <tfoot>
            <th>THK</th>
            <th>Size</th>
            <th>Pipe No</th>
            <th>Section No</th>
            <th>Date</th>
            <th>RHS In Length</th>
            <th>RHS Out Length</th>
            <th>Stretch</th>
            <th>Stretch %</th>
            </tfoot>
        </table>

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

        $('#thickness1').keyup(function () {
            let thk = $(this).closest('tr').find('#thickness1').val();

            $('#thickness2').val(thk);
            $('#thickness3').val(thk);
            $('#thickness4').val(thk);
            $('#thickness5').val(thk);
            $('#thickness6').val(thk);
            $('#thickness7').val(thk);
            $('#thickness8').val(thk);
            $('#thickness9').val(thk);
            $('#thickness10').val(thk);
        });

        $('#size1').keyup(function () {
            let thk = $(this).closest('tr').find('#size1').val();

            $('#size2').val(thk);
            $('#size3').val(thk);
            $('#size4').val(thk);
            $('#size5').val(thk);
            $('#size6').val(thk);
            $('#size7').val(thk);
            $('#size8').val(thk);
            $('#size9').val(thk);
            $('#size10').val(thk);
        });


        $('#rhsOutLength1').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength1').val() + " " +  $(this).closest('tr').find('#rhsOutLength1').val())
            $('#stretch1').val($(this).closest('tr').find('#rhsOutLength1').val() - $(this).closest('tr').find('#rhsInLength1').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent1').val((($(this).closest('tr').find('#rhsOutLength1').val() - $(this).closest('tr').find('#rhsInLength1').val())/$(this).closest('tr').find('#rhsInLength1').val() * 100).toFixed(2) + "%").trigger("change");
        });

        $('#rhsOutLength2').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength2').val() + " " +  $(this).closest('tr').find('#rhsOutLength2').val())
            $('#stretch2').val($(this).closest('tr').find('#rhsOutLength2').val() - $(this).closest('tr').find('#rhsInLength2').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent2').val((($(this).closest('tr').find('#rhsOutLength2').val() - $(this).closest('tr').find('#rhsInLength2').val())/$(this).closest('tr').find('#rhsInLength2').val() * 100).toFixed(2) + "%").trigger("change");
        });

        $('#rhsOutLength3').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength3').val() + " " +  $(this).closest('tr').find('#rhsOutLength3').val())
            $('#stretch3').val($(this).closest('tr').find('#rhsOutLength3').val() - $(this).closest('tr').find('#rhsInLength3').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent3').val((($(this).closest('tr').find('#rhsOutLength3').val() - $(this).closest('tr').find('#rhsInLength3').val())/$(this).closest('tr').find('#rhsInLength3').val() * 100).toFixed(2) + "%").trigger("change");
        });

        $('#rhsOutLength4').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength4').val() + " " +  $(this).closest('tr').find('#rhsOutLength4').val())
            $('#stretch4').val($(this).closest('tr').find('#rhsOutLength4').val() - $(this).closest('tr').find('#rhsInLength4').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent4').val((($(this).closest('tr').find('#rhsOutLength4').val() - $(this).closest('tr').find('#rhsInLength4').val())/$(this).closest('tr').find('#rhsInLength4').val() * 100).toFixed(2) + "%").trigger("change");
        });

        $('#rhsOutLength5').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength5').val() + " " +  $(this).closest('tr').find('#rhsOutLength5').val())
            $('#stretch5').val($(this).closest('tr').find('#rhsOutLength5').val() - $(this).closest('tr').find('#rhsInLength5').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent5').val((($(this).closest('tr').find('#rhsOutLength5').val() - $(this).closest('tr').find('#rhsInLength5').val())/$(this).closest('tr').find('#rhsInLength5').val() * 100).toFixed(2) + "%").trigger("change");
        });

        $('#rhsOutLength6').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength5').val() + " " +  $(this).closest('tr').find('#rhsOutLength5').val())
            $('#stretch6').val($(this).closest('tr').find('#rhsOutLength6').val() - $(this).closest('tr').find('#rhsInLength6').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent6').val((($(this).closest('tr').find('#rhsOutLength6').val() - $(this).closest('tr').find('#rhsInLength6').val())/$(this).closest('tr').find('#rhsInLength6').val() * 100).toFixed(2) + "%").trigger("change");
        });

        $('#rhsOutLength7').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength5').val() + " " +  $(this).closest('tr').find('#rhsOutLength5').val())
            $('#stretch7').val($(this).closest('tr').find('#rhsOutLength7').val() - $(this).closest('tr').find('#rhsInLength7').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent7').val((($(this).closest('tr').find('#rhsOutLength7').val() - $(this).closest('tr').find('#rhsInLength7').val())/$(this).closest('tr').find('#rhsInLength7').val() * 100).toFixed(2) + "%").trigger("change");
        });

        $('#rhsOutLength8').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength5').val() + " " +  $(this).closest('tr').find('#rhsOutLength5').val())
            $('#stretch8').val($(this).closest('tr').find('#rhsOutLength8').val() - $(this).closest('tr').find('#rhsInLength8').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent8').val((($(this).closest('tr').find('#rhsOutLength8').val() - $(this).closest('tr').find('#rhsInLength8').val())/$(this).closest('tr').find('#rhsInLength8').val() * 100).toFixed(2) + "%").trigger("change");
        });

        $('#rhsOutLength9').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength5').val() + " " +  $(this).closest('tr').find('#rhsOutLength5').val())
            $('#stretch9').val($(this).closest('tr').find('#rhsOutLength9').val() - $(this).closest('tr').find('#rhsInLength9').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent9').val((($(this).closest('tr').find('#rhsOutLength9').val() - $(this).closest('tr').find('#rhsInLength9').val())/$(this).closest('tr').find('#rhsInLength9').val() * 100).toFixed(2) + "%").trigger("change");
        });

        $('#rhsOutLength10').keyup(function () {
            //console.log($(this).closest('tr').find('#rhsInLength5').val() + " " +  $(this).closest('tr').find('#rhsOutLength5').val())
            $('#stretch10').val($(this).closest('tr').find('#rhsOutLength10').val() - $(this).closest('tr').find('#rhsInLength10').val());
            // Calculate (OUPUT - INPUT) / INPUT * 100  = %
            $('#stretchPercent10').val((($(this).closest('tr').find('#rhsOutLength10').val() - $(this).closest('tr').find('#rhsInLength10').val())/$(this).closest('tr').find('#rhsInLength10').val() * 100).toFixed(2) + "%").trigger("change");
        });
 //

        $('#stretchPercent1, #stretchPercent2, #stretchPercent3, #stretchPercent4, #stretchPercent5, #stretchPercent6, #stretchPercent7, #stretchPercent8, #stretchPercent9, #stretchPercent10').change(function () {
            //console.log($(this).closest('tr').find('#rhsInLength5').val() + " " +  $(this).closest('tr').find('#rhsOutLength5').val())
            // console.log("changed");
            var average = 0;
            var percentTotal = 0;
            for (var i = 1; i < 11; i++) {
                let stretchPercent = $('#stretchPercent'+i).val().replace("%","");
                if ($('#stretchPercent'+i).val() == "") {
                    stretchPercent = 0;
                }
                console.log($('#stretchPercent'+i).val())
                console.log($('#stretchPercent'+i).val().replace("%",""));
                console.log(parseFloat(stretchPercent))
                percentTotal += parseFloat(stretchPercent);
            }

            console.log(percentTotal);

            // Calculate (OUPUT - INPUT) / INPUT * 100  = %

            $('#averageStretch').html(" " +percentTotal.toFixed(2) + "%");

        });




        //
        // $( "#getDataBtn" ).on( "click", function() {
        //
        //     console.log("clicked");
        //
        //
        //     var sizeThickStrArr = $('#sizeThickSelector').val().split('_');
        //     console.log(sizeThickStrArr)
        //     let sdfsdf = "";
        //
        //     let url = rootUrl + "/rhs/stretch-factors?s1=" + sizeThickStrArr[0] + "&s2=" + sizeThickStrArr[1] + "&thk=" + sizeThickStrArr[2];
        //     window.location.href = url;
        //
        // });
        //
        //
        //
            $(document).ready( function () {

                var table = $('#stretchFactorCalculator').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            exportOptions: {
                                format: {
                                    body: function ( inner, rowidx, colidx, node ) {
                                        if ($(node).children("input").length > 0) {
                                            return $(node).children("input").first().val();
                                        } else {
                                            return inner;
                                        }
                                    }
                                }
                            }
                        }
                    ]

                });
            } );


    </script>
@endsection
