@extends('layouts.app')

@section('pageTitle', 'Global Settings')
@section('pageName', 'All Global Settings')
@section('content')

        <div class="row">
            <div class="col-sm-12">
                <a href="{{ route('global-settings.create')}}" class="btn btn-primary mb-2">Create New</a>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>Name</td>
                        <td>Value</td>
                        <td>Updated By</td>
                        <td>Updated At</td>
                        <td colspan=2>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gSettings as $row)
                        <tr>
                            <td>{{$row["name"]}}</td>
                            <td>{{$row["value"]}}</td>
                            <td>{{$row["users"]["name"]}}</td>
                            <td>{{$row["updated_at"]}}</td>
                            <td>
                                <a href="{{ route('global-settings.edit',$row["id"])}}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <form method="post" class="delete-form"
                                      action="{{ route('global-settings.destroy', $row["id"])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                </div>
            </div>
        </div>
        @endsection

