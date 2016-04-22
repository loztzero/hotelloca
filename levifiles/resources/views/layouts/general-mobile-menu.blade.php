<a href="#mobile-menu-01" data-toggle="collapse" class="mobile-menu-toggle">
    Mobile Menu Toggle
</a>

<div class="container">
    <h1 class="logo navbar-brand">
        <a href="{{ url('main') }}" title="Travelo - home">
            <img src="{{ url('/') }}/assets/images/logo.png" alt="Hotelloca Logo" />
        </a>
    </h1>

    <nav id="main-menu" role="navigation">
        <ul class="menu">
            <li class="menu-item"><a href="{{ url('main') }}" title="Home">Home</a></li>
            @if(Auth::check() && Auth::user()->role == 'Agent')
            <li class="menu-item"><a href="{{ url('agent/hotel') }}" title="Hotel">Hotel</a></li>
            @endif
        </ul>
    </nav>

</div>

<nav id="mobile-menu-01" class="mobile-menu collapse">
    <ul id="mobile-primary-menu" class="menu">
        <li class="menu-item"><a href="{{ url('/main') }}">Hotel</a></li>
    </ul>

    <ul class="mobile-topnav container">
        @if(Auth::check() && Auth::user()->role == 'Agent')
            <li class="ribbon menu-color-skin">
                <a href="#">MY ACCOUNT</a>
                <ul class="menu mini">
                    <li {{ Request::segment('2') == 'profile' ? 'class=active' : '' }}>
                        <a href="{{ url('agent/profile') }}" title="Profile">Profile</a>
                    </li>
                    <li {{ Request::segment('2') == 'hotel' ? 'class=active' : '' }} >
                        <a href="{{ url('agent/hotel') }}" title="Hotel">Hotel</a>
                    </li>
                    <li>
                        <a href="{{ url('auth/logout') }}" title="Logout">Logout</a>
                    </li>
                </ul>
            </li>
        @elseif(Auth::check() && Auth::user()->role == 'Admin')
            <li class="ribbon menu-color-skin">
                <a href="#">MY ACCOUNT</a>
                <ul class="menu mini">
                    <li {{ Request::segment('2') == 'profile' ? 'class=active' : '' }}>
                        <a href="{{ url('admin/profile') }}">Profile</a>
                    </li>
                    <li {{ Request::segment('2') == 'agent' ? 'class=active' : '' }}>
                        <a href="{{url('admin/agent')}}"><i class="fi-home"></i>&nbsp; Agent</a></li>
                    <li><a href="{{url('admin/hotel')}}"><i class="fi-home"></i>&nbsp; Hotel</a></li>
                    <li><a href="{{url('admin/booking')}}"><i class="fi-book"></i>&nbsp; Booking</a></li>
                    <li><a href="{{url('admin/rate')}}"><i class="fi-dollar"></i>&nbsp; Daily Rate</a></li>
                    <li><a href="{{url('auth/logout')}}"><i class="fi-power"></i>&nbsp; Logout</a></li>
                </ul>
            </li>
        @elseif(Auth::check() && Auth::user()->role == 'Hotel')
            <li class="ribbon menu-color-skin">
                <a href="#">MY ACCOUNT</a>
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
                        <a href="{{url('hotel/room')}}"><i class="fi-home"></i>&nbsp; Room</a></li>
                    <li><a href="{{url('hotel/room-rate')}}"><i class="fi-home"></i>&nbsp; Room Rate</a></li>
                    <li><a href="{{url('auth/logout')}}"><i class="fi-power"></i>&nbsp; Logout</a></li>
                </ul>
            </li>
        @else
            <li>
                <a href="#">MY ACCOUNT</a>
            </li>
        @endif

        <li class="ribbon language menu-color-skin">
            <a href="#" data-toggle="collapse">Indonesia</a>
            <ul class="menu mini">
                 <li class="active"><a href="#" title="Indonesia">Indonesia</a></li>
            </ul>
        </li>
        @if(Auth::check())
            <li><a>Welcome, {{ Auth::user()->email }}</a></li>
        @else
            <li><a href="#travelo-login" class="soap-popupbox">LOGIN</a></li>
            <li><a href="#travelo-signup" class="soap-popupbox">SIGNUP</a></li>
        @endif
        <li class="ribbon currency menu-color-skin">
            <a href="#">IDR</a>
            <ul class="menu mini">
                <li class="active"><a href="#" title="IDR">IDR</a></li>
            </ul>
        </li>


    </ul>

</nav>
