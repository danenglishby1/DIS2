@extends('layouts.app')

@section('pageTitle', 'Engineering')
@section('pageName', 'Engineering Home')
@section('engineeringActiveLink', 'active activeUnderline')
@section('content')
    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
        <div class="alert alert-success" role="alert">
{{ session('status') }}
            </div>
@endif

        You are logged in!
    </div>
</div>
</div>
</div> -->
    <!-- Content Row -->


    <div class="simpleflex">
        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('wm-stoppage-analysis-dashboard')}}">
                <h4 class="text-center mt-2">WM Stoppage Analysis Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('cold-finishing-stoppage-analysis-dashboard')}}">
                <h4 class="text-center mt-2">Cold Finishing Stoppage Analysis Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('rhs-stoppage-analysis-dashboard')}}">
                <h4 class="text-center mt-2">RHS Stoppage Analysis Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('rhs-saw-stoppage-analysis-dashboard')}}">
                <h4 class="text-center mt-2">RHS SAW Stoppage Analysis Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('chs-stoppage-analysis-dashboard')}}">
                <h4 class="text-center mt-2">CHS Stoppage Analysis Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('slitter-stoppage-analysis-dashboard')}}">
                <h4 class="text-center mt-2">Slitter Stoppage Analysis Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('hydro-max-end-load')}}">
                <h4 class="text-center mt-2">Hydro High Pressure OR End load</h4>
            </a>
        </div>

    </div>




@endsection
