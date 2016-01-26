@extends('layouts.layout-agent')
@section('content')
	
<div class="row" ng-controller="MainCtrl">
	<div class="small-12 columns">
		<ul class="breadcrumbs">
		  <li class="current"><a href="#">Hotel</a></li>
		  <li class="unavailable"><a href="#">Result</a></li>
		  <li class="unavailable"><a href="#">Package Detail</a></li>
		  <li class="unavailable"><a href="#">Payment</a></li>
		  <li class="unavailable"><a href="#">Confirm</a></li>
		</ul>


		<h3>Hotel Search</h3>
		<form class="form-horizontal" role="form" method="GET" action="{{ url('agent/hotel/search') }}">
			
			<div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Pac Passport</label>
		          <label for="right-label" class="show-for-small-only">Pac Passport</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		         {!! Form::select('country', $countries, null, array('ng-model' => 'field.passport','required')) !!}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Destination Country</label>
		          <label for="right-label" class="show-for-small-only">Destination Country</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          	{!! Form::select('country', $countries, null, array('ng-model' => 'field.country', 'ng-change' => 'getCity()', 'required')) !!}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Destination City</label>
		          <label for="right-label" class="show-for-small-only">Destination City</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <select ng-model="field.city" name="city" required id="city">
		          	<option value=""></option>
		          	<option ng-repeat="city in cities" value="@{{city.id}}">@{{city.city_name}}</option>
		          </select>
		        </div>
		    </div>

		    <div class="row">
		    	<div class="large-3 columns large-offset-2">
		    		<label>Check In
		    			<input type="text" class="span2" value="" id="dp1" readonly name="checkIn" style="float:left;">
		    		</label>
		    	</div>

		    	<div class="large-2 columns">
		    		<label>Night
		    			<select id="night">
		    				@for($i = 1;$i <= 30; $i++)
		    				<option value={{$i}}>{{$i}}</option>
		    				@endfor
		    			</select>
		    		</label>
		    	</div>
		    	<div class="large-3 columns left">
		    		<label>Check Out
		    			<?php
		    				$checkOut = new DateTime('+1 day');
		    				//{{$checkOut->format('d-m-Y')}}
		    			?>
		    			<input type="text" class="span2" value="" id="dp2" readonly name="checkOut">
		    		</label>
		    	</div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Adult</label>
		          <label for="right-label" class="show-for-small-only">Adult</label>
		        </div>
		        <div class="small-12 medium-9 large-2 columns left">
		          {!! Form::select('adults', array('1' => '1', '2' => '2', '3' => '3', '4' => '4'), null) !!}
		        </div>

		        <div class="large-2 medium-12 columns">
		        	<!-- foundation bug ?? -->
		        </div>

		        <div class="large-2 medium-3 large-offset-1 columns left">
		          <label for="endDate" class="right inline show-for-medium-up">Children</label>
		          <label for="endDate" class="show-for-small-only">Children</label>
		        </div>
		        <div class="small-12 medium-9 large-2 columns left">
	          		{!! Form::select('children', array('0' => '0', '1' => '1', '2' => '2'), null) !!}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Room</label>
		          <label for="right-label" class="show-for-small-only">Room</label>
		        </div>
		        <div class="small-12 medium-9 large-2 columns left">
		          	{!! Form::select('children', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'), null) !!}
		        </div>
		    </div>
	    	
		    <div class="row">
				<div class="large-2 medium-3 columns">
		        </div>
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
		          <button type="submit" class="button small">Search</button>
		        </div>
		    </div>

		</form>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var checkIn = $('#dp1').fdatepicker({
	format : 'dd-mm-yyyy',
	onRender: function (date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
	}
});

var checkOut = $('#dp2').fdatepicker({
	format : 'dd-mm-yyyy',
	onRender: function (date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
	}	
})

//set default date
$('#dp1').fdatepicker('setDate', new Date());
var tomorrow = new Date(nowTemp);
tomorrow.setDate(nowTemp.getDate()+1);
$('#dp2').fdatepicker('setDate', new Date(tomorrow));

//pergantian jumlah malam
$("#night").change(function(){
	var tanggalCheckIn = new Date(moment($('#dp1').val(), "DD-MM-YYYY"));
	var tanggalCheckOut = new Date(tanggalCheckIn);
	tanggalCheckOut.setDate(tanggalCheckIn.getDate() + eval(this.value));
	$('#dp2').fdatepicker('setDate', new Date(tanggalCheckOut));
});

//perubahan tanggal checkIn
$("#dp1").change(function(){
	var tanggalCheckIn = new Date(moment($('#dp1').val(), "DD-MM-YYYY"));
	var tanggalCheckOut = new Date(moment($('#dp2').val(), "DD-MM-YYYY"));
	if(tanggalCheckIn >= tanggalCheckOut){
		tanggalCheckOut = new Date(tanggalCheckIn);
		tanggalCheckOut.setDate(tanggalCheckIn.getDate() + 1)
		// alert(tanggalCheckOut);
		$('#dp2').fdatepicker('setDate', new Date(tanggalCheckOut));
	} else {
		var oneDay = 24*60*60*1000;
		var diffDays = Math.round(Math.abs((tanggalCheckIn.getTime() - tanggalCheckOut.getTime())/(oneDay)));
		$("#night").val(diffDays);

	}
});

$("#dp2").change(function(){
	var tanggalCheckIn = new Date(moment($('#dp1').val(), "DD-MM-YYYY"));
	var tanggalCheckOut = new Date(moment($('#dp2').val(), "DD-MM-YYYY"));
	var oneDay = 24*60*60*1000;
	var diffDays = Math.round(Math.abs((tanggalCheckIn.getTime() - tanggalCheckOut.getTime())/(oneDay)));
	if(diffDays > 30){
		tanggalCheckOut = new Date(tanggalCheckIn);
		tanggalCheckOut.setDate(tanggalCheckIn.getDate() + 30);

		$("#night").val(30);
		$('#dp2').fdatepicker('setDate', new Date(tanggalCheckOut));
	} else {
		$("#night").val(diffDays);
	}
});
</script>

<script>

var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function ($scope, $http, $filter) {

	$scope.field = {};
	$scope.field.passport = '{{ $indonesia->id }}';
	$scope.field.country = '{{ $indonesia->id }}';
	$scope.cities = [];
	$scope.getCity = function(){
		$http.post('{{ url("agent/hotel/city-from-country") }}', $scope.field).success(function(response){
			$scope.cities = response;
			$scope.field.city = '';
			// console.log(response);

		})
	}
	$scope.getCity();
	$scope.field.city = '{{old("city")}}';

});

// app.directive('helloWorld', function(){
// 	return {
// 		restrict : 'E',
// 		templateUrl : "{{url('/assets/directivepartial')}}/hello.html"
// 	}
// })
</script>
@stop