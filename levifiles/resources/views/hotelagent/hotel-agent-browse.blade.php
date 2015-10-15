@extends('layouts.foundation-login')
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
		<form class="form-horizontal" role="form" method="POST" action="{{App::make('url')->to('/')}}/auth/login">
			<div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Pac Passport</label>
		          <label for="right-label" class="show-for-small-only">Pac Passport</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <select id="right-label">
		          	@foreach($countries as $country)
		          		@if($country->country_name == 'Indonesia')
		          		<option selected>{{$country->country_name}}</option>
		          		@else
		          		<option>{{$country->country_name}}</option>
		          		@endif
		          	@endforeach
		          </select>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Destination Country</label>
		          <label for="right-label" class="show-for-small-only">Destination Country</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <select id="right-label">
		          	@foreach($countries as $country)
		          		@if($country->country_name == 'Indonesia')
		          		<option selected>{{$country->country_name}}</option>
		          		@else
		          		<option>{{$country->country_name}}</option>
		          		@endif
		          	@endforeach
		          </select>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Destination City</label>
		          <label for="right-label" class="show-for-small-only">Destination City</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <select id="right-label">
		          </select>
		        </div>
		    </div>

		    <div class="row">
		    	<div class="large-3 columns large-offset-2">
		    		<label>Check In
		    			<input type="text" class="span2" value="" id="dp1" readonly style="float:left;">
		    		</label>
		    	</div>

		    	<div class="large-1 columns">
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
		    			<input type="text" class="span2" value="" id="dp2" readonly>
		    		</label>
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

});

// app.directive('helloWorld', function(){
// 	return {
// 		restrict : 'E',
// 		templateUrl : "{{url('/assets/directivepartial')}}/hello.html"
// 	}
// })
</script>
@stop