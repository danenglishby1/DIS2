@extends('layouts.app')

@section('pageTitle', 'MoC Home')
@section('pageName', 'MoC Home')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/libraries/date-range-picker/daterangepicker.css')}}"/>
    <link href="{{ asset('/public/libraries/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

@endsection
@section('content')

    @php
        $allowableUsers = [4, 5, 31];
    @endphp
    <div class="simpleflex">
        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('moc.index')}}">
                <h4 class="text-center mt-2">MoC Management</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('moc.create')}}">
                <h4 class="text-center mt-2">Create New MoC</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('moc-user-action.index')}}">
                <h4 class="text-center mt-2">MoC Actions ({{$noOfActions}})</h4>
            </a>
        </div>

        @if(in_array($userId, $allowableUsers))
        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('moc-department.index')}}">
                <h4 class="text-center mt-2">Manage Departments</h4>
            </a>
        </div>


        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('moc-control.index')}}">
                <h4 class="text-center mt-2">Manage Controls</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('moc-area-relation.index')}}">
                <h4 class="text-center mt-2">Manage Area Relations</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('moc-department-authoriser.index')}}">
                <h4 class="text-center mt-2">Manage Department Authorisers</h4>
            </a>
        </div>
        @endif

    </div>
    <div style=" text-align: center;width: 140px; margin: 2em auto; font-size: 16px;">
            <a class="flex-text-button-fill" style="background: #95e2ff" href="{{asset('public/images/moc-flowchart.png')}}" target="_blank">Help/Guidance</a>
    </div>

@endsection
@section('functionalScripts')


@endsection
