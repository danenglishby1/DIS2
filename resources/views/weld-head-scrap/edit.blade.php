@extends('layouts.app')

@section('pageTitle', 'QR WM715 Edit' )
@section('pageName', 'QR WM715 Edit')
@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h2 class="display-3"></h2>
            <div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
                <form method="post" action="{{ route('weld-head-scrap.update', $data->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="d-flex flex-wrap justify-content-center" style="margin-top: -70px;">

                        <div class="form-group m-1">
                            <label for="area">Area</label>
                            <select class="form-control" name="area">
                                <option {{($data->area == "Slitter" ? "selected" : "")}} value="Slitter">Slitter</option>
                                <option {{($data->area == "Annealer" ? "selected" : "")}} value="Annealer">Annealer</option>
                                <option {{($data->area == "Coil Joiner" ? "selected" : "")}} value="Coil Joiner">Coil Joiner</option>
                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="coil_no">Coil No</label>
                            <input type="text" class="form-control" name="coil_no" value="{{$data->coil_no}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="quality">Quality</label>
                            <input type="text" class="form-control" name="quality"  value="{{$data->quality}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="front_end_scrap">Front End Scrap</label>
                            <input type="text" class="form-control" name="front_end_scrap"  value="{{$data->front_end_scrap}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="rear_end_scrap">Rear End Scrap</label>
                            <input type="text" class="form-control" name="rear_end_scrap"  value="{{$data->rear_end_scrap}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="front_end_comments">Front End Comment</label>
                            <input type="text" class="form-control" name="front_end_comments"  value="{{$data->front_end_comments}}"/>
                        </div>

                        <div class="form-group m-1">
                            <label for="rear_end_comments">Rear End Comment</label>
                            <input type="text" class="form-control" name="rear_end_comments"  value="{{$data->rear_end_comments}}"/>
                        </div>

                        <button type="submit" class="btn btn-primary mt-5">Update</button>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')

    <script>
        const fileInput = document.getElementById("macroImage");
        window.addEventListener('paste', e => {
            fileInput.files = e.clipboardData.files;
        });

        $(document).on('change', 'input#inside_diameter_north, input#inside_diameter_south', function() {
            // console.log("changed");
            // console.log($('input#inside_diameter_north').val());
            // console.log($('input#inside_diameter_south').val());

            if ($('input#inside_diameter_north').val() > 0 && $('input#inside_diameter_south').val() > 0) {
                var avg = (parseFloat($('input#inside_diameter_north').val()) + parseFloat($('input#inside_diameter_south').val())) / 2;
                console.log(avg);
                $('input#inside_diameter_ns_avg').val(avg.toFixed(2));
            }

        });

        $(document).on('change', 'input#outside_diameter_north, input#outside_diameter_south', function() {

            // console.log("changed");
             console.log($('input#outside_diameter_north').val());
             console.log($('input#outside_diameter_south').val());
            if ($('input#outside_diameter_north').val() > 0 && $('input#outside_diameter_south').val() > 0) {
                var avg = (parseFloat($('input#outside_diameter_north').val()) + parseFloat($('input#outside_diameter_south').val())) / 2;



                console.log(avg);
                $('input#outside_diameter_ns_avg').val(avg);
            }
        });


    </script>


@endsection
