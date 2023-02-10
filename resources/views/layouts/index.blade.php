<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <!-- Icon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/app.png') }}" />
        <!-- Page Title -->
        <title>@yield('title')  |  RTBTS</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Google Fonts -->
        <link href="{{ asset('assets/vendor/index/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/index/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/index/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/index/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

        <link href="{{ asset('assets/vendor/index/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/index/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        <!-- <link href="{{ asset('assets/vendor/css/datatables.css')}}" rel="stylesheet" type="text/css"> -->
        <!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}"> -->

        <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}" type="text/css" >

        <!-- CSS Styles -->
        <link href="{{ asset('assets/css/index.css') }}" rel="stylesheet">
    </head>

    <body>
        <!-- Top Bar -->
        <section id="topbar" class="d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-none d-md-flex align-items-center"><span>helpdesk@rtbts.com</span></i>
                    <i class="bi bi-phone d-none d-md-flex align-items-center ms-4"><span>+63 916 310 4268</span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    <i class="d-flex align-items-center ms-4"><span id="live_clock"></span></i>
                    <a href="#" class="text-light twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-light facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-light instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-light linkedin"><i class="bi bi-linkedin"></i></i></a>
                </div>
            </div>
        </section>

        <!-- Header -->
        <header id="header" class="d-flex align-items-center">
            <div class="container d-flex align-items-center justify-content-between">
                <h1 class="logo">
                    <a href="#">
                        <img src="/assets/img/logo/app.png" alt="rtbts_logo">
                        RTBTS
                        <span>.</span>
                    </a>
                </h1>
                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="nav-link scrollto active" href="/#home">Home</a></li>
                        <li><a class="nav-link scrollto" href="/#trip">Trips</a></li>
                        <li><a class="nav-link scrollto" href="/#updates">Updates</a></li>
                        <li><a class="nav-link scrollto" href="/#announce">Announcements</a></li>
                        <li><a class="nav-link scrollto" href="/#contact">Contact</a></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav>
            </div>
        </header>

        @yield('passenger_content')

        <!-- Footer -->
        <footer id="footer">
            <div class="footer-newsletter">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <h4>Submit your Feedback!</h4>
                            <p>Your comments are important for us in helping us provide the best service.</p>
                            <form>
                                <input type="text" name="message" id="message">
                                <input type="button" onclick="Save()" value="Send">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 footer-contact">
                            <h3>RTBTS<span>.</span></h3>
                            <p>
                            Agora Bus Terminal, Gaabucayan St. <br>
                            Cagayan de Oro City, MisOr<br>
                            Philippines 9000<br><br>
                            <strong>Phone:</strong> +63 916 310 4268<br>
                            <strong>Email:</strong> helpdesk@rtbts.com<br>
                            </p>
                        </div>
                        <div class="d-none d-sm-block col-lg-3 col-md-6 footer-links">
                            <h4>Quick Links</h4>
                            <ul>
                            <li><i style="font-size:12px;" class="bi bi-chevron-right"></i> <a href="#home">Home</a></li>
                            <li><i style="font-size:12px;" class="bi bi-chevron-right"></i> <a href="#trip">Trips</a></li>
                            <li><i style="font-size:12px;" class="bi bi-chevron-right"></i> <a href="#updates">Updates</a></li>
                            <li><i style="font-size:12px;" class="bi bi-chevron-right"></i> <a href="#announce">Announcements</a></li>
                            <li><i style="font-size:12px;" class="bi bi-chevron-right"></i> <a href="#contact">Contact</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Our Services</h4>
                            <ul>
                            <li><i style="font-size:12px;" class="bi bi-chevron-right"></i> <a href="#">Terms of Service</a></li>
                            <li><i style="font-size:12px;" class="bi bi-chevron-right"></i> <a href="#">Privacy Policy</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Our Social Networks</h4>
                            <p>Get regular updates on the terminal by subscribing to our social media accounts.</p>
                            <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container py-4">
                <div class="copyright">
                    &copy; Copyright <strong><span>RTBTS</span></strong>. All Rights Reserved
                </div>
            </div>
        </footer>

        <!-- Preloader -->
        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('assets/vendor/index/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/index/jquery-easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/index/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- <script src="http://maps.googleapis.com/maps/api/js"></script> -->

        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/index/purecounter/purecounter.js') }}"></script>
        <script src="{{ asset('assets/vendor/index/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/vendor/index/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/index/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/index/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/index/waypoints/noframework.waypoints.js') }}"></script>
        <script src="{{ asset('assets/vendor/index/php-email-form/validate.js') }}"></script>
        <!-- <script src="{{ asset('assets/vendor/index/js/datatables.js') }}" type="text/javascript" charset="utf8" ></script>  -->
        <script src="{{ asset('assets/js/datatables.js') }}" type="text/javascript" charset="utf8"></script>  
        
        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/index.js') }}"></script>

        <!-- Bootbox scripts -->
        <script src="{{ asset('assets/js/bootbox.min.js')}}"></script>

        <!-- POST & GET Request scripts -->
        <script src="{{ asset('assets/js/core.js') }}"></script>
        <script src="https://momentjs.com/downloads/moment-with-locales.min.js" type="text/javascript" ></script>

        <!-- Page Scripts -->
        <script>
            // Data Table
            $('.dataTable').DataTable({
                searching: false, 
                paging: false, 
                info: false,
                order: [[0, 'desc']],
            });

            function not_available(){
                bootbox.alert({
                    message: "Feature still not available.",
                    centerVertical: true,
                    closeButton: false,
                    size: 'medium',
                }); 
            }

            // Onclick Save Function
            function Save() {
                // Get Values from input fields
                var data = {
                message: $('#message').val(),
                }
                // Add Data to Database
                Controller.Post('/api/feedback/create', data)
                // If success, return message
                .done(function(result) {
                    var dialog = bootbox.dialog({
                    centerVertical: true,
                    closeButton: false,
                    title: 'Sending Information',
                    message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                    });
                    dialog.init(function(){
                        setTimeout(function(){
                            dialog.find('.bootbox-body').html('Feedback Successfully sent! Thank you for your Feedback.');
                            window.location.reload();
                        }, 2000);
                    });
                })
            }

            // Clock Navbar
            var live_clock = document.getElementById('live_clock');
            function time() {
                var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                var d = new Date();
                var date = d.toLocaleDateString("en-US", options);
                var s = d.getSeconds();
                var m = d.getMinutes();
                var h = d.getHours();
                live_clock.textContent = date + " / " +("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
            }
            setInterval(time, 1000);
        </script>

        @yield('scripts')
    </body>
</html>