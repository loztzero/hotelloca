<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html class=""> <!--<![endif]-->
<head>
    <!-- Page Title -->
    <title>Travelo - Travel, Tour Booking HTML5 Template</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Travelo - Travel, Tour Booking HTML5 Template">
    <meta name="author" content="SoapTheme">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Theme Styles -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,200,300,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/animate.min.css">

    <!-- Main Style -->
    <link id="main-style" rel="stylesheet" href="{{ url('/') }}/assets/css/style-sea-blue.css">

    <!-- Updated Styles -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/updates.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/custom.css">

    <!-- Responsive Styles -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/responsive.css">

    <!-- CSS for IE -->
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/ie.css" />
    <![endif]-->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script type='text/javascript' src="{{ url('/') }}/assets/http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <script type='text/javascript' src="{{ url('/') }}/assets/http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
</head>
<body class="soap-login-page style1 body-blank">
    <div id="page-wrapper" class="wrapper-blank">
        <section id="content">
            <div class="container">
                <div id="main">
                    <h1 class="logo block">
                        <a href="{{ url('/') }}/main" title="Travelo - home">
                            <img src="{{ url('/') }}/assets/images/logo-white.png" alt="Hotelloca.com Logo" style="width:194px;height:70px;" />
                        </a>
                    </h1>
                    <div class="text-center yellow-color box" style="font-size: 4em; font-weight: 300; line-height: 1em;">Welcome back!</div>
                    <p class="light-blue-color block" style="font-size: 1.3333em;">Please login to your account.</p>


                    <div class="col-sm-8 col-md-6 col-lg-5 no-float no-padding center-block">
                        @if (count($errors) > 0)
                            <div class="alert alert-error" style="text-align:left;">
                               @foreach ($errors->all() as $error)
                                Error : {{ $error }}<br>
                                @endforeach
                                <span class="close"></span>
                            </div>
                        @endif
                        <form class="login-form" method="post" action="{{ url('/')}}/auth/login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <input type="text" class="input-text input-large full-width" name="email" placeholder="enter your email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="input-text input-large full-width" name="password" placeholder="enter your password">
                            </div>
                            <button type="submit" class="btn-large full-width sky-blue1">LOGIN TO YOUR ACCOUNT</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer id="footer">
            <div class="footer-wrapper">
                <div class="container">
                    <div class="copyright">
                        <p>&copy; {{ date('Y') }} Hotelloca</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Javascript -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery.noconflict.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/modernizr.2.7.1.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery-ui.1.10.4.min.js"></script>

    <!-- Twitter Bootstrap -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/bootstrap.js"></script>

    <script type="text/javascript">
        var enableChaser = 0;
    </script>
    <!-- parallax -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/jquery.stellar.min.js"></script>

    <!-- waypoint -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/waypoints.min.js"></script>

    <!-- load page Javascript -->
    <script type="text/javascript" src="{{ url('/') }}/assets/js/theme-scripts.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/scripts.js"></script>

</body>
</html>
