<!DOCTYPE html>
<html ng-app="ui.hotelloca">
<head>
  <title>Hotelloca</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link media="all" type="text/css" rel="stylesheet" href="{{App::make('url')->to('/')}}/assets/css/bootstrap.min.css">
  <link media="all" type="text/css" rel="stylesheet" href="{{App::make('url')->to('/')}}/assets/css/custom.css">
  <link href="{{ App::make('url')->to('/') }}/assets/css/foundation.min.css" rel="stylesheet">  
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
  <script src="{{App::make('url')->to('/')}}/assets/js/vendor/modernizr.js"></script>
</head>
<body>

  <div class="fixed">
    <nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name">
          <h1><a href="#">My Site</a></h1>
        </li>
         <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
      </ul>

      <section class="top-bar-section">
        <!-- Right Nav Section -->
        <ul class="right">
          <li class="active"><a href="#">Right Button Active</a></li>
          <li class="has-dropdown">
            <a href="#">Right Button Dropdown</a>
            <ul class="dropdown">
              <li><a href="#">First link in dropdown</a></li>
              <li class="active"><a href="#">Active link in dropdown</a></li>
            </ul>
          </li>
        </ul>

        <!-- Left Nav Section -->
        <ul class="left">
          <li><a href="#">Left Nav Button</a></li>
        </ul>
      </section>
    </nav>
  </div>

  <div class="container" style="padding-top:10px;">
    @yield('content')
  </div><!-- /.container -->

<script src="{{App::make('url')->to('/')}}/assets/js/vendor/jquery.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/vendor/fastclick.js"></script>
</body>
<script src="{{App::make('url')->to('/')}}/assets/js/foundation.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/angular.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/mm-foundation-tpls-0.7.0.min.js"></script>
<script>
  $(document).foundation();
</script>
@yield('script')
</html>
