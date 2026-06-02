@extends('layouts.app')

@section('pageTitle', 'Edit Macro')
@section('pageName', 'Edit Macro')
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

<div style="margin-top: 70px;">
                <form method="post" action="{{ route('cooling-tower-logs.update', $coolingTowerLogs->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf


                        <div class="form-group m-1">
                            <label for="cooling-tower">Cooling Tower</label>
                            <select class="form-control" name="cooling-tower" id="cooling-tower-select">
                                <option {{($coolingTowerLogs->cooling_tower_identifier == "RHS FURNACE" ? "selected" : "")}} value="RHS FURNACE">RHS FURNACE</option>
                                <option {{($coolingTowerLogs->cooling_tower_identifier == "RHS MILL EXIT" ? "selected" : "")}} value="RHS MILL EXIT">RHS MILL EXIT</option>
                                <option {{($coolingTowerLogs->cooling_tower_identifier == "ANNEALER" ? "selected" : "")}} value="ANNEALER">ANNEALER</option>
                                <option {{($coolingTowerLogs->cooling_tower_identifier == "WELDER" ? "selected" : "")}} value="WELDER">WELDER</option>
                                <option {{($coolingTowerLogs->cooling_tower_identifier == "CASING FURNACE" ? "selected" : "")}} value="CASING FURNACE">CASING FURNACE</option>
                                <option {{($coolingTowerLogs->cooling_tower_identifier == "CASING MILL EXIT" ? "selected" : "")}} value="CASING MILL EXIT">CASING MILL EXIT</option>

                            </select>
                        </div>

                        <div class="form-group m-1">
                            <label for="is-online">Is Online and in production</label>
                            <select class="form-control" name="is-online">
                                {{($coolingTowerLogs->online == "" ? "<option selected value=''>Please Select...</option>" : "")}}
                                <option value="No" {{($coolingTowerLogs->online == "No" ? "selected" : "")}}>No</option>
                                <option value="Yes" {{($coolingTowerLogs->online == "Yes" ? "selected" : "")}} >Yes</option>
                            </select>
                        </div>


                        <div class="form-group m-1">
                            <label for="is-fresh">Is water in CT sump fresh and clear</label>
                            <select class="form-control" name="is-fresh">
                                {{($coolingTowerLogs->fresh == "" ? "<option selected value=''>Please Select...</option>" : "")}}
                                <option value="No" {{($coolingTowerLogs->fresh == "No" ? "selected" : "")}}>No</option>
                                <option value="Yes" {{($coolingTowerLogs->fresh == "Yes" ? "selected" : "")}} >Yes</option>
                            </select>
                        </div>



                        <div class="form-group m-1">
                            <label for="is-operating">Is the system operating as normal</label>
                            <select class="form-control" name="is-operating">
                                {{($coolingTowerLogs->operating_normal == "" ? "<option selected value=''>Please Select...</option>" : "")}}
                                <option value="No" {{($coolingTowerLogs->operating_normal == "No" ? "selected" : "")}}>No</option>
                                <option value="Yes" {{($coolingTowerLogs->operating_normal == "Yes" ? "selected" : "")}} >Yes</option>
                            </select>
                        </div>



                        <div class="form-group m-1">
                            <label for="technician">Comments</label>
                            <br />
                            <textarea style="width:100%" name="comments"/>{{$coolingTowerLogs->comments}}</textarea>
                        </div>




                    </div>





                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                </form>
</div>
            </div>
        </div>
    </div>
@endsection

@section('functionalScripts')

    <script>



    </script>


@endsection
