@extends('layouts.app')

@section('pageTitle', 'Add Macro')
@section('pageName', 'Add Macro')
@section('content')
    <div class="row" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
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


                    <div class="" id="cooling-tower-meta-data" style="margin-bottom: 100px">
                        <div id="manufacturer"></div>
                        <div id="installation-date"></div>
                        <div id="model-no"></div>
                        <div id="serial-no"></div>
                    </div>



                <form method="post" action="{{ route('cooling-tower-logs.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="justify-content-center" style="margin-top: -70px;">
                        <div class="form-group m-1">
                            <label for="cooling-tower">Cooling Tower</label>
                            <select class="form-control" name="cooling-tower" id="cooling-tower-select">
                                <option value="RHS FURNACE">RHS FURNACE</option>
                                <option value="RHS MILL EXIT">RHS MILL EXIT</option>
                                <option value="ANNEALER">ANNEALER</option>
                                <option value="WELDER">WELDER</option>
                                <option value="CASING FURNACE">CASING FURNACE</option>
                                <option value="CASING MILL EXIT">CASING MILL EXIT</option>

                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="isOnline">Is online & in operation</label>
                            <select class="form-control" name="is-online">
                                <option value="Yes">YES</option>
                                <option value="No">NO</option>
                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="igs">Is water in CT sump fresh and clear?</label>
                            <select class="form-control" name="is-fresh">
                                <option value="Yes">YES</option>
                                <option value="No">NO</option>
                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="igs">Is the system operating as normal?</label>
                            <select class="form-control" name="is-operating">
                                <option value="Yes">YES</option>
                                <option value="No">NO</option>
                            </select>
                        </div>

                    </div>
                    <label for="comments">Comments (If applicable)</label>
                    <textarea name="comments" style="width:100%;">



                    </textarea>

                    <br />
                    <br />
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>










@endsection

@section('functionalScripts')
    <script>

        let coolingTowerMetaData = <?php echo $ctMetaData; ?>;

        console.info(coolingTowerMetaData);

        const fileInput = document.getElementById("macroImage");
        window.addEventListener('paste', e => {
            fileInput.files = e.clipboardData.files;
        });




        $(document).on('change', 'select#cooling-tower-select', function() {
            console.log("sjkfnsdjkfnsdf");
            console.log(coolingTowerMetaData[this.value]);
            $('#manufacturer').html("Manufacturer : " + coolingTowerMetaData[this.value].Manufacturer)
            $('#installation-date').html("Install Date : " + coolingTowerMetaData[this.value].InstallationDate)
            $('#model-no').html("Model No : " + coolingTowerMetaData[this.value].ModelNo)
            $('#serial-no').html("Serial No : " + coolingTowerMetaData[this.value].SerialNo)


            // <div id="installation-date"></div>
            // <div id="model-no"></div>
            // <div id="serial-no"></div>
            // if ($('input#outside_diameter_north').val() > 0 && $('input#outside_diameter_south').val() > 0) {
            //
            //     var avg = (parseFloat($('input#outside_diameter_north').val()) + parseFloat($('input#outside_diameter_south').val())) / 2;
            //     console.log(avg);
            //     $('input#outside_diameter_ns_avg').val(avg.toFixed(2));
            // }

        });

    </script>


@endsection
