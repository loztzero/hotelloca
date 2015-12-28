@extends('layouts.layout-hotel-owner')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<h3>Hotel Rooms</h3>
	@include('layouts.message-helper')

	<div class="large-12 colums">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('hotel-owner/save-room') }}" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			@if(!empty(old('id', $profile->id)))
				<input type="hidden" value="{{ old('id')}}" name="id">
			@endif
			<div class="row">
				<div class="large-3 large-offset-2 medium-3 columns">
		         <input type="file" name="files" />
		        </div>
		    </div>

		    <div class="row">
		    	<div class="small-12 medium-9 large-4 large-offset-2 columns left">
			         <a class="th" role="button" aria-label="Thumbnail" href="http://localhost:8080/hotelloca/assets/img/promo.jpg" data-lightbox="image-1" data-title="My caption">
						<img src="http://localhost:8080/hotelloca/assets/img/promo.jpg">
					</a>
					<br><br>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="hotelName" class="right inline show-for-medium-up">Hotel Name *</label>
		          <label for="hotelName" class="show-for-small-only">Hotel Name *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('hotel_name') }}" id="hotelName" name="hotel_name" required>
		          <small class="error">Hotel Name Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="fromDate" class="right inline show-for-medium-up">Periode Start *</label>
		          <label for="fromDate" class="show-for-small-only">Periode Start *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('from_date') }}" id="fromDate" name="from_date" required>
		          <small class="error">From Date Required</small>
		        </div>

		        <div class="large-2 medium-12 columns">
		        	<!-- foundation bug ?? -->
		        </div>

		        <div class="large-2 medium-3 columns left">
		          <label for="endDate" class="right inline show-for-medium-up">Periode End *</label>
		          <label for="endDate" class="show-for-small-only">Periode End *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('end_date') }}" id="endDate" name="end_date" required>
		          <small class="error">From Date Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="roomName" class="right inline show-for-medium-up">Room Name *</label>
		          <label for="roomName" class="show-for-small-only">Room Name *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('room_name') }}" id="hotelName" name="room_name" required>
		          <small class="error">Room Name Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="numAdults" class="right inline show-for-medium-up">Number Adults *</label>
		          <label for="numAdults" class="show-for-small-only">Number Adults *</label>
		        </div>
		        <div class="small-12 medium-9 large-1 columns left">
	        		{!! Form::select('num_adults', $numberPerson , old('num_adults'), array('required')) !!}
		          	<small class="error">Number Adult Required</small>
		        </div>

		        <div class="large-2 medium-12 columns">
		        	<!-- foundation bug ?? -->
		        </div>

		        <div class="large-2 large-offset-3 medium-3 columns">
		          <label for="numChild" class="right inline show-for-medium-up">Number Children *</label>
		          <label for="numChild" class="show-for-small-only">Number Children *</label>
		        </div>
		        <div class="small-12 medium-9 large-1 columns left">
		          {!! Form::select('num_child', $numberPerson , old('num_child'), array('required')) !!}
		          <small class="error">Number Children Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="hotelName" class="right inline show-for-medium-up">Bed Type *</label>
		          <label for="hotelName" class="show-for-small-only">Bed Type *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	{!! Form::select('bed_type', array('Queen' => 'Queen', 'King' => 'King') , old('bed_type'), array('required')) !!}
		          <small class="error">Bed Type Required</small>
		        </div>

		        <div class="large-2 medium-12 columns">
		        	<!-- foundation bug ?? -->
		        </div>

		        <div class="large-2 medium-3 columns">
		          <label for="bedType" class="right inline show-for-medium-up">Floor *</label>
		          <label for="bedType" class="show-for-small-only">Floor *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('bed_type') }}" id="bedType" name="bed_type" required>
		          <small class="error">Bed Type Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="net" class="right inline show-for-medium-up">Internet *</label>
		          <label for="net" class="show-for-small-only">Internet *</label>
		        </div>
		        <div class="small-12 medium-9 large-2 columns left">
		          {!! Form::select('net', array('Yes' => 'Yes', 'No' => 'No') , old('net'), array('required')) !!}
		          <small class="error">Internet Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="netFee" class="right inline show-for-medium-up">Internet Fee *</label>
		          <label for="netFee" class="show-for-small-only">Internet Fee *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('net_fee') }}" id="netFee" name="net_fee" required>
		          <small class="error">Internet Fee Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="cutOff" class="right inline show-for-medium-up">Cut Off (In Day) *</label>
		          <label for="cutOff" class="show-for-small-only">Cut Off *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('cut_off') }}" id="cutOff" name="cut_off" required>
		          <small class="error">Cut Off Required</small>
		        </div>

		        <div class="large-2 medium-12 columns">
		        	<!-- foundation bug ?? -->
		        </div>

		        <div class="large-2 medium-3 columns">
		          <label for="allotment" class="right inline show-for-medium-up">Allotment *</label>
		          <label for="allotment" class="show-for-small-only">Allotment *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('allotment') }}" id="allotment" name="allotment" required>
		          <small class="error">Allotment Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="numBreakfast" class="right inline show-for-medium-up">Breakfast (In Pax) *</label>
		          <label for="numBreakfast" class="show-for-small-only">Breakfast (In Pax) *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('num_breakfast') }}" id="hotelName" name="num_breakfast" required>
		          <small class="error">Breakfast Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="desc" class="right inline show-for-medium-up">Desciption</label>
		          <label for="desc" class="show-for-small-only">Desciption</label>
		        </div>
		        <div class="small-12 medium-9 large-8 columns left">
		          <textarea id="desc" name="desc"></textarea>
		        </div>
		    </div>

		    <div class="row">
				<div class="panel">
					<b>Rate</b>
					<hr>
					<div class="row">
						<div class="large-2 medium-3 columns">
				          <label for="rateType" class="right inline show-for-medium-up">Type</label>
				          <label for="rateType" class="show-for-small-only">Type</label>
				        </div>
				        <div class="small-12 medium-9 large-2 columns left">
				        	{!! Form::select('rate_type', array('Nett' => 'Nett', 'Commision' => 'Commision') , old('rate_type'), array('required', 'ng-model' => 'field.rate_type')) !!}
				          <small class="error">Type Required</small>
				        </div>

				        <div class="large-2 medium-12 columns">
				        	<!-- foundation bug ?? -->
				        </div>

				        <div class="large-2 medium-3 large-offset-2 columns">
				          <label for="dailyPrice" class="right inline show-for-medium-up">Daily Price</label>
				          <label for="dailyPrice" class="show-for-small-only">Daily Price</label>
				        </div>
				        <div class="small-12 medium-9 large-4 columns left">
				          <input type="text" class="span2" id="dailyPrice" name="daily_price" value="{{ old('daily_price') }}" required>
				          <small class="error">Daily Price Required</small>
				        </div>
					</div>

					<div class="row">
						<div class="large-2 medium-3 columns">
				          <label for="commType" class="right inline show-for-medium-up">Type Commision</label>
				          <label for="commType" class="show-for-small-only">Type Commision</label>
				        </div>
				        <div class="small-12 medium-9 large-2 columns left">
				        	{!! Form::select('comm_type', array('%' => '%', 'Value' => 'Value') , null, array('required', 'ng-model' => 'field.comm_type')) !!}
				          <small class="error">Type Commision Required</small>
				        </div>

				        <div class="large-2 medium-12 columns">
				        	<!-- foundation bug ?? -->
				        </div>

				        <div class="large-2 medium-3 large-offset-2 columns" ng-if="field.comm_type == '%'">
				          <label for="commPct" class="right inline show-for-medium-up">% Commision</label>
				          <label for="commPct" class="show-for-small-only">% Commision</label>
				        </div>
				        <div class="small-12 medium-9 large-4 columns left" ng-if="field.comm_type == '%'">
				          <input type="text" class="span2" id="commPct" name="comm_pct" value="{{ old('comm_pct', 0) }}" required>
				          <small class="error">% Commision Required</small>
				        </div>

				        <div class="large-2 medium-3 large-offset-2 columns" ng-if="field.comm_type == 'Value'">
				          <label for="commValue" class="right inline show-for-medium-up"> Commision Value</label>
				          <label for="commValue" class="show-for-small-only">Commision Value</label>
				        </div>
				        <div class="small-12 medium-9 large-4 columns left" ng-if="field.comm_type == 'Value'">
				          <input type="text" class="span2" id="commValue" name="comm_value" value="{{ old('comm_value', 0) }}" required>
				          <small class="error">Commision Value Required</small>
				        </div>
					</div>
				</div>
		    </div>
		
	    	<div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
					<button type="submit" class="button small">Add New Room</button>          
		        </div>
		    </div>
	    </form>
    </div>

</div>

@endsection

@section('script')
<script>

var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var fromDate = $('#fromDate').fdatepicker({
	format : 'dd-mm-yyyy',
	onRender: function (date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
	}	
});

var endDate = $('#endDate').fdatepicker({
	format : 'dd-mm-yyyy',
	onRender: function (date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
	}	
});

$(".confirm-delete").on("click", function(e) {
	e.preventDefault();
	var form = $(this).parents('form');
	swal({   
		title: "Are you sure?",   
		text: "This picture will be deleted",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#f04124",   
		confirmButtonText: "Yes, delete it!",   
		closeOnConfirm: false }, 
	function(confirmed){   
		if (confirmed) form.submit();
	});

});

	

</script>
<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {

		$scope.field = {};
		$scope.field.comm_type = "{{ old('comm_type', '%') }}";
		$scope.field.rate_type = "{{ old('rate_type', 'Nett') }}";

	});
</script>
@stop
