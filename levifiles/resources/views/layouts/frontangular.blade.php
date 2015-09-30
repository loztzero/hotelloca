<!DOCTYPE html>
<html ng-app="ui.boardingpassku">
<head>
  <title>Boardingpassku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link media="all" type="text/css" rel="stylesheet" href="{{App::make('url')->to('/')}}/assets/css/bootstrap.min.css">

  <link media="all" type="text/css" rel="stylesheet" href="{{App::make('url')->to('/')}}/assets/css/custom.css">

{{--   <link media="all" type="text/css" rel="stylesheet" href="{{ App::make('url')->to('/') }}/assets/css/bootstrap-theme.min.css"> --}}

   <link href="{{ App::make('url')->to('/') }}/assets/css/roboto.min.css" rel="stylesheet">
  <link href="{{ App::make('url')->to('/') }}/assets/css/ripples.min.css" rel="stylesheet">
  <link href="{{ App::make('url')->to('/') }}/assets/css/material-fullpalette.min.css" rel="stylesheet">

  {{-- <link media="all" type="text/css" rel="stylesheet" href="{{ App::make('url')->to('/') }}/assets/css/sticky-footer-navbar.css"> --}}

  <link media="all" type="text/css" rel="stylesheet" href="{{ App::make('url')->to('/') }}/assets/css/bootstrap-datetimepicker.min.css">
  
  {{-- <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" type="text/css" rel="stylesheet" /> --}}

</head>
<body>

  <nav class="navbar navbar-material-teal-900 navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{App::make('url')->to('/main')}}">
          <img src="{{App::make('url')->to('/assets/img/logo.png')}}" height="33px" >
        </a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        {{-- <ul class="nav navbar-nav">
          <li>
            <a href="{{App::make('url')->to('/main')}}">
              <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
            </a>  
          </li>
        </ul> --}}

        <ul class="nav navbar-nav navbar-right">
          @if ( Auth::check() )
          <li class="visible-lg">
            <a href="{{App::make('url')->to('/user')}}">{{ Auth::user()->email }}
            </a>
          </li>
          <li class="hidden-sm hidden-md hidden-lg">
           <a href="{{App::make('url')->to('/user')}}">Profile</a>
          </li>
          <li class="hidden-sm hidden-md hidden-lg">
           <a href="{{App::make('url')->to('/user/passenger-list')}}">Data Passengers</a>
          </li>
          <li class="hidden-sm hidden-md hidden-lg">
           <a href="{{App::make('url')->to('/user/passenger-list')}}">Data Passengers</a>
          </li>
          {{-- <li class="hidden-sm hidden-md hidden-lg">
            <a href="{{App::make('url')->to('/user/change-password')}}">Change Password</a>
          </li>
          <li class="hidden-sm hidden-md hidden-lg">
            <a href="{{App::make('url')->to('/user/order-history')}}">My Order</a>
          </li> --}}
          <li class="hidden-sm hidden-md hidden-lg">
            <a href="{{App::make('url')->to('/main/logout')}}">Logout</a>
          </li>
          @else
          <li><a href="{{App::make('url')->to('/main/')}}/login">Login</a></li>
          <li><a href="{{App::make('url')->to('/main/')}}/register">Register</a></li>
          @endif
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <div class="container" style="margin-top:70px;">
    @yield('content')
  </div><!-- /.container -->

  <div id="preload">
    <div class="preload-bg" style="position:absolute;left:50%;top:50%;">
      <button class="btn btn-fab btn-fab-mini btn-sm btn-success" id="preload-icon"><i class="mdi-action-autorenew"></i></button>
    </div>
  </div>

</body>
<script src="{{App::make('url')->to('/')}}/assets/js/angular.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/angular-sanitize.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.2.15/angular-locale_id-id.js"></script> -->
<script src="{{App::make('url')->to('/')}}/assets/js/jquery-2.1.4.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/bootstrap.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/moment.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/ui-bootstrap-tpls-0.13.0.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/ripples.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/material.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/galleria-1.4.2.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/themes/classic/galleria.classic.min.js"></script>
@yield('script')
</html>
