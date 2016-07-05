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


		<h3>Payment</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="POST" action="{{url('/hotel-agent/validate-confirmation-payment')}}" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">


			<div class="row">
				<div class="large-11 medium-11 small-11 column">
					<label>Payment Detail</label>
					<table>
						<tr>
							<th>Hotel</th>
							<th>Type</th>
							<th>Check In / Check Out Date</th>
							<th>Night</th>
							<th>Price</th>
						</tr>
						<tr>
							<td>Nama Hotel</td>
							<td>Nama Hotel</td>
							<td>Nama Hotel</td>
							<td>Nama Hotel</td>
							<td>Nama Hotel</td>
						</tr>
						
					</table>
				</div>
			</div>

			<div class="row">
				<div class="large-12 medium-12 small-12 column">
					<label>Total Payment : xxx</label>
				</div>
			</div>
			
			<div class="row">
				<div class="large-2 medium-3 small-12 column">
					<input id="checkbox1" type="checkbox"><label for="checkbox1">Use Deposit</label>
				</div>
				
				<div class="large-3 medium-6 small-12 column left">
					<input type="text">
				</div>
			</div>

		    <div class="row">
		       <div class="large-2 medium-6 small-12 column">
					<input id="checkbox1" type="checkbox"><label for="checkbox1">Transfer Bank</label>
				</div>
		    </div>

		    <div class="row">
		       <div class="large-12 medium-12 small-12 column">
					<input id="checkbox1" type="checkbox"><label for="checkbox1">Visa / Master</label>
					<div style="margin-left:1.5em;">
						<input type="radio" name="pokemon" value="Red" id="pokemonRed"><label for="pokemonRed">Red</label>
						<input type="radio" name="pokemon" value="Blue" id="pokemonBlue"><label for="pokemonBlue">Blue</label>
					</div>
					<div class="row">
						<div class="large-2 medium-3 columns">
				          <label for="transferTo" class="right inline show-for-medium-up">Card Number</label>
				          <label for="transferTo" class="show-for-small-only">Card Number</label>
				        </div>
				         <div class="small-12 medium-3 large-3 columns left">
				        	<input type="text" name="payment_val" id="paymentValue" value="{{old('payment_val')}}" required>
				        </div>

				        <div class="large-2 medium-3 columns">
				          <label for="transferTo" class="right inline show-for-medium-up">Card Name</label>
				          <label for="transferTo" class="show-for-small-only">Card Name</label>
				        </div>
				         <div class="small-12 medium-3 large-3 columns left">
				        	<input type="text" name="payment_val" id="paymentValue" value="{{old('payment_val')}}" required>
				        </div>
					</div>

					<div class="row">
						<div class="large-2 medium-3 columns">
				          <label for="transferTo" class="right inline show-for-medium-up">CCV</label>
				          <label for="transferTo" class="show-for-small-only">CCV</label>
				        </div>
				         <div class="small-12 medium-3 large-3 columns left">
				        	<input type="text" name="payment_val" id="paymentValue" value="{{old('payment_val')}}" required>
				        </div>

				        <div class="large-2 medium-3 columns">
				          <label for="transferTo" class="right inline show-for-medium-up">Expired Date</label>
				          <label for="transferTo" class="show-for-small-only">Expired Date</label>
				        </div>
				         <div class="small-12 medium-3 large-3 columns left">
				        	<input type="text" name="payment_val" id="paymentValue" value="{{old('payment_val')}}" required>
				        </div>
					</div>
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