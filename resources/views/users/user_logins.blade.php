@extends('layouts.app')

@section('pageTitle', 'Login Activity')
@section('pageName', 'Login Activity')
@section('content')
<style>
    table.table.table-striped td {
        padding: 2px 2px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>User</td>
                    <td>IP</td>
                    <td>DateTime</td>
                    <td>Day</td>
                </tr>
            </thead>
            <tbody>
                @foreach($activity as $logonActivity)
                <tr>
                    <td>{{$logonActivity->name}}</td>
                    <td>{{$logonActivity->ip_address}}</td>
                    <td>{{$logonActivity->created_at}}</td>
                    <td>{{date('D', strtotime($logonActivity->created_at))}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        </div>
    </div>
    @endsection
    @section('functionalScripts')

    @endsection
