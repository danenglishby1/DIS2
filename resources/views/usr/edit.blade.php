@extends('layouts.app')

@section('pageTitle', 'Edit Ultrasonic Reject')
@section('pageName', 'Edit Ultrasonic Reject')
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
                <form method="post" action="{{ route('usr.update', $usr->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf

                        <div class="form-group m-1 text-center">
                            <label style="font-weight: bold;font-size:16px;" for="defect">Defect</label>
                            <select name="defect">
                                <option {{($usr->defect == "OD Lam to Surface Segragate") ? "selected" : ""}} value="OD Lam to Surface Segragate">OD Lam to Surface Segragate</option>
                                <option {{($usr->defect == "ID Lam to Surface Segragate") ? "selected" : ""}} value="ID Lam to Surface Segragate">ID Lam to Surface Segragate</option>
                                <option {{($usr->defect == "OD Lam Sub Surface Segragate") ? "selected" : ""}} value="OD Lam Sub Surface Segragate">OD Lam Sub Surface Segragate</option>
                                <option {{($usr->defect == "ID Lam Sub Surface Segragate") ? "selected" : ""}} value="ID Lam Sub Surface Segragate">ID Lam Sub Surface Segragate</option>
                                <option {{($usr->defect == "Mid Wall Laminar Segragate") ? "selected" : ""}} value="Mid Wall Laminar Segragate">Mid Wall Laminar Segragate</option>
                                <option {{($usr->defect == "OD Slab Edge Defect") ? "selected" : ""}} value="OD Slab Edge Defect">OD Slab Edge Defect</option>
                                <option {{($usr->defect == "ID Slab Edge Defect") ? "selected" : ""}} value="ID Slab Edge Defect">ID Slab Edge Defect</option>
                                <option {{($usr->defect == "OD Lam to Surface") ? "selected" : ""}} value="OD Lam to Surface">OD Lam to Surface</option>
                                <option {{($usr->defect == "ID lam to Surface") ? "selected" : ""}} value="ID lam to Surface">ID lam to Surface</option>
                                <option {{($usr->defect == "OD Lam Sub Surface") ? "selected" : ""}} value="OD Lam Sub Surface">OD Lam Sub Surface</option>
                                <option {{($usr->defect == "ID Lam Sub Surface") ? "selected" : ""}} value="ID Lam Sub Surface">ID Lam Sub Surface</option>
                                <option {{($usr->defect == "Mid Wall Laminar") ? "selected" : ""}} value="Mid Wall Laminar">Mid Wall Laminar</option>
                                <option {{($usr->defect == "Rolled in Trim") ? "selected" : ""}} value="Rolled in Trim">Rolled in Trim</option>
                                <option {{($usr->defect == "Cold Weld") ? "selected" : ""}} value="Cold Weld">Cold Weld</option>
                                <option {{($usr->defect == "Low Squeeze") ? "selected" : ""}} value="Low Squeeze">Low Squeeze</option>
                                <option {{($usr->defect == "Entrapped Material") ? "selected" : ""}} value="Entrapped Material">Entrapped Material</option>
                                <option {{($usr->defect == "Black Edges") ? "selected" : ""}} value="Black Edges">Black Edges</option>
                                <option {{($usr->defect == "High ID Trim") ? "selected" : ""}} value="High ID Trim">High ID Trim</option>
                                <option {{($usr->defect == "Offset Edges") ? "selected" : ""}} value="Offset Edges">Offset Edges</option>
                                <option {{($usr->defect == "NAD" ? "selected" : "")}} value="NAD">NAD</option>
                                <option {{($usr->defect == "Miscellaneous" ? "selected" : "")}} value="Miscellaneous">Miscellaneous</option>
                                <option {{($usr->defect == "Damaged Edge" ? "selected" : "")}} value="Damaged Edge">Damaged Edge</option>
                            </select>
                        </div>

                    <div class="form-group m-1 text-center">
                        <label style="font-weight: bold;font-size:16px;" for="location">Location</label>
                        <select name="location">
                            <option {{($usr->location == "Finishing") ? "selected" : ""}} value="Finishing">Finishing</option>
                            <option {{($usr->location == "Mill") ? "selected" : ""}} value="Mill">Mill</option>
                        </select>
                    </div>

                    <div class="form-group m-1 text-center">
                        <label style="font-weight: bold;font-size:16px;" for="side_of_weld">Side Of Weld</label>
                        <select name="side_of_weld">
                            <option {{($usr->side_of_weld == "NA") ? "selected" : ""}} value="NA">NA</option>
                            <option {{($usr->side_of_weld == "N") ? "selected" : ""}} value="N">N</option>
                            <option {{($usr->side_of_weld == "S") ? "selected" : ""}} value="S">S</option>
                        </select>
                    </div>

                        <div class="form-group m-1 mb-4">
                            <label for="comments">Comments</label>
                            <textarea name="comments" class="form-control">{{$usr->comments}}</textarea>
                        </div>

                            <button type="submit" class="btn btn-primary mt-5">Update</button>
                        </div>
                </form>
    </div>
@endsection
@section('functionalScripts')
    <script>
        const fileInput = document.getElementById("macroImage");
        window.addEventListener('paste', e => {
            fileInput.files = e.clipboardData.files;
        });

    </script>


@endsection
