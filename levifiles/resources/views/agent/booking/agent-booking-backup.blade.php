@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Booking</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Agent</a></li>
	            <li class="active">Booking</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	
<div class="container" ng-controller="MainCtrl">
	<div class="container">
        <div class="row">
            <div id="main" class="col-sms-6 col-sm-8 col-md-9">
                <div class="booking-section travelo-box">
                    
                    <form class="booking-form" action="booking/confirm" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="person-information">
                            <h2>Guest Information</h2>

                            <div class="form-group row">
                                <div class="col-sm-3 col-md-2">
                                    <label>Title</label>
                                    <div class="selector">
                                        <select class="full-width" name="title">
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Ms">Ms</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-5">
                                    <label>first name</label>
                                    <input type="text" class="input-text full-width" value="" name="guest_first_name" placeholder="" />
                                </div>
                                <div class="col-sm-6 col-md-5">
                                    <label>last name</label>
                                    <input type="text" class="input-text full-width" value="" name="guest_last_name" placeholder="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-5">
                                    <label>Country code</label>
                                    <div class="selector">
                                        <select class="full-width">
                                            <option value="62">Indonesia (+62)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-5">
                                    <label>Phone number</label>
                                    <input type="text" class="input-text full-width" value="" placeholder="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> I want to receive <span class="skin-color">Travelo</span> promotional offers in the future
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="person-information">
                            <h2>Special Request</h2>

                            <div class="form-group">

                                <div class="row">
                                    <div class="col-sm-6 col-md-5">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="interconnetion_flag"> Interconnection Room
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-5">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="high_floor_flag"> High Floor
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-5">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="non_smoking_flag"> Non Smoking
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6 col-md-5">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="low_floor_flag"> Low Floor
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-md-5">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="early_check_in_flag"> Early Check In
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-5">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="twin_flag"> Twin / Double Bed
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-5">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> Late Check In
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr />
                        <div class="card-information">
                            <h2>Payment</h2>
                            <div class="form-group">
                                <div class="radio col-sm-6 col-md-4">
                                    <label><input type="radio" name="payment_method" ng-model="payment" value="balance">Balance</label>
                                </div>
                                <div class="radio col-sm-6 col-md-4">
                                    <label><input type="radio" name="payment_method" ng-model="payment" value="transfer">Transfer</label>
                                </div>
                                <div class="radio col-sm-6 col-md-4">
                                    <label><input type="radio" name="payment_method" ng-model="payment" value="credit_card">Credit Card</label>
                                </div>
                            </div>
                            <div style="clear:both;"></div>

                            <!-- transfer -->
                            <div ng-show="payment == 'transfer'">
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Account Name</label>
                                        <input type="text" class="input-text full-width" value="" placeholder="" />
                                    </div>
                                </div>
                            </div>

                            <!-- for credit card -->
                            <div ng-show="payment == 'credit_card'">
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Credit Card Type</label>
                                        <div class="selector">
                                            <select class="full-width" name="card_type">
                                                <option>Visa</option>
                                                <option>Master</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <label>Card holder name</label>
                                        <input type="text" class="input-text full-width" value="" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Card number</label>
                                        <input type="text" class="input-text full-width" value="" name="card_number" placeholder="" />
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <label>Card identification number</label>
                                        <input type="text" class="input-text full-width" value="" name="card_name" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Expiration Date</label>
                                        <div class="constant-column-2">
                                            <div class="selector">
                                                <select class="full-width">
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                            <div class="selector">
                                                <select class="full-width">
                                                    <option value="2016">2016</option>
                                                    <option value="2016">2017</option>
                                                    <option value="2016">2019</option>
                                                    <option value="2016">2019</option>
                                                    <option value="2016">2020</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <label>billing zip code</label>
                                        <input type="text" class="input-text full-width" value="" placeholder="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> By continuing, you agree to the <a href="#"><span class="skin-color">Terms and Conditions</span></a>.
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-5">
                                <button type="submit" class="full-width btn-large">CONFIRM BOOKING</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="sidebar col-sms-6 col-sm-4 col-md-3">
                <div class="booking-details travelo-box">
                    <h4>Booking Details</h4>
                    <article class="image-box hotel listing-style1">
                        <figure class="clearfix">
                            <a href="hotel-detailed.html" class="hover-effect middle-block"><img class="middle-item" width="270" height="160" alt="" src="http://placehold.it/270x160"></a>
                            <div class="travel-title">
                                <h5 class="box-title">Hotel Hilton<small>Paris france</small></h5>
                                <a href="hotel-detailed.html" class="button">EDIT</a>
                            </div>
                        </figure>
                        <div class="details">
                            <div class="feedback">
                                <div data-placement="bottom" data-toggle="tooltip" class="five-stars-container" title="4 stars"><span style="width: 80%;" class="five-stars"></span></div>
                                <span class="review">270 reviews</span>
                            </div>
                            <div class="constant-column-3 timing clearfix">
                                <div class="check-in">
                                    <label>Check in</label>
                                    <span>NOV 30, 2013<br />11 AM</span>
                                </div>
                                <div class="duration text-center">
                                    <i class="soap-icon-clock"></i>
                                    <span>2 Nights</span>
                                </div>
                                <div class="check-out">
                                    <label>Check out</label>
                                    <span>DEC 02, 2013<br />2 PM</span>
                                </div>
                            </div>
                            <div class="guest">
                                <small class="uppercase">1 Standard family room for <span class="skin-color">3 Persons</span></small>
                            </div>
                        </div>
                    </article>
                    
                    <h4>Other Details</h4>
                    <dl class="other-details">
                        <dt class="feature">room Type:</dt><dd class="value">Standard Family</dd>
                        <dt class="feature">per Room price:</dt><dd class="value">$121</dd>
                        <dt class="feature">2 night Stay:</dt><dd class="value">$242</dd>
                        <dt class="feature">taxes and fees:</dt><dd class="value">$10</dd>
                        <dt class="total-price">Total Price</dt><dd class="total-price-value">$252</dd>
                    </dl>
                </div>
                
                <div class="travelo-box contact-box">
                    <h4>Need Travelo Help?</h4>
                    <p>We would be more than happy to help you. Our team advisor are 24/7 at your service to help you.</p>
                    <address class="contact-details">
                        <span class="contact-phone"><i class="soap-icon-phone"></i> 1-800-123-HELLO</span>
                        <br>
                        <a class="contact-email" href="#">help@travelo.com</a>
                    </address>
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

    $scope.payment = 'transfer';

});

// app.directive('helloWorld', function(){
// 	return {
// 		restrict : 'E',
// 		templateUrl : "{{url('/assets/directivepartial')}}/hello.html"
// 	}
// })
</script>
@stop