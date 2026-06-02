@extends('layouts.app')

@section('pageTitle', 'Mill Pen Tracking')
@section('pageName', 'Mill Pen Tracking')
@section('millTrackingActiveLink', 'active activeUnderline')
@section('css')
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(7, 250px);
            grid-auto-rows: 285px;
            grid-gap: 5px;
        }

        .col-span {
            grid-column: span 1;
        }

        .grid > div {
            background-color: #e9e0e0;
        }

        .grid .col-span {
            background-color: gray;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/NVD3/nv.d3.css')}}"/>
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

    {{--    {{dd($millBayData)}}--}}



    <!-- Content Row -->
    <div>
        <h1>
            RHS Extensions
        </h1>
        <div class="grid">
            @php

                $rhsExtensionPensArray = ["O", "P", "Q", "R", "S", "T", "U", "H", "I", "J", "K", "L", "M", "N", "A", "B", "C", "D", "E", "F", "G"];
                $rhsExtensionsProcessRoutes =["","F","R","L","B","H","V","X","P","N"];
                $rhsExtensionsSizes =["", "219,1", "229", "244.5", "273.1", "308", "323.9", "355.6", "375", "406.4", "435", "457.2", "473.1", "498.5", "508"];
                $rhsExtensionsThickness = ["", "4", "4.5", "5", "5.6", "6", "6.35", "6.4", "6.71", "7.1", "7.9", "7.95", "8", "8.2", "8.8", "9", "9.3", "9.5",
        "9.53", "10", "10.16", "10.5", "11", "11.05", "11.1", "12", "12.5", "12.7", "14.2", "14.3", "15.1", "15.9", "16", "16.1", "16.13", "17.5"];
                $rhsExtensionPartsArray = ["","1","2","3","4","5","6","7","8","9"];

                foreach ($rhsExtensionPensArray as $r)
                    {
                        echo '<div id="'.$r.'"><div> <span  style="font-weight: bold;font-size: 30px;">'.$r.'</span></div>
                         <div style="display:flex;">
                            <select class="processRoutes">';

                            foreach ($rhsExtensionsProcessRoutes as $pr)
                            {
                                echo '<option' . ($millBayData[$r]["pr"] == "$pr" ? " selected " : "") . ' value="'.$pr.'">PR: '.$pr.'</option>';
                            }

                            echo '</select>';

                        echo '<div>
                            <select class="sizes">';
                        foreach($rhsExtensionsSizes as $size)
                            {
                                echo '<option ' . ($millBayData[$r]["size"] == "$size" ? " selected " : "") . '  value="'.$size.'">Size: '.$size.'</option>';
                            }
                            echo'</select>
                                </div>';


                        echo '<div>
                <select class="thickness">';

                        foreach ($rhsExtensionsThickness as $thickness) {
                            echo '<option' . ($millBayData[$r]["thk"] == "$thickness" ? " selected" : "") . '   value="'.$thickness.'">THK: '. $thickness .'</option>';
                        }

                    echo '</select>
            </div></div>';

                                  echo '<div>
                <select class="partNumber">';

                        foreach ($rhsExtensionPartsArray as $part) {
                            echo '<option' . ($millBayData[$r]["part"] == "$part" ? " selected" : "") . '   value="'.$part.'">Part: '. $part .'</option>';
                        }

                    echo '</select>
            </div>';

                        echo ' <div> Full (%) : <input class="full" type="text" value="'.$millBayData[$r]["full"].'"></div>

            <div>Comments : <textarea class="comments">'.$millBayData[$r]["comments"].'</textarea> <button class="submitTickButton" style=" margin: 18px;">&#10004;</button></div>
            <div><button class="clearPenButton" style=" margin: 18px;">Clear</button></div>
            </div>';


            }


            @endphp
        </div>
    </div>


    <!-- MILL BAYS -->
    <div>
        <h1>
            Mill Bays
        </h1>
        <div>

            @php
                $millBayPensArray = ["M11" => "0", "M12" => "0", "M13" => "0", "M14" => "0", "M15" => "0", "T9" => "400px",
                 "M5" => "0", "M6" => "0", "M7" => "0", "M8" => "0", "M9" => "0", "M10" => "0",
                  "M1" => "0", "M2" => "0", "M3" => "0", "M4" => "0", "BEV FEED TABLE 0" => "300px"];

                $millBayProcessRoutes =["", "F","R","L","B","H","V","X","P","N"];
                $millBaySizes =["", "219,1", "229", "244.5", "273.1", "308", "323.9", "355.6", "375", "406.4", "435", "457.2", "473.1", "498.5", "508"];
                $millBayThickness = ["", "4", "4.5", "5", "5.6", "6", "6.35", "6.4", "6.71", "7.1", "7.9", "7.95", "8", "8.2", "8.8", "9", "9.3", "9.5",
                 "9.53", "10", "10.16", "10.5", "11", "11.05", "11.1", "12", "12.5", "12.7", "14.2", "14.3", "15.1", "15.9", "16", "16.1", "16.13", "17.5"];
                $millBayPartsArray = ["", "1","2","3","4","5","6","7","8","9"];


     foreach ($millBayPensArray as $key => $value)
                             {

                                 if ($key == "M11" || $key == "M1" || $key == "M5")
                                     {
                                         echo '<div id="'.$key.'" class="grid  mt-2">';
                                     }

                                 echo '<div id="'.$key.'"  ' .($value != "0" ? ' style=width:'.$value.' ': ''). '><div> <span  style="font-weight: bold;font-size: 30px;">'.$key.'</span></div>
                                      <div style="display:flex;">
                                     <select class="processRoutes">';

                                 foreach ($millBayProcessRoutes as $pr) {
                                    echo '<option ' . ($millBayData[$key]["pr"] == "$pr" ? " selected " : "") . ' value="'.$pr.'">PR: '.$pr.'</option>';
                                 }
                                    echo '</select>';

                                 echo '<div>
                                     <select class="sizes">';
                                 foreach ($millBaySizes as $size)
                                     {
                                        echo '<option ' . ($millBayData[$key]["size"] == "$size" ? " selected " : "") . '  value="'.$size.'">Size: '.$size.'</option>';
                                     }
                                     echo '</select>
                                         </div>';


                                 echo '<div>
                         <select class="thickness" >';
                                 foreach ($millBayThickness as $thickness) {
                                    echo '<option ' . ($millBayData[$key]["thk"] == "$thickness" ? " selected" : "") . '   value="'.$thickness.'">THK: '. $thickness .'</option>';
                                 }
                         echo '</select>
                     </div></div>';


                                   echo '<div>
                <select class="partNumber">';

                        foreach ($millBayPartsArray as $part) {
                            echo '<option' . ($millBayData[$key]["part"] == "$part" ? " selected" : "") . '   value="'.$part.'">Part: '. $part .'</option>';
                        }

                    echo '</select>
            </div>';



                                 echo ' <div> Full (%) : <input class="full" type="text" value="'.$millBayData[$key]["full"].'"></div>

                     <div>Comments : <textarea class="comments">'.$millBayData[$key]["comments"].'</textarea> <button class="submitTickButton" style=" margin: 18px;">&#10004;</button></div>

                     <div><button class="clearPenButton" style=" margin: 18px;">Clear</button></div>
                     </div>';

                                 if ($key == "BEV FEED TABLE 0" || $key == "T9" || $key == "M10")
                                     {
                                         echo "</div>";
                                     }



                             }


            @endphp
        </div>
    </div>


    <!-- Casing Pens -->


    <h1>
        Casing Pens
    </h1>
    <div>
        @php

            $casingPensArray = ["C1" => "0", "C2" => "0", "C3" => "0",
             "C4" => "0", "C5" => "0", "C6" => "0", "C7" => "0",
                        "C8" => "0", "C9" => "0", "C10" => "0", "C11" => "0", "C4B" => "300px",
                         "C12" => "0", "C13" => "0", "C14" => "0", "C15" => "0", "C15" => "0", "C16" => "0"];


             $casingPensProcessRoutes =["","F","R","L","B","H","V","X","P","N"];
             $casingPensSizes =["", "219,1", "229", "244.5", "273.1", "308", "323.9", "355.6", "375", "406.4", "435", "457.2", "473.1", "498.5", "508"];
             $casingPensThickness = ["", "4", "4.5", "5", "5.6", "6", "6.35", "6.4", "6.71", "7.1", "7.9", "7.95", "8", "8.2", "8.8", "9", "9.3", "9.5",
                    "9.53", "10", "10.16", "10.5", "11", "11.05", "11.1", "12", "12.5", "12.7", "14.2", "14.3", "15.1", "15.9", "16", "16.1", "16.13", "17.5"];
            $casingPensPartsArray = ["","1","2","3","4","5","6","7","8","9"];


        foreach ($casingPensArray as $key => $value)
                                {

                                    if ($key == "C1" || $key == "C4" || $key == "C8" || $key == "C12")
                                        {
                                            echo '<div id="'.$key.'"  class="grid mt-2">';
                                        }

                                    echo '<div id="'.$key.'"' .($value != "0" ? ' style=width:'.$value.' ': ''). '><div> <span style="font-weight: bold;font-size: 30px;">'.$key.'</span></div>
                                        <div style="display:flex;">
                                        <select class="processRoutes">';
                                        foreach($casingPensProcessRoutes as $pr) {
                                        echo '<option' . ($millBayData[$key]["pr"] == "$pr" ? " selected " : "") . ' value="'.$pr.'">PR: '.$pr.'</option>';
                                        }

                                        echo '</select>';

                                    echo '<div>
                                        <select class="sizes">';
                                        foreach ($casingPensSizes as $size) {
                                            echo '<option ' . ($millBayData[$key]["size"] == "$size" ? " selected " : "") . '  value="'.$size.'">Size: '.$size.'</option>';
                                            }

                                        echo '</select>
                                            </div>';


                                    echo '<div>
                            <select class="thickness">';

                                    foreach($casingPensThickness as $thickness) {
                                    echo '<option' . ($millBayData[$key]["thk"] == "$thickness" ? " selected" : "") . '   value="'.$thickness.'">THK: '. $thickness .'</option>';
                                    }



                                echo '</select>
                        </div>
                        </div>';



                                      echo '<div>
                <select class="partNumber">';

                        foreach ($casingPensPartsArray as $part) {
                            echo '<option' . ($millBayData[$key]["part"] == "$part" ? " selected" : "") . '   value="'.$part.'">Part: '. $part .'</option>';
                        }

                    echo '</select>
            </div>';


                                    echo ' <div> Full (%) : <input class="full" type="text" value="'.$millBayData[$key]["full"].'"></div>

                        <div>Comments : <textarea class="comments">'.$millBayData[$key]["comments"].'</textarea> <button class="submitTickButton" style=" margin: 18px;">&#10004;</button></div>
                        <div><button class="clearPenButton" style=" margin: 18px;">Clear</button></div></div>';

                                    if ($key == "C3" || $key == "C7" || $key == "C4B" || $key == "C16")
                                        {
                                            echo "</div>";
                                        }



                                }


        @endphp
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
    <!-- End  Extension scripts for datatables print functionality -->
    <script src="{{ asset('public/libraries/lodash/lodash.js')}}"></script>
    <script src="{{ asset('public/js/nvd3-helpers/chart-builder.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/d3.min.js')}}"></script>
    <script src="{{ asset('public/libraries/NVD3/nv.d3.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
         * Datatable intialization and config.
         */
        $( document ).ready(function() {

            $('.submitTickButton').on('click', function () {
                parentContainer = $(this).parent().parent();

                penId = $(this).parent().parent().attr('id');
                processRouteSelected = parentContainer.find("select.processRoutes").val();
                sizeSelected = parentContainer.find("select.sizes").val();
                thicknessSelected = parentContainer.find("select.thickness").val();
                full = parentContainer.find("input.full").val();
                comments = parentContainer.find("textarea.comments").val();
                partNumber = parentContainer.find("select.partNumber").val();

                console.log("PEN: " + penId)
                console.log("PR : " + processRouteSelected);
                console.log("SIZE : " + sizeSelected);
                console.log("THK : " + thicknessSelected);
                console.log("FULL : " + full);
                console.log("COMMENTS : " + comments);
                console.log("PART : " + partNumber);


                // submit data via post.
                $.ajax({
                    type: 'POST',
                    data: {'penId': penId,
                        'processRouteSelected': processRouteSelected,
                        'sizeSelected': sizeSelected,
                        'thicknessSelected': thicknessSelected,
                        'full': full,
                        'part': partNumber,
                        'comments': comments},
                    url: rootUrl+'/api/SaveMillPenTrackingData',
                    dataType: 'json',
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('.ajax-loader').css('display', 'block');
                    },
                    success: function (data) {
                        console.log(data);

                        if (data.updated)
                        {
                            Swal.fire(
                                'Updated!',
                                'Record has been updated.',
                                'success'
                            )
                        }

                    },
                    complete: function () {
                        $('.ajax-loader').css('display', 'none');
                    }
                });

                // console.info();
                // console.log(selectOption);
            });




            $('.clearPenButton').on('click', function () {
              console.log("clicked");

                parentContainer = $(this).parent().parent();

                parentContainer.find("select.processRoutes").prop("selectedIndex", 0);
                parentContainer.find("select.sizes").prop("selectedIndex", 0);
                parentContainer.find("select.thickness").prop("selectedIndex", 0);
                parentContainer.find("select.thickness").prop("selectedIndex", 0);
                parentContainer.find("select.partNumber").prop("selectedIndex", 0);
                parentContainer.find("input.full").val("");
                parentContainer.find("textarea.comments").val("");

            })

        });
    </script>

@endsection
