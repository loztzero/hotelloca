@extends('layouts.general-travel-layout')

@section('bigSlideshow')
@include('layouts.general-travel-slideshow')
@endsection

@section('content')

<!-- Popuplar Destinations -->
<div class="destinations"> <!-- destinations section -->
    <div class="container">
        <h2>Popular Destinations</h2>
        <div class="row image-box style1 add-clearfix">
            <div class="col-sms-6 col-sm-6 col-md-3">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInDown" data-animation-duration="1">
                        <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="{{ url('assets/images/main-270/atlantis-320.jpg') }}" alt="" width="270" height="160" /></a>
                    </figure>
                    <div class="details">
                        <span class="price"><small>FROM</small>$490</span>
                        <h4 class="box-title"><a href="hotel-detailed.html">Atlantis - The Palm<small>Paris</small></a></h4>
                    </div>
                </article>
            </div>
            <div class="col-sms-6 col-sm-6 col-md-3">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInDown" data-animation-duration="1" data-animation-delay="0.3">
                        <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="{{ url('assets/images/main-270/hilton-london-paddington-hotels-united-kingdom-london-westminster-320.jpg') }}" alt="" width="270" height="160" /></a>
                    </figure>
                    <div class="details">
                        <span class="price"><small>FROM</small>$170</span>
                        <h4 class="box-title"><a href="hotel-detailed.html">Hilton Hotel<small>LONDON</small></a></h4>
                    </div>
                </article>
            </div>
            <div class="col-sms-6 col-sm-6 col-md-3">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInDown" data-animation-duration="1" data-animation-delay="0.6">
                        <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="{{ url('assets/images/main-270/mgm-grand-hotel-mgm-grand-320.jpg') }}" alt="" width="270" height="160" /></a>
                    </figure>
                    <div class="details">
                        <span class="price"><small>FROM</small>$130</span>
                        <h4 class="box-title"><a href="hotel-detailed.html">MGM Grand<small>LAS VEGAS</small></a></h4>
                    </div>
                </article>
            </div>
            <div class="col-sms-6 col-sm-6 col-md-3">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInDown" data-animation-duration="1" data-animation-delay="0.9">
                        <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="{{ url('assets/images/main-270/Crown-Logo-320.jpg') }}" alt="" width="270" height="160" /></a>
                    </figure>
                    <div class="details">
                        <span class="price"><small>FROM</small>$290</span>
                        <h4 class="box-title"><a href="hotel-detailed.html">Crown Casino<small>ASUTRALIA</small></a></h4>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>

<!-- Honeymoon -->
<div class="honeymoon section global-map-area promo-box parallax" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="col-sm-6 content-section description pull-right">
            <h1 class="title">Find out what the best destinations in the World are as awarded by millions of real travelers.</h1>
            <p>
                Book the best sightseeing, day tours, night tours, and a wide range of other most interesting tours in Paris and France.
            </p>
            <div class="row places image-box style9">
                <div class="col-sms-4 col-sm-4">
                    <article class="box">
                        <figure>
                            <a href="hotel-list-view.html" title="" class="hover-effect yellow middle-block animated" data-animation-type="fadeInUp" data-animation-duration="1">
                                <img src="{{ url('assets/images/main-370/paris-370.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="details">
                            <h4 class="box-title">Paris<small>(990 PLACES)</small></h4>
                            <a href="hotel-list-view.html" title="" class="button">SEE ALL</a>
                        </div>
                    </article>
                </div>
                <div class="col-sms-4 col-sm-4">
                    <article class="box">
                        <figure>
                            <a href="hotel-list-view.html" title="" class="hover-effect yellow middle-block animated" data-animation-type="fadeInUp" data-animation-duration="1" data-animation-delay="0.4"><img src="{{ url('assets/images/main-370/greece-370.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="details">
                            <h4 class="box-title">Greece<small>(990 PLACES)</small></h4>
                            <a href="hotel-list-view.html" title="" class="button">SEE ALL</a>
                        </div>
                    </article>
                </div>
                <div class="col-sms-4 col-sm-4">
                    <article class="box">
                        <figure>
                            <a href="hotel-list-view.html" title="" class="hover-effect yellow middle-block animated" data-animation-type="fadeInUp" data-animation-duration="1" data-animation-delay="0.8"><img src="{{ url('assets/images/main-370/aussie-370.jpg') }}" alt="" /></a>
                        </figure>
                        <div class="details">
                            <h4 class="box-title">Australia<small>(990 PLACES)</small></h4>
                            <a href="hotel-list-view.html" title="" class="button">SEE ALL</a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <div class="col-sm-6 image-container no-margin">
            <img src="{{ url('assets/images/524.jpg') }}" alt="" class="animated" data-animation-type="fadeInUp" data-animation-duration="2">
        </div>
    </div>
</div>

<!-- Did you Know? section -->
<div class="offers section">
    <div class="container">
        <h1 class="text-center">Did you know?</h1>
        <p class="col-xs-9 center-block no-float text-center">
            We offer our customers a comprehensive range of services with leading technologies and products
        </p>
        <div class="row image-box style2">
            <div class="col-md-6">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInLeft" data-animation-duration="1">
                        <a href="#" title=""><img src="{{ url('assets/images/mini/carhire-270.jpg') }}" alt="" width="270" height="192" /></a>
                    </figure>
                    <div class="details">
                        <h4>Hire Cars</h4>
                        <p>
                            Find the best rental prices on luxury, economy, and family rental cars with
                            FREE amendments in over 46000 locations worldwide, reserve online today!
                        </p>
                        <a href="#" title="" class="button">SEE ALL</a>
                    </div>
                </article>
            </div>
            <div class="col-md-6">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInLeft" data-animation-duration="1" data-animation-delay="0.4">
                        <a href="#" title=""><img src="{{ url('assets/images/mini/royal-caribbean-270.jpg') }}" alt="" width="270" height="192" /></a>
                    </figure>
                    <div class="details">
                        <h4>Cruise Deals</h4>
                        <p>
                            Take a look at the great deals available on our cruise holidays - some of our offers are only here for a limited time so book your next holiday today!
                        </p>
                        <a href="#" title="" class="button">SEE ALL</a>
                    </div>
                </article>
            </div>
            <div class="col-md-6">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInLeft" data-animation-duration="1">
                        <a href="#" title=""><img src="{{ url('assets/images/mini/travel_tips-270.jpg') }}" alt="" width="270" height="192" /></a>
                    </figure>
                    <div class="details">
                        <h4>Things To Do</h4>
                        <p>
                            These travel guides aim to give you the best and most up to date information on the major travel destinations around the world.
                        </p>
                        <a href="#" title="" class="button">SEE ALL</a>
                    </div>
                </article>
            </div>
            <div class="col-md-6">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInLeft" data-animation-duration="1" data-animation-delay="0.4">
                        <a href="#" title=""><img src="{{ url('assets/images/mini/fly-in comfort-270.jpg') }}" alt="" width="270" height="192" /></a>
                    </figure>
                    <div class="details">
                        <h4>Fly in Comfort</h4>
                        <p>
                            Make your flight as comfortable and as conducive to sleep as you can. Listed below are some tips on how to put the comfort and the zzzzzzzz to your air travel!
                        </p>
                        <a href="#" title="" class="button">SEE ALL</a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
<!-- Features section -->
<div class="features section global-map-area parallax" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row image-box style7">
            <div class="col-sms-6 col-sm-6 col-md-3">
                <article class="box">
                    <figure class="middle-block">
                        <img src="{{ url('assets/images/tips/best-price-300.jpg') }}" alt="" class="middle-item" />
                        <span class="opacity-wrapper"></span>
                    </figure>
                    <div class="details">
                        <h4><a href="#">Best Price Guarantee</a></h4>
                        <p>
                            With Hotelloca.com, you are guaranteed the best price for your hotel booking: if you find cheaper elsewhere, we will give you this price minus 10%.
                        </p>
                    </div>
                </article>
            </div>
            <div class="col-sms-6 col-sm-6 col-md-3">
                 <article class="box">
                    <figure class="middle-block">
                        <img src="{{ url('assets/images/tips/insurance-300.jpg') }}" alt="" class="middle-item" />
                        <span class="opacity-wrapper"></span>
                    </figure>
                    <div class="details">
                        <h4><a href="#">Travel Insurance</a></h4>
                        <p>
                            We have a large panel of specialist travel insurance companies available. We can search the travel insurance market to find just the right travel insurance cover you need for your holiday or business trip and with cover available for thousands of medical conditions we're confident we'll be able to find you a great deal on your travel insurance.
                        </p>
                    </div>
                </article>
            </div>
            <div class="col-sms-6 col-sm-6 col-md-3">
                 <article class="box">
                    <figure class="middle-block">
                        <img src="{{ url('assets/images/tips/why-us-300.jpg') }}" alt="" class="middle-item" />
                        <span class="opacity-wrapper"></span>
                    </figure>
                    <div class="details">
                        <h4><a href="#">Why Chose Us</a></h4>
                        <p>
                            Our happy team are here to take care of every need, from the second you contact us to when you return
                        </p>
                    </div>
                </article>
            </div>
            <div class="col-sms-6 col-sm-6 col-md-3">
                 <article class="box">
                    <figure class="middle-block">
                        <img src="{{ url('assets/images/tips/help-300.jpg') }}" alt="" class="middle-item" />
                        <span class="opacity-wrapper"></span>
                    </figure>
                    <div class="details">
                        <h4><a href="#">Need Help?</a></h4>
                        <p>
                            Feel free to ask us with any questions
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function () {

});
</script>
@endsection
