<!-- Footer -->
<footer class="footer bg-white mt-2">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; 20" DIS {{date('Y')}}</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->
<!-- Scroll to Top Button-->
{{--<a class="scroll-to-top rounded" href="#page-top">--}}
{{--    <i class="fas fa-angle-up"></i>--}}
{{--</a>--}}
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script>
    var rootUrl = "<?php echo $rootUrl ?>";
</script>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('public/libraries/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('public/libraries/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('public/libraries/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('public/js/sb-admin-2.min.js')}}"></script>

<!-- Custom chart builder function for chartjs-->
<script src="{{ asset('public/js/chartJS/chart-builder.js')}}"></script>

@yield('functionalScripts')
@yield('daterangepickerScripts')
@yield('datatablesScripts')
@yield('endScripts')
<div class="ajax-loader" style="display: block">
    <img src="{{ url('public/images/ajax-loader.gif') }}" class="img-responsive"/>
</div>

<script>
    // $(window).load(function() {
    //     $('.ajax-loader').css("display", "none");
    // });
    $(window).on('load', function(){
        $('.ajax-loader').css("display", "none");
    });
    // $(window).on("beforeunload", function() {
    //     $('.ajax-loader').css("display", "block"); // Show spinner loader whilst calling to api
    // });


    //
    // $( document ).ready(function() {
    //     $('.ajax-loader').css("display", "none"); // Show spinner loader whilst calling to api
    // });
    <?php

    ?>


    $('.container-fluid').before('<div class="global-back-button"><button onclick="goBack()" class="btn btn-primary mb-3">&lt; Back</button></div>');

    function goBack() {
        window.history.back();
    }


    // var idleTime = 0;
    // $(document).ready(function () {
    //     //Increment the idle time counter every minute.
    //     var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
    //
    //     //Zero the idle timer on mouse movement.
    //     $(this).mousemove(function (e) {
    //         idleTime = 0;
    //     });
    //     $(this).keypress(function (e) {
    //         idleTime = 0;
    //     });
    // });
    //
    // function timerIncrement() {
    //     var dt = new Date();
    //     var hour = dt.getHours(); //hh 24 hr format
    //
    //     if ((hour >= 18 && hour <= 24) || (hour >= 0 && hour < 6) ) {
    //         idleTime = idleTime + 1;
    //         console.log(hour);
    //         if (idleTime > 60) { // 60 mins
    //             document.getElementById('logout-form').submit();
    //         }
    //     }
    //     // else {
    //     //     console.log("not past 6")
    //     // }
    // }

</script>

</body>

</html>
