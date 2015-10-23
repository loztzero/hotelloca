<!DOCTYPE html>
<html ng-app="ui.hotelloca">
<head>
  <title>Hotelloca</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link media="all" type="text/css" rel="stylesheet" href="{{App::make('url')->to('/')}}/assets/css/foundation-icons/foundation-icons.css">
  <link href="{{ App::make('url')->to('/') }}/assets/css/foundation.min.css" rel="stylesheet">  
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
  <link href="{{ App::make('url')->to('/') }}/assets/css/jquery.bxslider.css" rel="stylesheet" /> 
  <link href="{{ App::make('url')->to('/') }}/assets/css/foundation-datepicker.min.css" rel="stylesheet" />
  <link href="{{ App::make('url')->to('/') }}/assets/css/custom.css" rel="stylesheet"> 
<!-- bxSlider CSS file -->
  <script src="{{App::make('url')->to('/')}}/assets/js/vendor/modernizr.js"></script>

</head>
<body>

  <div class="off-canvas-wrap" data-offcanvas>
    <div class="inner-wrap">
      <nav class="tab-bar show-for-small">
        <section class="tab-bar-section">
          <img src="{{App::make('url')->to('/')}}/assets/img/logo.gif" width="100px" style="position:relative;padding-left:10px;padding-top:0px;margin-left:30px;" />
        </section>
        <section class="left-small">
          <a class="left-off-canvas-toggle menu-icon" href="#">
            <span></span>
          </a>
        </section>
      </nav>


      <div class="sticky">
          <nav class="top-bar hide-for-small" data-topbar role="navigation">
            <ul class="title-area">
              <li class="name">
                <a href="#">
                  <img src="{{App::make('url')->to('/')}}/assets/img/logo.gif" width="100px" style="position:relative;padding-left:10px;padding-top:5px;" />
                </a>
              </li>
            </ul>


            <section class="top-bar-section">
              <!-- Right Nav Section -->
              <ul class="right">
                <li><a href="{{url('/')}}"><i class="fi-home"></i>&nbsp; Hotel</a></li>
                <li><a href="{{url('main/company-profile')}}"><i class="fi-info"></i>&nbsp; My Profile</a></li>
                <li><a href="{{url('main/contact-us')}}"><i class="fi-power"></i>&nbsp; Logout</a></li>
              </ul>
            </section>
          </nav>
      </div>

      <aside class="left-off-canvas-menu">
        <ul class="off-canvas-list">
          <li><a href="{{url('/')}}"><i class="fi-home"></i>&nbsp; Home</a></li>
          <li><a href="{{url('main/company-profile')}}"><i class="fi-info"></i>&nbsp; Company Profile</a></li>
          <li><a href="{{url('main/services')}}"><i class="fi-wrench"></i>&nbsp; Services</a></li>
          <li><a href="{{url('main/term-and-condition')}}"><i class="fi-page"></i>&nbsp; Term And Condition</a></li>
          <li><a href="{{url('main/contact-us')}}"><i class="fi-mail"></i>&nbsp; Contact Us</a></li>
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

  <script src="{{App::make('url')->to('/')}}/assets/js/vendor/jquery.js"></script>
  <script src="{{App::make('url')->to('/')}}/assets/js/vendor/fastclick.js"></script>
  <script src="{{App::make('url')->to('/')}}/assets/js/moment.js"></script>
</body>
<script src="{{App::make('url')->to('/')}}/assets/js/foundation.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/foundation/foundation.tooltip.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/foundation-datepicker.min.js"></script>
<script src="{{App::make('url')->to('/')}}/assets/js/angular.min.js"></script>
<script>
$(document).foundation();
</script>
@yield('script')
</html>
