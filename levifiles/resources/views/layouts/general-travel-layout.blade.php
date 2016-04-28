<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html ng-app="ui.hotelloca"> <!--<![endif]-->
<head>
    <!-- Page Title -->
    <title>Hotelloca - Online Booking Hotel</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="keywords" content="Hotel, Booking" />
    <meta name="description" content="Hotelloca - Online Booking Hotel ">
    <meta name="author" content="Hotelloca">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Theme Styles -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/animate.min.css">

    <!-- Current Page Styles -->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/components/revolution_slider/css/settings.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/components/revolution_slider/css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/components/jquery.bxslider/jquery.bxslider.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/components/flexslider/flexslider.css" media="screen" />

    <!-- Main Style -->
    <!-- <link id="main-style" rel="stylesheet" href="{{ url('/') }}/assets/css/style.css"> -->
    <link id="main-style" rel="stylesheet" href="{{ url('/') }}/assets/css/style-sea-blue.css">

    <!-- Updated Styles -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/updates.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/custom.css">

    <!-- Responsive Styles -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/responsive.css">

    <link rel="stylesheet" href="{{ url('/') }}/assets/css/sweetalert2.css">

    <!-- CSS for IE -->
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/ie.css" />
    <![endif]-->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script type='text/javascript' src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->

    <style>
        .cust-pop-up-sm {
            display:none;
            width:300px;
            margin:0 auto;
        }

        .normal-lh {
            line-height: 50%;
        }
    </style>

    <!-- Javascript Page Loader -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/pace.min.js" data-pace-options='{ "ajax": false }'></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/page-loading.js"></script>
    <script src="//cdn.ckeditor.com/4.5.7/basic/ckeditor.js"></script>
</head>
<body>
    <div id="page-wrapper">
        <header id="header" class="navbar-static-top">
            <div class="topnav hidden-xs">
                <div class="container">
                    <ul class="quick-menu pull-left">
                        @if(Auth::check() && Auth::user()->role == 'Agent')
                            <li class="ribbon">
                                <a href="#">My Account</a>
                                <ul class="menu mini">
                                    <li {{ Request::segment('2') == 'profile' ? 'class=active' : '' }}>
                                        <a href="{{ url('agent/profile') }}" title="Profile">Profile</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'hotel' ? 'class=active' : '' }} >
                                        <a href="{{ url('agent/hotel') }}" title="Hotel">Hotel</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'booking-history' ? 'class=active' : '' }} >
                                        <a href="{{ url('agent/booking-history') }}" title="My Booking">My Booking</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'confirmation-payment' ? 'class=active' : '' }} >
                                        <a href="{{ url('agent/confirmation-payment') }}" title="Confirmation Payment">Confirmation Payment</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('auth/logout') }}" title="Logout">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Auth::check() && Auth::user()->role == 'Admin')
                            <li class="ribbon">
                                <a href="#">My Account</a>
                                <ul class="menu mini">
                                    <li {{ Request::segment('2') == 'profile' ? 'class=active' : '' }}>
                                        <a href="{{ url('admin/profile') }}">Profile</a>
                                    </li>
                                    <!-- <li {{ Request::segment('2') == 'agent' ? 'class=active' : '' }}>
                                        <a href="{{url('admin/agent')}}"><i class="fi-home"></i> Agent</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'agent-payment-statement' ? 'class=active' : '' }} >
                                        <a href="{{ url('admin/agent-payment-statement') }}" title="Agent Payment Statement">Agent Payment Statement</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'agent-deposit' ? 'class=active' : '' }} >
                                        <a href="{{ url('admin/agent-deposit') }}" title="Agent Deposit">Agent Deposit</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'report' ? 'class=active' : '' }} >
                                        <a href="{{ url('admin/report-booking') }}" title="Report Booking">Report Booking</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'hotel' ? 'class=active' : '' }} >
                                        <a href="{{url('admin/hotel')}}">Hotel</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'agent-booking' ? 'class=active' : '' }} >
                                        <a href="{{url('admin/agent-booking')}}">Agent Booking</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'hotel-vs-user' ? 'class=active' : '' }} >
                                        <a href="{{url('admin/hotel-vs-user')}}">Hotel Vs User</a>
                                    </li> -->
                                    <li {{ Request::segment('2') == 'rate' ? 'class=active' : '' }} >
                                        <a href="{{url('admin/rate')}}">Daily Rate</a>
                                    </li>
                                    <li><a href="{{url('auth/logout')}}">Logout</a></li>
                                </ul>
                            </li>
                            <li class="ribbon">
                                <a href="#">Agent</a>
                                <ul class="menu mini">
                                    <li {{ Request::segment('2') == 'agent' ? 'class=active' : '' }}>
                                        <a href="{{url('admin/agent')}}"><i class="fi-home"></i> Agent Register</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'agent-payment-statement' ? 'class=active' : '' }} >
                                        <a href="{{ url('admin/agent-payment-statement') }}" title="Agent Payment Statement">Agent Payment Statement</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'agent-deposit' ? 'class=active' : '' }} >
                                        <a href="{{ url('admin/agent-deposit') }}" title="Agent Deposit">Agent Deposit</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'report' ? 'class=active' : '' }} >
                                        <a href="{{ url('admin/report-booking') }}" title="Report Booking">Report Booking</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="ribbon">
                                <a href="#">Hotel</a>
                                <ul class="menu mini">
                                    <!-- <li {{ Request::segment('2') == 'hotel' ? 'class=active' : '' }} >
                                        <a href="{{url('admin/hotel')}}">Hotel Register</a>
                                    </li> -->
                                    <li {{ Request::segment('2') == 'hotel-vs-user' ? 'class=active' : '' }} >
                                        <a href="{{url('admin/hotel-vs-user')}}">Hotel Register</a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Auth::check() && Auth::user()->role == 'Hotel')
                            <li class="ribbon">
                                <a href="#">My Account</a>
                                <ul class="menu mini">
                                    <li {{ Request::segment('2') == 'profile' ? 'class=active' : '' }}>
                                        <a href="{{ url('hotel/profile') }}">Profile</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'facility' ? 'class=active' : '' }}>
                                        <a href="{{ url('hotel/facility') }}">Facility</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'picture' ? 'class=active' : '' }}>
                                        <a href="{{ url('hotel/picture') }}">Picture</a>
                                    </li>
                                    <li {{ Request::segment('2') == 'room' ? 'class=active' : '' }}>
                                        <a href="{{ url('hotel/room') }}"><i class="fi-home"></i> Room</a>
                                    </li>
                                    <li><a href="{{ url('hotel/room-rate') }}"><i class="fi-home"></i> Room Rate</a></li>
                                    <li><a href="{{ url('hotel/report-booking') }}"><i class="fi-home"></i> Report Booking</a></li>
                                    <li><a href="{{ url('auth/logout') }}"><i class="fi-power"></i> Logout</a></li>
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ url('auth/login') }}">My Account</a>
                            </li>
                        @endif

                        <li class="ribbon">
                            <a href="#">Indonesia</a>
                            <ul class="menu mini">
                                <li class="active"><a href="#" title="Indonesia">Indonesia</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="quick-menu pull-right">
                        @if(Auth::check())
                            <li><a>Welcome, {{ Auth::user()->email }}</a></li>
                        @else
                            <li><a href="#travelo-login" class="soap-popupbox">LOGIN</a></li>
                            <li><a href="#travelo-signup" class="soap-popupbox">SIGNUP</a></li>
                        @endif
                        <li class="ribbon currency">
                            <a href="#" title="">IDR</a>
                            <ul class="menu mini">
                                <li class="active"><a href="#" title="IDR">IDR</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="main-header">
                <!-- mobile menu -->
                @include('layouts.general-mobile-menu')
                <!-- end mobile menu -->
            </div>

            <!-- signup -->
            @include('layouts.general-travel-signup')
            <!-- end signup -->

            <!-- login -->
            @include('layouts.general-travel-login')
            <!-- end login -->

        </header>

        <!-- title container -->
        @yield('titleContainer')
        <!-- end title container -->

        <!-- slideshow -->
        @yield('bigSlideshow')
        <!-- endslideshow -->

        <!-- content -->
        <section id="content">
            @yield('content')
        </section>
        <!-- content -->

        <!-- footer -->
        @include('layouts.general-travel-footer')
        <!-- end footer -->
    </div>


    <!-- Javascript -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery.noconflict.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/modernizr.2.7.1.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery-ui.1.10.4.min.js"></script>

    <!-- Twitter Bootstrap -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/bootstrap.min.js"></script>

    <!-- load revolution slider scripts -->
    <script type="text/javascript" src="{{ url('/') }}/assets/components/revolution_slider/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/components/revolution_slider/js/jquery.themepunch.revolution.min.js"></script>

    <!-- load BXSlider scripts -->
    <script type="text/javascript" src="{{ url('/') }}/assets/components/jquery.bxslider/jquery.bxslider.min.js"></script>

    <!-- Flex Slider -->
    <script type="text/javascript" src="{{ url('/') }}/assets/components/flexslider/jquery.flexslider.js"></script>

    <!-- parallax -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery.stellar.min.js"></script>

    <!-- parallax -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery.stellar.min.js"></script>

    <!-- waypoint -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/waypoints.min.js"></script>

    <!-- angular -->
    <script src="{{App::make('url')->to('/')}}/assets/js/angular.min.js"></script>

    <script src="{{App::make('url')->to('/')}}/assets/js/angular-sanitize.js"></script>

    <script src="{{App::make('url')->to('/')}}/assets/js/sweetalert2.min.js"></script>

    <!-- load page Javascript -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/theme-scripts.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/scripts.js"></script>



    <script type="text/javascript">
        tjq(document).ready(function() {
            tjq('.revolution-slider').revolution(
            {
                dottedOverlay:"none",
                delay:8000,
                startwidth:1170,
                startheight:646,
                onHoverStop:"on",
                hideThumbs:10,
                fullWidth:"on",
                forceFullWidth:"on",
                navigationType:"none",
                shadow:0,
                spinner:"spinner4",
                hideTimerBar:"on",
            });

            tjq("#price-range").slider({
                range: true,
                min: 0,
                max: 1000,
                values: [ 100, 800 ],
                slide: function( event, ui ) {
                    tjq(".min-price-label").html( "$" + ui.values[ 0 ]);
                    tjq(".max-price-label").html( "$" + ui.values[ 1 ]);
                }
            });
            tjq(".min-price-label").html( "$" + tjq("#price-range").slider( "values", 0 ));
            tjq(".max-price-label").html( "$" + tjq("#price-range").slider( "values", 1 ));

            tjq("#rating").slider({
                range: "min",
                value: 40,
                min: 0,
                max: 50,
                slide: function( event, ui ) {

                }
            });
        });
    </script>

    @yield('script')
</body>
</html>
