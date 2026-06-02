@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'DIS Home')
@section('homeActiveLink', 'active activeUnderline')
@section('css')
    <style>
        .global-back-button {
            display: none;
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


    <div class="simpleflex" style="justify-content: space-evenly">

        <div class="home-image-button-flex">
            <a href="{{ route('weld-mill-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/20-weld-mill.jpg') }}"/>
                <h4 class="text-center mt-2">Weld Mill</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('rhs-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/20-rhs-mill.jpg') }}"/>
                <h4 class="text-center mt-2">RHS Mill</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('slitter-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/slitter-banner_s.jpg') }}"/>
                <h4 class="text-center mt-2">Slitter</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('mngr-tracking-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/mill_tracking_2.jpg?v2') }}"/>
                <h4 class="text-center mt-2">Mill Tracking</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('order-tracking-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/order-tracking.jpg?v2') }}"/>
                <h4 class="text-center mt-2">Order Tracking</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('casing-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/casing_furnace_1.jpg') }}"/>
                <h4 class="text-center mt-2">Casing Mill</h4>
            </a>
        </div>


        <div class="home-image-button-flex">
            <a href="{{ route('pivots-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/pivots_1.jpg') }}"/>
                <h4 class="text-center mt-2">Pivots</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('rounds-finishing-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/rounds-finishing-mill.JPG') }}"/>
                <h4 class="text-center mt-2">Rounds Finishing</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('engineering-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/engineering-home.PNG') }}"/>
                <h4 class="text-center mt-2">Journey to Reliability (J2R)</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('quality') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/macro-quality.jpg') }}"/>
                <h4 class="text-center mt-2">Quality</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('despatch') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/despatch.jpg') }}"/>
                <h4 class="text-center mt-2">Despatch</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('external-systems') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/nimbus_screenshot.png') }}"/>
                <h4 class="text-center mt-2">External Systems</h4>
            </a>
        </div>


        <div class="home-image-button-flex">
            <a href="{{ route('etl-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/weld-mill-etl.PNG') }}"/>
                <h4 class="text-center mt-2">Energy Tick List</h4>
            </a>
        </div>

        <div class="home-image-button-flex">
            <a href="{{ route('data-science-external-links-home') }}">
                <img class="img-thumbnail" src="{{ asset('/public/images/datascience-banner.png') }}"/>
                <h4 class="text-center mt-2">Data Science Links</h4>
            </a>
        </div>


        {{--        <div class="col-sm">--}}
        {{--                    <a href="">--}}
        {{--                    <img class="img-thumbnail"  src="{{ asset('/public/images/20-weld-mill.jpg') }}" />--}}
        {{--                    <h4 class="text-center mt-2">Weld Mill</h4>--}}
        {{--                    </a>--}}
        {{--              </div>--}}

        {{--              <div class="col-sm">--}}
        {{--                    <a href="">--}}
        {{--                        <img class="img-thumbnail"  src="{{ asset('/public/images/20-weld-mill.jpg') }}" /> --}}
        {{--                        <h4 class="text-center mt-2">Weld Mill</h4>--}}
        {{--                    </a>--}}
        {{--                  </div>--}}


    </div>



    <?php

    //                $tandemConn = odbc_connect("NEC", "FACT.USER", "PREPROG");
    //
    //                $outval = odbc_columns($tandemConn, "H20Tandem", "%", "DAN_ORDHDRF", "%");
    //    $pages = array();
    //    while (odbc_fetch_into($outval, $pages)) {
    //        echo $pages[3] . "<br />\n"; // presents all fields of the array $pages in a new line until the array pointer reaches the end of array data
    //    }

    //                $sql = "SELECT * FROM DAN_ORDHDRF ";
    //                $rs = odbc_exec($tandemConn, $sql);
    //                $array = [];
    //                if (!$rs)
    //                {exit("Error in SQL");}
    //
    //                $i = 0;
    //                while($row=odbc_fetch_array($rs,$i)) {
    //
    //                    /* BREAK APART THE KEYS FROM THE VALUES */
    //                    foreach($row AS $key=>$value) {
    //                        /* ADD TO THE ARRAY */
    //                     //   $array[$i][$key]=$row[$key];
    //
    //                        echo $row["COIL_COIL_NO"];
    //                        echo "<br />";
    //                    }
    //
    //                    /* INCREMENT */
    //                    $i++;
    //
    //                }
    //                odbc_close($tandemConn);
    //
    //
    //            } catch (PDOException $e) {
    //                echo $e->getmessage();
    //            }


    ?>



@endsection
