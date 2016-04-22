@extends('layouts.general-travel-layout')

@section('titleContainer')
<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">Hotel Details</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="#">Agent</a></li>
            <li>Hotel</li>
            <li class="active">Hotel Details</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="container" ng-controller="MainCtrl">

	<div class="row">
		<div class="row">
            <div id="main" class="col-md-9">
                <div class="tab-container style1" id="hotel-main-content">
                    <ul class="tabs">
                        <li class="active"><a data-toggle="tab" href="#photos-tab">photos</a></li>
                        <li class="pull-right"><a class="button btn-small yellow-bg white-color" href="#">TRAVEL GUIDE</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="photos-tab" class="tab-pane fade in active">
                            <div class="photo-gallery style1" data-animation="slide" data-sync="#photos-tab .image-carousel">
                                <ul class="slides">
                                    <li><img src="http://placehold.it/900x500" alt="" /></li>
                                    <li><img src="http://placehold.it/900x500" alt="" /></li>
                                </ul>
                            </div>
                            <div class="image-carousel style1" data-animation="slide" data-item-width="70" data-item-margin="10" data-sync="#photos-tab .photo-gallery">
                                <ul class="slides">
                                    <li><img src="http://placehold.it/70x70" alt="" /></li>
                                    <li><img src="http://placehold.it/70x70" alt="" /></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="hotel-features" class="tab-container">
                    <ul class="tabs">
                        <li><a href="#hotel-description" data-toggle="tab">Description</a></li>
                        <li class="active"><a href="#hotel-availability" data-toggle="tab">Availability</a></li>
                        <li><a href="#hotel-amenities" data-toggle="tab">Amenities</a></li>
                        <li><a href="#hotel-faqs" data-toggle="tab">FAQs</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="hotel-description">
                            <div class="intro table-wrapper full-width hidden-table-sms">
                                <div class="col-sm-5 col-lg-4 features table-cell">
                                    <ul>
                                        <li><label>hotel type:</label>{{ $hotel->star }} star</li>
                                        <li><label>Country:</label>{{ $hotel->country->country_name }}</li>
                                        <li><label>City:</label>{{ $hotel->city->city_name }}</li>
                                    </ul>
                                </div>
                                <div class="col-sm-7 col-lg-8 table-cell">

                                </div>
                            </div>
                            <div class="long-description">
                                <h2>About {{ $hotel->hotel_name }}</h2>
                                <p>
                                    {{ $hotel->description }}
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane fade in active" id="hotel-availability">
                            <form method="get" action="{{ url('agent/hotel/hotel-detail') }}">
                                <div class="update-search clearfix">
                                    <div class="col-md-5">
                                        <h4 class="title">When</h4>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label>CHECK IN</label>
                                                <div class="datepicker-wrap">
                                                        <input type="text" name="checkIn" value="{{ $request->checkIn }}" placeholder="dd-mm-yyyy" class="input-text full-width" />
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>CHECK OUT</label>
                                                <div class="datepicker-wrap">
                                                        <input type="text" name="checkOut" value="{{ $request->checkOut }}" placeholder="dd-mm-yyyy" class="input-text full-width" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <h4 class="title">Who</h4>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label>ROOMS</label>
                                                <div class="selector">
                                                    {!! Form::select('room', array('1' => '01', '2' => '02', '3' => '03', '4' => '04'), $request->input('room', 1), array('class' => 'full-width')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <label>ADULTS</label>
                                                <div class="selector">
                                                    {!! Form::select('adults', array('1' => '01', '2' => '02', '3' => '03', '4' => '04'), $request->input('adults', 1), array('class' => 'full-width')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <label>KIDS</label>
                                                <div class="selector">
                                                    {!! Form::select('child', array('0' => '00', '1' => '01', '2' => '02', '3' => '03', '4' => '04'), $request->input('child', 0), array('class' => 'full-width')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <h4 class="visible-md visible-lg">&nbsp;</h4>
                                        <label class="visible-md visible-lg">&nbsp;</label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <input type="hidden" value="{{ $request->hotel }}" name="hotel">
                                                <button data-animation-duration="1" data-animation-type="bounce" class="full-width icon-check animated" type="submit"
                                                >SEARCH NOW</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <h2>Available Rooms</h2>
                            <div class="room-list listing-style3 hotel">

                                @foreach($newRooms as $room)

                                    <div class="modal fade" tabindex="-1" id="{{ $room->room_name }}" role="dialog" aria-labelledby="modal">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <form>
                                                        <table class="table table-striped">
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Price</th>
                                                            </tr>
                                                            <?php $totalPrice = 0 ;?>
                                                            @foreach($room->pricing as $price)
                                                            <tr>
                                                                <td>{{ $price->period_date }}</td>
                                                                <td>
                                                                    <?php
                                                                        $date = new DateTime($helpers::dateFormatter($price->period_date));
                                                                        $day = $date->format('w');
                                                                    ?>
                                                                    @if($day == 5 || $day == 6)
                                                                        {{ number_format($price->nett_value , 0, ',', '.') }}
                                                                    @else
                                                                        {{ number_format($price->nett_value, 0, ',', '.') }}
                                                                    @endif

                                                                </td>
                                                            </tr>
                                                            <?php $totalPrice += $price->nett_value ;?>
                                                            @endforeach
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <article class="box">
                                        <figure class="col-sm-4 col-md-3">
                                            <a class="hover-effect popup-gallery" href="ajax/slideshow-popup.html" title=""><img width="230" height="160" src="http://placehold.it/230x160" alt=""></a>
                                        </figure>
                                        <div class="details col-xs-12 col-sm-8 col-md-9">
                                            <div>


                                                <div>
                                                    <div class="box-title">
                                                        <h4 class="title">{{ $room->room_name }}</h4>
                                                        <dl class="description">
                                                            <dt>Max Guests:</dt>
                                                            <dd>{{ $room->num_adults }} adults and {{ $room->num_child }} child</dd>
                                                        </dl>
                                                    </div>
                                                    <!-- <div class="amenities">
                                                        <i class="soap-icon-wifi circle"></i>
                                                        <i class="soap-icon-fitnessfacility circle"></i>
                                                        <i class="soap-icon-fork circle"></i>
                                                        <i class="soap-icon-television circle"></i>
                                                    </div> -->
                                                </div>
                                                <div class="price-section">
                                                    <span class="price"><small>Total / Rp.</small> {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <p>
                                                    {{ $room->room_desc }} | {{ $room->allotment }} | {{ $room->rate_id }}<br>
                                                </p>


                                                <div class="action-section">
                                                    <a href="#detailPrice-{{$room->room_name}}" data-toggle="modal" data-target="#{{ $room->room_name }}" class="button btn-small full-width text-center">Detail Price</a>
                                                    @if($room->allotment >= $request->room)
                                                    <form method="post" action="{{ url('agent/booking') }}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="rate_id" value="{{ $room->rate_id }}">
                                                        <input type="hidden" name="room" value="{{ $room->id }}">
                                                        <input type="hidden" name="room_qty" value="{{ $request->room }}">
                                                        <input type="hidden" name="check_in" value="{{ $request->checkIn }}">
                                                        <input type="hidden" name="check_out" value="{{ $request->checkOut }}">
                                                        <input type="hidden" name="adults" value="{{ $request->adults }}">
                                                        <input type="hidden" name="child" value="{{ $request->child }}">
                                                        <button type="submit" class="button btn-small full-width text-center">BOOK NOW</button>
                                                    </form>
                                                    @else
                                                    <form method="post" action="{{ url('agent/request') }}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="rate_id" value="{{ $room->rate_id }}">
                                                        <input type="hidden" name="room" value="{{ $room->id }}">
                                                        <input type="hidden" name="room_qty" value="{{ $request->room }}">
                                                        <input type="hidden" name="check_in" value="{{ $request->checkIn }}">
                                                        <input type="hidden" name="check_out" value="{{ $request->checkOut }}">
                                                        <input type="hidden" name="adults" value="{{ $request->adults }}">
                                                        <input type="hidden" name="child" value="{{ $request->child }}">
                                                        <button type="submit" class="button btn-small full-width text-center">REQUEST</button>
                                                    </form>
                                                    @endif
                                                    <!-- <a href="hotel-booking.html" title="" class="button btn-small full-width text-center">BOOK NOW</a> -->
                                                </div>
                                            </div>

                                        </div>
                                    </article>
                                @endforeach
                            </div>

                        </div>
                        <div class="tab-pane fade" id="hotel-amenities">
                            <h2>Amenities Style 01</h2>

                            <p>Maecenas vitae turpis condimentum metus tincidunt semper bibendum ut orci. Donec eget accumsan est. Duis laoreet sagittis elit et vehicula. Cras viverra posuere condimentum. Donec urna arcu, venenatis quis augue sit amet, mattis gravida nunc. Integer faucibus, tortor a tristique adipiscing, arcu metus luctus libero, nec vulputate risus elit id nibh.</p>
                            <ul class="amenities clearfix style1">
                                @foreach($hotel->facilities as $facility)
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-check-1"></i>{{ $facility->facility }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="hotel-faqs">
                            <h2>Frequently Asked Questions</h2>
                            <div class="topics">
                                <ul class="check-square clearfix">
                                    <li class="col-sm-6 col-md-4"><a href="#">address &amp; map</a></li>
                                    <li class="col-sm-6 col-md-4"><a href="#">messaging</a></li>
                                    <li class="col-sm-6 col-md-4"><a href="#">refunds</a></li>
                                    <li class="col-sm-6 col-md-4"><a href="#">pricing</a></li>
                                    <li class="col-sm-6 col-md-4 active"><a href="#">reservation requests</a></li>
                                    <li class="col-sm-6 col-md-4"><a href="#">your reservation</a></li>
                                </ul>
                            </div>
                            <p>Maecenas vitae turpis condimentum metus tincidunt semper bibendum ut orci. Donec eget accumsan est. Duis laoreet sagittis elit et vehicula. Cras viverra posuere condimentum. Donec urna arcu, venenatis quis augue sit amet, mattis gravida nunc. Integer faucibus, tortor a tristique adipiscing, arcu metus luctus libero, nec vulputate risus elit id nibh.</p>
                            <div class="toggle-container">
                                <div class="panel style1 arrow-right">
                                    <h4 class="panel-title">
                                        <a class="collapsed" href="#question1" data-toggle="collapse">How do I know a reservation is accepted or confirmed?</a>
                                    </h4>
                                    <div class="panel-collapse collapse" id="question1">
                                        <div class="panel-content">

                                        </div>
                                    </div>
                                </div>
                                <div class="panel style1 arrow-right">
                                    <h4 class="panel-title">
                                        <a class="collapsed" href="#question2" data-toggle="collapse">What do I do after I receive a reservation request from a guest?</a>
                                    </h4>
                                    <div class="panel-collapse collapse" id="question2">
                                        <div class="panel-content">
                                            <p>Sed a justo enim. Vivamus volutpat ipsum ultrices augue porta lacinia. Proin in elementum enim. <span class="skin-color">Duis suscipit justo</span> non purus consequat molestie. Etiam pharetra ipsum sagittis sollicitudin ultricies. Praesent luctus, diam ut tempus aliquam, diam ante euismod risus, euismod viverra quam quam eget turpis. Nam <span class="skin-color">tristique congue</span> arcu, id bibendum diam. Ut hendrerit, leo a pellentesque porttitor, purus arcu tristique erat, in faucibus elit leo in turpis vitae luctus enim, a mollis nulla.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel style1 arrow-right">
                                    <h4 class="panel-title">
                                        <a class="" href="#question3" data-toggle="collapse">How much time do I have to respond to a reservation request?</a>
                                    </h4>
                                    <div class="panel-collapse collapse in" id="question3">
                                        <div class="panel-content">
                                            <p>Sed a justo enim. Vivamus volutpat ipsum ultrices augue porta lacinia. Proin in elementum enim. <span class="skin-color">Duis suscipit justo</span> non purus consequat molestie. Etiam pharetra ipsum sagittis sollicitudin ultricies. Praesent luctus, diam ut tempus aliquam, diam ante euismod risus, euismod viverra quam quam eget turpis. Nam <span class="skin-color">tristique congue</span> arcu, id bibendum diam. Ut hendrerit, leo a pellentesque porttitor, purus arcu tristique erat, in faucibus elit leo in turpis vitae luctus enim, a mollis nulla.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel style1 arrow-right">
                                    <h4 class="panel-title">
                                        <a class="collapsed" href="#question4" data-toggle="collapse">Why can’t I call or email hotel or host before booking?</a>
                                    </h4>
                                    <div class="panel-collapse collapse" id="question4">
                                        <div class="panel-content">

                                        </div>
                                    </div>
                                </div>
                                <div class="panel style1 arrow-right">
                                    <h4 class="panel-title">
                                        <a class="collapsed" href="#question5" data-toggle="collapse">Am I allowed to decline reservation requests?</a>
                                    </h4>
                                    <div class="panel-collapse collapse" id="question5">
                                        <div class="panel-content">

                                        </div>
                                    </div>
                                </div>
                                <div class="panel style1 arrow-right">
                                    <h4 class="panel-title">
                                        <a class="collapsed" href="#question6" data-toggle="collapse">What happens if I let a reservation request expire?</a>
                                    </h4>
                                    <div class="panel-collapse collapse" id="question6">
                                        <div class="panel-content">

                                        </div>
                                    </div>
                                </div>
                                <div class="panel style1 arrow-right">
                                    <h4 class="panel-title">
                                        <a class="collapsed" href="#question7" data-toggle="collapse">How do I set reservation requirements?</a>
                                    </h4>
                                    <div class="panel-collapse collapse" id="question7">
                                        <div class="panel-content">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="sidebar col-md-3">
                <article class="detailed-logo">
                    <figure>
                        <img width="114" height="85" src="http://placehold.it/114x85" alt="">
                    </figure>
                    <div class="details">
                        <h2 class="box-title">{{ $hotel->hotel_name }}<small><i class="soap-icon-departure yellow-color"></i><span class="fourty-space">{{ $hotel->address }}</span></small></h2>
                        <div class="feedback clearfix">
                            <div title="4 stars" class="five-stars-container" data-toggle="tooltip" data-placement="bottom">
                                @if($hotel->star == 2)
                                    <span class="five-stars" style="width: 40%;"></span>
                                @elseif($hotel->star == 3)
                                    <span class="five-stars" style="width: 60%;"></span>
                                @elseif($hotel->star == 4)
                                    <span class="five-stars" style="width: 80%;"></span>
                                @elseif($hotel->star == 5)
                                    <span class="five-stars" style="width: 100%;"></span>
                                @else
                                    <span class="five-stars" style="width: 20%;"></span>
                                @endif
                            </div>
                            <span class="review pull-right">{{ $hotel->star }} Stars</span>
                        </div>
                        <p class="description">{{ $hotel->description }}</p>
                    </div>
                </article>
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
var app = angular.module("ui.hotelloca", ['ngSanitize']);
app.controller("MainCtrl", function ($scope, $http, $filter) {


});
</script>
@stop
