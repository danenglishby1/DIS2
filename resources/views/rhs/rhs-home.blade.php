@extends('layouts.app')

@section('pageTitle', 'Home')
@section('pageName', 'RHS')
@section('rhsActiveLink', 'active activeUnderline')
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
            <a class="flex-text-button-fill" href="{{ route('rhs-dashboard')}}">
                <h4 class="text-center mt-2">RHS Dashboard</h4>
            </a>
        </div>


        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('straightness-dashboard')}}">
                <h4 class="text-center mt-2">Straightness Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('straightness-analysis')}}">
                <h4 class="text-center mt-2">Straightness Analysis</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('straightness-reject-rate-by-week')}}">
                <h4 class="text-center mt-2">Straightness Reject Rates</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('furnace-dashboard')}}">

                <h4 class="text-center mt-2">Furnace Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('live-furnace-trace')}}">
                <h4 class="text-center mt-2">Live Furnace Traces</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('furnace-summary')}}">
                <h4 class="text-center mt-2">Furnace Summary</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('furnace-temp-defect-monitor')}}">
                <h4 class="text-center mt-2">Furnace Temp Defect Monitor</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('furnace-temp-defect-dashboard')}}">
                <h4 class="text-center mt-2">Furnace Temp Defect Dashboard</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('rhs-quench-live-feed')}}">
                <h4 class="text-center mt-2">Cooling Live Feed</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('quench-summary')}}">
                <h4 class="text-center mt-2">Cooling Summary</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('rhs-defects')}}">
                <h4 class="text-center mt-2">Defect List</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('shape-compare')}}">
                <h4 class="text-center mt-2">Pipe Shape Comparison</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('manual-measure-analysis')}}">
                <h4 class="text-center mt-2">Manual Measure Analysis</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('rhs-changelog')}}">
                <h4 class="text-center mt-2">ChangeLog Entry</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('rhs-changelog-view')}}">
                <h4 class="text-center mt-2">ChangeLog View</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('straightness-heatmap')}}">
                <h4 class="text-center mt-2">Straightness Position Analysis</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('rhs-furnace-energy-prod-monitor')}}">
                <h4 class="text-center mt-2">Furnace Energy/Production Monitor</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('stretch-factors')}}">
                <h4 class="text-center mt-2">Stretch Factors</h4>
            </a>
        </div>

        <div class="fl1-300">
            <a class="flex-text-button-fill" href="{{ route('stretch-factor-live-calculator')}}">
                <h4 class="text-center mt-2">Stretch Factor Calculator</h4>
            </a>
        </div>

    </div>





@endsection
