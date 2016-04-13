@extends('layouts.foundation-login')
@section('content')

<div class="row" ng-controller="MainCtrl">
	<div class="large-12 columns">
		<ul class="breadcrumbs">
		  <li class="unavailable"><a href="#">Hotel</a></li>
		  <li class="unavailable"><a href="#">Result</a></li>
		  <li class="unavailable"><a href="#">Package Detail</a></li>
		  <li class="unavailable"><a href="#">Payment</a></li>
		  <li class="current"><a href="#">Confirm</a></li>
		</ul>


		<h3>Booking Hotel</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="POST" action="{{url('/hotel-agent/validate-confirmation-payment')}}" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<fieldset>
				<legend>Information Hotel</legend>
				<div class="row">
					<div class="large-6 medium-12 small-12 column">
						<table class="info-hotel">
							<tr>
								<td>Nama Hotel</td>
								<td>10 Bintang</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td>Check In Date :</td>
								<td>10 Bintang</td>
							</tr>
							<tr>
								<td>Check Out Date :</td>
								<td>10 Bintang</td>
							</tr>
							<tr>
								<td>Night :</td>
								<td>10 Bintang</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td>Type</td>
								<td>10 Bintang</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td>Type Room</td>
								<td>10 Bintang</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td>Currency</td>
								<td>10 Bintang</td>
							</tr>
							<tr>
								<td>Price</td>
								<td>10 Bintang</td>
							</tr>
							<tr>
								<td>Total Price</td>
								<td>10 Bintang</td>
							</tr>
						</table>
					</div>
					<div class="large-6 column">
					</div>
				</div>

			</fieldset>

			<fieldset>
				<legend>Guest</legend>
				<div class="row">
					<div class="large-3 medium-3 columns">
			          <label for="orderNo" class="right inline show-for-medium-up">Title *
			          </label>
			          <label for="orderNo" class="show-for-small-only">Title *</label>
			        </div>
			        <div class="small-12 medium-4 large-2 columns left">
			        	{!! Form::select('transfer_to', config('enums.title'), old('transfer_to'), array('required')) !!}
			        	<small class="error">Order No Required</small>
			        </div>
			    </div>

			    <div class="row">
					<div class="large-3 medium-3 columns">
			          <label for="firstName" class="right inline show-for-medium-up">First Name *
			          </label>
			          <label for="firstName" class="show-for-small-only">First Name *</label>
			        </div>
			        <div class="small-12 medium-9 large-4 columns left">
			        	<input type="text" name="order_no" id="firstName" value="{{old('order_no')}}" required>
			        	<small class="error">First Name Required</small>
			        </div>
			    </div>

			    <div class="row">
					<div class="large-3 medium-3 columns">
			          <label for="orderNo" class="right inline show-for-medium-up">Order Number *
			          </label>
			          <label for="orderNo" class="show-for-small-only">Order Number *</label>
			        </div>
			        <div class="small-12 medium-9 large-4 columns left">
			        	<input type="text" name="order_no" id="firstName" value="{{old('order_no')}}" required>
			        	<small class="error">Order No Required</small>
			        </div>
			    </div>
			</fieldset>

			<b>Special Request</b><br><br>
			<div class="row">
				<div class="large-3 medium-6 columns large-offset-1">
					<input id="checkbox1" type="checkbox"><label for="checkbox1">Interconnection Room</label><br>
  					<input id="checkbox2" type="checkbox"><label for="checkbox2">Non Smoking</label><br>
  					<input id="checkbox1" type="checkbox"><label for="checkbox1">Early CheckIn</label><br>
  					<input id="checkbox2" type="checkbox"><label for="checkbox2">Late CheckIn</label>
				</div>
				<div class="large-3 medium-6 columns left">
					<input id="checkbox1" type="checkbox"><label for="checkbox1">High Floor</label><br>
  					<input id="checkbox2" type="checkbox"><label for="checkbox2">Low Floor</label><br>
  					<input id="checkbox2" type="checkbox"><label for="checkbox2">Twin Bed</label><br>
  					<input id="checkbox2" type="checkbox"><label for="checkbox2">Double Bed</label>
				</div>
			</div>

			<div class="row">
				<div class="large-10 columns">
			      <label><b>Note</b>
			        <textarea>
			        </textarea>
			      </label>
			    </div>
			</div>

			<div class="row">
				<div class="large-10 columns">
			      <label>Cancellation Policy
			      	<b>Table Cancellation Policy Field</b>
			      </label>

			    </div>
			</div>

		    <div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-3 medium-offset-3 columns left">
		          <button type="submit" class="button small">Go To Payment</button>
		        </div>
		    </div>

		</form>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">

$('#transferDate').fdatepicker({
	format : 'dd-mm-yyyy'
});

//set default date
$('#transferDate').fdatepicker('setDate', new Date());

</script>

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
