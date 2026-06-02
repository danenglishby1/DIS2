@include('layouts.partial.header')
<body>
<div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            @include('layouts.partial.nav')

            <div class="container-fluid">
                <!-- Page Heading -->
                {{--                <div class="d-sm-flex align-items-center justify-content-between mb-4">--}}
                {{--                    <h1 class="h3 mb-0 text-gray-800">@yield('pageName')</h1>--}}
                {{--                </div>--}}
                @yield('content')
            </div>
        </div>
        @include('layouts.partial.footer')
    </div>

</div>



