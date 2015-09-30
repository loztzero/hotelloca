<!DOCTYPE html>
<html>
<head>
  <title>Boardingpassku</title>
  <link media="all" type="text/css" rel="stylesheet" href="{{App::make('url')->to('/')}}/assets/css/bootstrap.min.css">

  <link media="all" type="text/css" rel="stylesheet" href="{{ App::make('url')->to('/') }}/assets/css/bootstrap-theme.min.css">

  <link media="all" type="text/css" rel="stylesheet" href="{{ App::make('url')->to('/') }}/assets/css/sticky-footer-navbar.css">

  <link media="all" type="text/css" rel="stylesheet" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/d004434a5ff76e7b97c8b07c01f34ca69e635d97/build/css/bootstrap-datetimepicker.css">
  
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="{{ App::make('url')->to('/') }}/assets/css/summernote.css" rel="stylesheet">
<link href="{{ App::make('url')->to('/') }}/assets/css/summernote-bs3.css" rel="stylesheet">

  <style>
  legend {font-size:15px;}
  </style>
</head>
<body>

  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">BoardingPassKu</a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
          <li><a href="{{App::make('url')->to('/')}}/tour-package">Tour Package</a></li>
          <li><a href="{{App::make('url')->to('/')}}/tour-package/tour-detail">Tour Package Detail</a></li>
          <li><a href="{{App::make('url')->to('/')}}/tour-package/input-tour-detail">Tour Package Detail Input</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <div class="container">
    @yield('content')
  </div><!-- /.container -->

</body>
<script src="{{App::make('url')->to('/')}}/assets/js/jquery.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/bootstrap.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/d004434a5ff76e7b97c8b07c01f34ca69e635d97/src/js/bootstrap-datetimepicker.js"></script>
@yield('script')
</html>
