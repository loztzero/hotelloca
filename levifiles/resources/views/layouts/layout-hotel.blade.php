<!DOCTYPE html>
<html ng-app="ui.hotelloca">
<head>
  <title>Hotelloca</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link media="all" type="text/css" rel="stylesheet" href="{{App::make('url')->to('/') }}/assets/css/foundation-icons/foundation-icons.css">
  <link href="{{ App::make('url')->to('/') }}/assets/css/foundation.min.css" rel="stylesheet">  
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
  <link href="{{ App::make('url')->to('/') }}/assets/css/jquery.bxslider.css" rel="stylesheet" /> 
  <link href="{{ App::make('url')->to('/') }}/assets/css/foundation-datepicker.min.css" rel="stylesheet" />
  <link href="{{ App::make('url')->to('/') }}/assets/css/lightbox.min.css" rel="stylesheet" />
  <link href="{{ App::make('url')->to('/') }}/assets/css/sweetalert.css" rel="stylesheet"> 
  <link href="{{ App::make('url')->to('/') }}/assets/css/custom.css" rel="stylesheet"> 
<!-- bxSlider CSS file -->
  <script src="{{App::make('url')->to('/') }}/assets/js/vendor/modernizr.js"></script>

</head>
<body>

  <div class="off-canvas-wrap" data-offcanvas>
    <div class="inner-wrap">
      <nav class="tab-bar show-for-small">
        <section class="tab-bar-section">
          <img src="{{App::make('url')->to('/') }}/assets/img/logo.gif" width="100px" style="position:relative;padding-left:10px;padding-top:0px;margin-left:30px;" />
        </section>
        <section class="left-small">
          <a class="left-off-canvas-toggle menu-icon" href="#">
            <span></span>
          </a>
        </section>
      </nav>


      <style>
        .sticky nav {height : 75px;}
      </style>

      <div class="sticky">
          <nav class="top-bar hide-for-small" data-topbar role="navigation">
            <div style="width:1028px;margin:0 auto;">
              <ul class="title-area">
                <li class="name">
                  <a href="#">
                    <img src="{{App::make('url')->to('/') }}/assets/img/logo.gif" width="150px" style="position:relative;padding-left:10px;padding-top:10px;" />
                  </a>
                </li>
              </ul>

              <section class="top-bar-section" style="max-width:1024px;margin:0 auto;margin-top:30px;">
                <!-- Right Nav Section -->
                <ul class="right">
                  <li><a href="{{ url('hotel/profile') }}"><i class="fi-torso-business"></i>&nbsp; Profile Hotel</a></li>
                  <li><a href="{{ url('hotel/room') }}"><i class="fi-home"></i>&nbsp; Rooms</a></li>
                  <li><a href="{{ url('hotel/room-rate') }}"><i class="fi-dollar"></i>&nbsp; Room Rate</a></li>
                  <li><a href="{{ url('hotel/picture') }}"><i class="fi-photo"></i>&nbsp; Pictures</a></li>
                  <li><a href="{{ url('hotel/facility') }}"><i class="fi-plus"></i>&nbsp; Facility</a></li>
                  <li><a href="{{ url('auth/logout') }}"><i class="fi-power"></i>&nbsp; Logout</a></li>
                </ul>
              </section>
            </div>
          </nav>
      </div>

      <aside class="left-off-canvas-menu">
        <ul class="off-canvas-list">
          <li><a href="{{ url('hotel/profile') }}"><i class="fi-torso-business"></i>&nbsp; Profile Hotel</a></li>
          <li><a href="{{ url('hotel/room') }}"><i class="fi-home"></i>&nbsp; Rooms</a></li>
          <li><a href="{{ url('hotel/room-rate') }}"><i class="fi-dollar"></i>&nbsp; room Rate</a></li>
          <li><a href="{{ url('hotel/picture') }}"><i class="fi-photo"></i>&nbsp; Pictures</a></li>
          <li><a href="{{ url('hotel/facility') }}"><i class="fi-plus"></i>&nbsp; Facility</a></li>
          <li><a href="{{ url('auth/logout') }}"><i class="fi-power"></i>&nbsp; Logout</a></li>
        </ul>
      </aside>

      <section class="main-section">
        <content class="columns medium-12 large-12">
          <div style="min-height: 530px;margin-top:10px;">
            @yield('content')
          </div>
          <div style="clear:both"></div>
        </content>
      </section>
      <a class="exit-off-canvas"></a>
    </div>
  </div>   

  <footer class="footer">
    <div class="row full-width">
      <div class="small-12 medium-3 large-4 columns">
        <i class="fi-laptop"></i>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum maiores alias ea sunt facilis impedit fuga dignissimos illo quaerat iure in nobis id quos, eaque nostrum! Unde, voluptates suscipit repudiandae!</p>
      </div>
      <div class="small-12 medium-3 large-4 columns">
        <i class="fi-html5"></i>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit impedit consequuntur at! Amet sed itaque nostrum, distinctio eveniet odio, id ipsam fuga quam minima cumque nobis veniam voluptates deserunt!</p>
      </div>
      <div class="small-6 medium-3 large-2 columns">
        <h4>Work With Me</h4>
        <ul class="footer-links">
          <li><a href="#">What I Do</a></li>
          <li><a href="#">Pricing</a></li>
          <li><a href="#">Events</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">FAQ's</a></li>
        <ul>
      </div>
      <div class="small-6 medium-3 large-2 columns">
        <h4>Follow Me</h4>
        <ul class="footer-links">
          <li><a href="#">GitHub</a></li>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Instagram</a></li>
          <li><a href="#">Dribbble</a></li>
        <ul>
      </div>
    </div>
  </footer> 
  {{-- <div class="container" style="padding-top:10px;">
    @yield('content')
  </div> --}}<!-- /.container -->

  <script src="{{App::make('url')->to('/') }}/assets/js/vendor/jquery.js"></script>
  <script src="{{App::make('url')->to('/') }}/assets/js/vendor/fastclick.js"></script>
  <script src="{{App::make('url')->to('/') }}/assets/js/foundation-datepicker.min.js"></script>
  <script src="{{App::make('url')->to('/') }}/assets/js/lightbox.min.js"></script>
  <script src="{{App::make('url')->to('/') }}/assets/js/sweetalert.min.js"></script>
</body>
<script src="{{App::make('url')->to('/') }}/assets/js/foundation.min.js"></script>
<script src="{{App::make('url')->to('/') }}/assets/js/angular.min.js"></script>
<script>
$(document).foundation();
</script>
@yield('script')
</html>
