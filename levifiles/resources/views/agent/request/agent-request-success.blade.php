@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Request</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Agent</a></li>
	            <li class="active">Request</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')

<div class="container" ng-controller="MainCtrl">
	<div class="container">
        <div class="row">
            <div id="main" class="col-sm-8 col-md-9">
                <div class="booking-information travelo-box">
                    <h2>Request Confirmation</h2>
                    <hr />
                    <div class="booking-confirmation clearfix">
                        <i class="soap-icon-recommend icon circle"></i>
                        <div class="message">
                            <h4 class="main-message">Thank You. Your Request Order is Confirmed Now.</h4>
                            <p>A confirmation email has been sent to your provided email address.</p>
                        </div>
                    </div>
                    <hr />
                    <h2>Traveler Information</h2>
                    <dl class="term-description">
                        <dt>Request number:</dt><dd>{{ $data->orderNumber }}</dd>
                        <dt>Title:</dt><dd>{{ $data->title }}</dd>
                        <dt>First name:</dt><dd>{{ $data->firstName }}</dd>
                        <dt>Last name:</dt><dd>{{ $data->lastName }}</dd>
                        <dt>City:</dt><dd>{{ $data->city }}</dd>
                        <dt>Country:</dt><dd>{{ $data->country }}</dd>
                    </dl>
                    <hr />
                    <h2>Payment</h2>
                    <p>Praesent dolor lectus, rutrum sit amet risus vitae, imperdiet cursus neque. Nulla tempor nec lorem eu suscipit. Donec dignissim lectus a nunc molestie consectetur. Nulla eu urna in nisi adipiscing placerat. Nam vel scelerisque magna. Donec justo urna, posuere ut dictum quis.</p>
                    <hr />
                    <h2>View Request Details</h2>
                    <p>Praesent dolor lectus, rutrum sit amet risus vitae, imperdiet cursus neque. Nulla tempor nec lorem eu suscipit. Donec dignissim lectus a nunc molestie consectetur. Nulla eu urna in nisi adipiscing placerat. Nam vel scelerisque magna. Donec justo urna, posuere ut dictum quis.</p>
                    <br />
                    <?php //<a href="#" class="red-color underline view-link">https://www.travelo.com/booking-details/?=f4acb19f-9542-4a5c-b8ee</a>
                    ?>
                </div>
            </div>
            <div class="sidebar col-sm-4 col-md-3">
                <div class="travelo-box contact-box">
                    <h4>Need Hotelloca Help?</h4>
                    <p>We would be more than happy to help you. Our team advisor are 24/7 at your service to help you.</p>
                    <address class="contact-details">
                        <span class="contact-phone"><i class="soap-icon-phone"></i> 1-800-123-HELLO</span>
                        <br>
                        <a class="contact-email" href="#">help@hotelloca.com</a>
                    </address>
                </div>
                <div class="travelo-box book-with-us-box">
                    <h4>Why Book with us?</h4>
                    <ul>
                        <li>
                            <i class="soap-icon-hotel-1 circle"></i>
                            <h5 class="title"><a href="#">135,00+ Hotels</a></h5>
                            <p>Nunc cursus libero pur congue arut nimspnty.</p>
                        </li>
                        <li>
                            <i class="soap-icon-savings circle"></i>
                            <h5 class="title"><a href="#">Low Rates &amp; Savings</a></h5>
                            <p>Nunc cursus libero pur congue arut nimspnty.</p>
                        </li>
                        <li>
                            <i class="soap-icon-support circle"></i>
                            <h5 class="title"><a href="#">Excellent Support</a></h5>
                            <p>Nunc cursus libero pur congue arut nimspnty.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')

<script>

var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function ($scope, $http, $filter) {


});

// app.directive('helloWorld', function(){
// 	return {
// 		restrict : 'E',
// 		templateUrl : "{{url('/assets/directivepartial')}}/hello.html"
// 	}
// })
</script>
@stop
