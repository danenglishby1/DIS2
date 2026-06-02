@extends('layouts.app')

@section('pageTitle', 'Add MoC Department')
@section('pageName', 'Add MoC Department')

@section('css')

@endsection
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
                <form method="post" id="mocForm" action="{{ route('moc-department.store') }}">
                    @csrf

                    <div class="form-group m-1">
                        <label for="department">Department Name</label>
                        <input type="text" class="form-control" required name="department"/>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2" >Add Department</button>
                </form>
            </div>
            <p class="alert alert-danger mt-4">
                Note: You must link the department to an authoriser after creation for it to become available during MofC creation.
                <br />
                <br />
                Use the Manage Department Authorisers link from the MofC home page to do this.
            </p>

        </div>

    </div>
@endsection

@section('functionalScripts')

@endsection
