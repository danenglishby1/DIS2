@extends('layouts.app')

@section('pageTitle', 'Mill Target')
@section('pageName', 'Mill Targets')
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('target.create')}}" class="btn btn-primary mb-2">Create New</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Target Description</td>
                    <td>User</td>
                    <td>Comments</td>
                    <td>Target Value</td>
                    <td>No or %</td>
                    <td>Created At</td>
                    <td>Updated At</td>
                    <td colspan = 2>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($targets as $target)
                    <tr>
                        <td>{{$target->target_description}}</td>
                        <td>{{$target->user_name}}</td>
                        <td>{{$target->comments}}</td>
                        <td>{{$target->target}}</td>
                        <td>{{$target->number_or_percent}}</td>
                        <td>{{$target->created_at}}</td>
                        <td>{{$target->updated_at}}</td>

                        <td>
{{--                            <a href="{{ route('target.edit',$target->id)}}" class="btn btn-primary">Edit</a>--}}
                        </td>

                        <td>
{{--                            <form method="post" class="delete-form" action="{{ route('target.destroy', $target->id)}}" >--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button class="btn btn-danger" type="submit">Delete</button>--}}
{{--                            </form>--}}
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
            </div>
        </div>
@endsection