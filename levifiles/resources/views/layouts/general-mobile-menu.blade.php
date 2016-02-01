<a href="#mobile-menu-01" data-toggle="collapse" class="mobile-menu-toggle">
    Mobile Menu Toggle
</a>

<div class="container">
    <h1 class="logo navbar-brand">
        <a href="index.html" title="Travelo - home">
            <img src="{{ url('/') }}/assets/images/logo.png" alt="Travelo HTML5 Template" />
        </a>
    </h1>

    <nav id="main-menu" role="navigation">
        <ul class="menu">
            <li class="menu-item"><a href="{{ url('/main') }}">Home</a></li>
            <li class="menu-item"><a href="{{ url('/main/company-profile') }}">Company Profile</a></li>
            <li class="menu-item"><a href="{{ url('/main/services') }}">Service</a></li>
            <li class="menu-item"><a href="{{ url('/main/term-and-condition') }}">Term And Condition</a></li>
            <li class="menu-item"><a href="{{ url('/main/contact-us') }}">Contact Us</a></li>
        </ul>
    </nav>
</div>

<nav id="mobile-menu-01" class="mobile-menu collapse">
    <ul id="mobile-primary-menu" class="menu">
        <li class="menu-item"><a href="{{ url('/main') }}">Home</a></li>
        <li class="menu-item"><a href="{{ url('/main/company-profile') }}">Company Profile</a></li>
        <li class="menu-item"><a href="{{ url('/main/services') }}">Service</a></li>
        <li class="menu-item"><a href="{{ url('/main/term-and-condition') }}">Term And Condition</a></li>
        <li class="menu-item"><a href="{{ url('/main/contact-us') }}">Contact Us</a></li>
    </ul>
    
    <ul class="mobile-topnav container">
        <li><a href="#">MY ACCOUNT</a></li>
        <li class="ribbon language menu-color-skin">
            <a href="#" data-toggle="collapse">Indonesia</a>
            <ul class="menu mini">
                 <li class="active"><a href="#" title="Indonesia">Indonesia</a></li>
            </ul>
        </li>
        <li><a href="#travelo-login" class="soap-popupbox">LOGIN</a></li>
        <li><a href="#travelo-signup" class="soap-popupbox">SIGNUP</a></li>
        <li class="ribbon currency menu-color-skin">
            <a href="#">IDR</a>
            <ul class="menu mini">
                <li class="active"><a href="#" title="IDR">IDR</a></li>
            </ul>
        </li>
    </ul>
    
</nav>