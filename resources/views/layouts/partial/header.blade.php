<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle') - H20 DIS</title>
    <link rel="icon" type="image/png" href="{{ asset('/public/images/favicon.ico') }}">
    <!-- Scripts -->
<!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    {{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
    {{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">--}}
    <link href="{{ asset('/public/libraries/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- Styles -->
    <!-- Custom styles for this template-->
    <link href="{{ asset('/public/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/css/custom.css?v=1.3.6') }}" rel="stylesheet">
    <script src="{{ asset('/public/libraries/sweetalert/swal.js') }}"></script>

    @yield('css')
    @yield('daterangepickerCss')
    @yield('datatablesCss')
    @yield('highChartScripts')
</head>
