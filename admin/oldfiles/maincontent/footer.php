 <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            Copyright © 
                            <script>var d = new Date();
                                    var n = d.getFullYear();
                                    document.write(n);                                 
                            </script> Logileap. All rights reserved. Dashboard by <a href="https://logileap.com" target="_blank">Logileap</a>.
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.1/sweetalert.min.js"></script>
    <!-- jquery 3.3.1 -->
    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="./assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="./assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="./assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="./assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="./assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="./assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="./assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="./assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="./assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="./assets/libs/js/dashboard-ecommerce.js"></script> 
    <!-- custom.js-->
    <script type="text/javascript" src="anotherjsfile.js"></script>
    <script type="text/javascript" src="allfunction.js" /></script>
    <script src="./assets/libs/js/qrcode.js" type="text/javascript" ></script>
    <script src="assets/libs/js/qrcode.min.js" type="text/javascript" charset="utf-8"></script>
    <!-- <script src="./assets/libs/js/qrious.js" type="text/javascript" ></script> -->
    <!--<script type="text/javascript" src="./../obfuscator.js"></script> -->   
    <script type="text/javascript" src="custom.js"></script>
    <script>
    //$('#form').parsley();
    </script>
    <script>      
    
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            //getDataSurvey();
            getData();
            getDataBarChart(count);
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
</body>
 
</html>
