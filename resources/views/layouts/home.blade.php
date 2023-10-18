<!doctype html>
<html lang="en">

<head>

    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--====== Title ======-->
    <title>@yield('page-title') - {{ setting('app_name') }}</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ url('assets/frontend/images/favicon.png') }}" type="image/png">

    <!--====== Slick css ======-->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/slick.css') }}">

    <!--====== Animate css ======-->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/animate.css') }}">

    <!--====== Nice Select css ======-->
    <!-- <link rel="stylesheet" href="{{ url('assets/frontend/css/nice-select.css') }}"> -->

    <!--====== Nice Number css ======-->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/jquery.nice-number.min.css') }}">

    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/magnific-popup.css') }}">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/bootstrap.min.css') }}">

    <!--====== Fontawesome css ======-->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/font-awesome.min.css') }}">

    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/default.css') }}">

    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/style.css') }}">

    <!--====== Responsive css ======-->
    <link rel="stylesheet" href="{{ url('assets/frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link media="all" type="text/css" rel="stylesheet" href="{{ url('assets/css/spinner.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <!--====== PRELOADER PART START ======-->

    <!-- <div class="preloader">
        <div class="loader rubix-cube">
            <div class="layer layer-1"></div>
            <div class="layer layer-2"></div>
            <div class="layer layer-3 color-1"></div>
            <div class="layer layer-4"></div>
            <div class="layer layer-5"></div>
            <div class="layer layer-6"></div>
            <div class="layer layer-7"></div>
            <div class="layer layer-8"></div>
        </div>
    </div> -->

    <!--====== PRELOADER PART START ======-->

    <!--====== HEADER PART START ======-->

    <header id="header-part">

        <div class="header-top d-none d-lg-block" style="max-height: 62px;">

            <div class="">
                <div class="row">
                    <div class="col-lg-4">
                        <a href="{{route('home')}}">
                            <img src="{{ url('assets/img/projectLogo.png') }}" width="10%" height="10%" class="logo" alt="{{ setting('app_name')}}" style="width: 7rem;margin-top: -2rem;">
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <div class="header-contact text-lg-left text-center vertical-align: middle;">
                            <ul>
                                <!-- <li><img src="{{ url('assets/frontend/images/all-icon/map.png') }}" alt="icon"><span></span></li> -->
                                <!-- <li><img src="{{ url('assets/frontend/images/all-icon/email.png') }}" alt="icon"><span>hello@chgroup.in</span></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                    <div class="header-opening-time text-lg-right text-center mr-2 mt-1">
                    @if(auth()->user())
                   <p> Opening Hours : Monday to Saturay - 8 Am to 5 Pm</p> 
                                    @else
                         <a data-animation="fadeInUp" data-delay="1.9s" class="btn btn-sm" style="background-color:#ffc600 ; color:black " href="/login">Login</a>
                        @endif
                    </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- header top -->


        <div class="navigation">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item">
                                        <a class="active" href="{{route('home')}}">Home</a>
                                        <!-- <ul class="sub-menu">
                                            <li><a class="active" href="">Home 01</a></li>
                                            <li><a href="index-3.html">Home 02</a></li>
                                            <li><a href="index-4.html">Home 03</a></li>
                                        </ul> -->
                                    </li>
                                    <li class="nav-item">
                                        <a href="about.html">About us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('available.courses')}}">Courses</a>
                                        <ul class="sub-menu">
                                            <li><a href="courses.html">Courses</a></li>
                                            <li><a href="courses-singel.html">Course Singel</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="events.html">Events</a>
                                        <ul class="sub-menu">
                                            <li><a href="events.html">Events</a></li>
                                            <li><a href="events-singel.html">Event Singel</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="teachers.html">Our teachers</a>
                                        <ul class="sub-menu">
                                            <li><a href="teachers.html">teachers</a></li>
                                            <li><a href="teachers-singel.html">teacher Singel</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="contact.html">Contact</a>
                                        <ul class="sub-menu">
                                            <li><a href="contact.html">Contact Us</a></li>
                                            <li><a href="contact-2.html">Contact Us 2</a></li>
                                        </ul>
                                    </li>
                                    @if(auth()->user())
                                    <li class="nav-item float-right">
                                        <a class="active" href="#">{{auth()->user()->first_name}}</a>
                                        <ul class="sub-menu">
                                            <li><a class="active" href="{{route('user.myaccount')}}">View Profile</a></li>
                                            <li><a class="active" href="{{route('user.mycourse')}}">My Course</a></li>
                                            <li><a class="active" href="{{route('user.paymentHistory')}}">Payment History</a></li>
                                            <li><a href="{{route('auth.logout')}}">Logout</a></li>
                                        </ul>
                                    </li>
                                   
                                    
                                    @endif
                            </div>
                            </ul>
                        </nav> <!-- nav -->
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                        <!-- right icon -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div>

    </header>
    <section id="loading">
        <div id="loading-content"></div>
    </section>
    <!--====== HEADER PART ENDS ======-->

    <!--====== SEARCH BOX PART START ======-->

    <div class="search-box">
        <div class="serach-form">
            <div class="closebtn">
                <span></span>
                <span></span>
            </div>
            <form action="#">
                <input type="text" placeholder="Search by keyword">
                <button><i class="fa fa-search"></i></button>
            </form>
        </div> <!-- serach form -->
    </div>

    <!--====== SEARCH BOX PART ENDS ======-->
    <div id="notification-logging">

    </div>
    @include('partials.messages')
    @yield('content')

    <!--====== FOOTER PART START ======-->



    <script src="{{ url(mix('assets/js/vendor.js')) }}"></script>
    <script src="{{ url('assets/js/as/app.js') }}"></script>
    <script src="{{ url('assets/js/spinner.js') }}"></script>
    <footer id="footer-part">
        <div class="footer-top pt-40 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-about mt-40">
                            <div class="">
                                <a href="">
                                    <img src="{{ url('assets/img/projectLogo.png') }}" width="10%" height="10%" class="logo" alt="{{ setting('app_name')}}" style="width: 7rem;margin-top: -2rem;">
                                </a>
                            </div>
                            <p>Gravida nibh vel velit auctor aliquetn quibibendum auci elit cons equat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate.</p>
                            <ul class="mt-20">
                                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div> <!-- footer about -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-link mt-40">
                            <div class="footer-title pb-25">
                                <h6>Sitemap</h6>
                            </div>
                            <ul>
                                <li><a href="{{ route('home') }}"><i class="fa fa-angle-right"></i>Home</a></li>
                                <li><a href="about.html"><i class="fa fa-angle-right"></i>About us</a></li>
                                <li><a href="{{ route('home') }}"><i class="fa fa-angle-right"></i>Courses</a></li>
                                <li><a href="blog.html"><i class="fa fa-angle-right"></i>News</a></li>
                                <li><a href="events.html"><i class="fa fa-angle-right"></i>Event</a></li>
                            </ul>
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Gallery</a></li>
                                <li><a href="shop.html"><i class="fa fa-angle-right"></i>Shop</a></li>
                                <li><a href="teachers.html"><i class="fa fa-angle-right"></i>Teachers</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Support</a></li>
                                <li><a href="contact.html"><i class="fa fa-angle-right"></i>Contact</a></li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-link support mt-40">
                            <div class="footer-title pb-25">
                                <h6>Support</h6>
                            </div>
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-right"></i>FAQS</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Privacy</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Policy</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Support</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Documentation</a></li>
                            </ul>
                        </div> <!-- support -->
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-address mt-40">
                            <div class="footer-title pb-25">
                                <h6>Contact Us</h6>
                            </div>
                            <ul>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="cont">
                                        <p>101 & 308, Tulsi Towers Gita Bhawan Square, Indore, MP 452001</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="cont">
                                        <p>094250 61749</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <div class="cont">
                                        <p>hello@chgroup.in</p>
                                    </div>
                                </li>
                            </ul>
                        </div> <!-- footer address -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer top -->

        <div class="footer-copyright pt-10 pb-25">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="copyright text-md-left text-center pt-15">
                            <p><a target="_blank" href="/">ch-EdgeMakers</a> </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="copyright text-md-right text-center pt-15">

                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer copyright -->
    </footer>

    <!--====== FOOTER PART ENDS ======-->

    <!--====== BACK TO TP PART START ======-->

    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!--====== BACK TO TP PART ENDS ======-->








    <!--====== jquery js ======-->
    <script src="{{ url('assets/frontend/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ url('assets/frontend/js/vendor/jquery-1.12.4.min.js') }}"></script>

    <!--====== Bootstrap js ======-->
    <script src="{{ url('assets/frontend/js/bootstrap.min.js') }}"></script>

    <!--====== Slick js ======-->
    <script src="{{ url('assets/frontend/js/slick.min.js') }}"></script>

    <!--====== Magnific Popup js ======-->
    <script src="{{ url('assets/frontend/js/jquery.magnific-popup.min.js') }}"></script>

    <!--====== Counter Up js ======-->
    <script src="{{ url('assets/frontend/js/waypoints.min.js') }}"></script>
    <script src="{{ url('assets/frontend/js/jquery.counterup.min.js') }}"></script>

    <!--====== Nice Select js ======-->
    <!-- <script src="{{ url('assets/frontend/js/jquery.nice-select.min.js') }}"></script> -->

    <!--====== Nice Number js ======-->
    <script src="{{ url('assets/frontend/js/jquery.nice-number.min.js') }}"></script>

    <!--====== Count Down js ======-->
    <script src="{{ url('assets/frontend/js/jquery.countdown.min.js') }}"></script>

    <!--====== Validator js ======-->
    <script src="{{ url('assets/frontend/js/validator.min.js') }}"></script>

    <!--====== Ajax Contact js ======-->
    <script src="{{ url('assets/frontend/js/ajax-contact.js') }}"></script>

    <!--====== Main js ======-->
    <script src="{{ url('assets/frontend/js/main.js') }}"></script>
    <script src="{{ url('assets/js/app.js') }}"></script>

    <!--====== Map js ======-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ url('assets/frontend/js/map-script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>


    <script>
        @if(Session::has('message'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('message') }}");
        @endif

        @if(Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('info'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.info("{{ session('info') }}");
        @endif

        @if(Session::has('warning'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    @yield('scripts')
</body>

</html>