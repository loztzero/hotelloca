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
                        <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="http://placehold.it/270x160" alt="" width="270" height="160" /></a>
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
                        <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="http://placehold.it/270x160" alt="" width="270" height="160" /></a>
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
                        <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="http://placehold.it/270x160" alt="" width="270" height="160" /></a>
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
                        <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="http://placehold.it/270x160" alt="" width="270" height="160" /></a>
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
            <h1 class="title">Popular Destinations for Honeymoon</h1>
            <p>Nunc cursus libero purusac congue arcu cursus utsed vitae pulvinar massa idporta neque purusac Etiam elerisque mi id faucibus iaculis vitae pulvinar.</p>
            <div class="row places image-box style9">
                <div class="col-sms-4 col-sm-4">
                    <article class="box">
                        <figure>
                            <a href="hotel-list-view.html" title="" class="hover-effect yellow middle-block animated" data-animation-type="fadeInUp" data-animation-duration="1">
                                <img src="http://placehold.it/370x170" alt="" /></a>
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
                            <a href="hotel-list-view.html" title="" class="hover-effect yellow middle-block animated" data-animation-type="fadeInUp" data-animation-duration="1" data-animation-delay="0.4"><img src="http://placehold.it/370x170" alt="" /></a>
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
                            <a href="hotel-list-view.html" title="" class="hover-effect yellow middle-block animated" data-animation-type="fadeInUp" data-animation-duration="1" data-animation-delay="0.8"><img src="http://placehold.it/370x170" alt="" /></a>
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
            <img src="http://placehold.it/524x540" alt="" class="animated" data-animation-type="fadeInUp" data-animation-duration="2">
        </div>
    </div>
</div>

<!-- Did you Know? section -->
<div class="offers section">
    <div class="container">
        <h1 class="text-center">Did you know?</h1>
        <p class="col-xs-9 center-block no-float text-center">Mauris ullamcorper nibh quis leo ultrices in hendrerit velit tristiqueut augue in nulla lacinia bibendum liberoras rutrum ac purus ut tristique.
Nullam placerat lacinia dolor quis pretium. Phasellus vitae lacinia quam, at pellentesque lorem. Sed euismod turpis quis mattis fringilla.</p>
        <div class="row image-box style2">
            <div class="col-md-6">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInLeft" data-animation-duration="1">
                        <a href="#" title=""><img src="http://placehold.it/270x192" alt="" width="270" height="192" /></a>
                    </figure>
                    <div class="details">
                        <h4>Hire Cars</h4>
                        <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id.</p>
                        <a href="#" title="" class="button">SEE ALL</a>
                    </div>
                </article>
            </div>
            <div class="col-md-6">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInLeft" data-animation-duration="1" data-animation-delay="0.4">
                        <a href="#" title=""><img src="http://placehold.it/270x192" alt="" width="270" height="192" /></a>
                    </figure>
                    <div class="details">
                        <h4>Cruise Deals</h4>
                        <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id.</p>
                        <a href="#" title="" class="button">SEE ALL</a>
                    </div>
                </article>
            </div>
            <div class="col-md-6">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInLeft" data-animation-duration="1">
                        <a href="#" title=""><img src="http://placehold.it/270x192" alt="" width="270" height="192" /></a>
                    </figure>
                    <div class="details">
                        <h4>Things To Do</h4>
                        <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id.</p>
                        <a href="#" title="" class="button">SEE ALL</a>
                    </div>
                </article>
            </div>
            <div class="col-md-6">
                <article class="box">
                    <figure class="animated" data-animation-type="fadeInLeft" data-animation-duration="1" data-animation-delay="0.4">
                        <a href="#" title=""><img src="http://placehold.it/270x192" alt="" width="270" height="192" /></a>
                    </figure>
                    <div class="details">
                        <h4>Fly in Comfort</h4>
                        <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id.</p>
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
                        <img src="http://placehold.it/300x120" alt="" class="middle-item" />
                        <span class="opacity-wrapper"></span>
                    </figure>
                    <div class="details">
                        <h4><a href="#">Best Price Guarantee</a></h4>
                        <p>
                            Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massa idporta nequetiam elerisque mi id faucibus iaculis vitae pulvinar.
                        </p>
                    </div>
                </article>
            </div>
            <div class="col-sms-6 col-sm-6 col-md-3">
                 <article class="box">
                    <figure class="middle-block">
                        <img src="http://placehold.it/300x120" alt="" class="middle-item" />
                        <span class="opacity-wrapper"></span>
                    </figure>
                    <div class="details">
                        <h4><a href="#">Travel Insurance</a></h4>
                        <p>
                            Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massa idporta nequetiam elerisque mi id faucibus iaculis vitae pulvinar.
                        </p>
                    </div>
                </article>
            </div>
            <div class="col-sms-6 col-sm-6 col-md-3">
                 <article class="box">
                    <figure class="middle-block">
                        <img src="http://placehold.it/300x120" alt="" class="middle-item" />
                        <span class="opacity-wrapper"></span>
                    </figure>
                    <div class="details">
                        <h4><a href="#">Why Chose Us</a></h4>
                        <p>
                            Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massa idporta nequetiam elerisque mi id faucibus iaculis vitae pulvinar.
                        </p>
                    </div>
                </article>
            </div>
            <div class="col-sms-6 col-sm-6 col-md-3">
                 <article class="box">
                    <figure class="middle-block">
                        <img src="http://placehold.it/300x120" alt="" class="middle-item" />
                        <span class="opacity-wrapper"></span>
                    </figure>
                    <div class="details">
                        <h4><a href="#">Need Help?</a></h4>
                        <p>
                            Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massa idporta nequetiam elerisque mi id faucibus iaculis vitae pulvinar.
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
