@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Hotel Room Input</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Hotel</a></li>
	            <li>Hotel Room</li>
	            <li class="active">Hotel Room Input</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
<div class="container" ng-controller="MainCtrl">
	
	<a href="{{ url('hotel/room-rate') }}" class="button tiny secondary"><< Back</a>
	<div class="travelo-box">

		<h3>Hotel Rooms</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="POST" action="{{ url('hotel/room-rate/save') }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			@if(!empty(old('id')))
				<input type="hidden" value="{{ old('id')}}" name="id">
			@endif
			<input type="hidden" value="{{ $profile->id }}" name="mst020_id">

		    <div class="form-group">
				<div class="col-xs-12">
		          <label>Hotel Name *</label>
		          <input type="text"class="input-text full-width" value="{{ $profile->hotel_name }}" id="hotelName" name="hotel_name" readonly>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-6">
		          <label>Periode Start *</label>
		          <input type="text"class="input-text full-width" value="{{ old('from_date') }}" id="fromDate" name="from_date" required>
		        </div>

		        <div class="col-xs-6">
		          <label>Periode End *</label>
		          <input type="text" class="input-text full-width" value="{{ old('end_date') }}" id="endDate" name="end_date" required>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-6">
		          	<label>Room Name *</label>
		          	<div class="selector">
			         	<select ng-model="field.mst023_id" name="mst023_id" ng-change="roomChange()" class="full-width">
			        		<option ng-repeat="room in rooms" value="@{{ room.id }}">@{{ room.room_name }}</option>
			        	</select>
			        </div>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-6">
		          	<label>Number Adults *</label>
		          	<div class="selector">
			         	{!! Form::select('num_adults', $numberPerson , old('num_adults'), array('required', 'id' => 'numAdults', 'class' => 'full-width')) !!}
			        </div>
		        </div>

		        <div class="col-xs-6">
		          	<label>Number Children *</label>
		          	<div class="selector">
			         	{!! Form::select('num_child', $numberChildren , old('num_child'), array('required', 'id' => 'numChild', 'class' => 'full-width')) !!}
			        </div>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-6">
		          	<label>Bed Type *</label>
		          	<div class="selector">
			         	{!! Form::select('bed_type', array('Queen' => 'Queen', 'King' => 'King') , old('bed_type'), array('required', 'id' => 'bedType', 'class' => 'full-width')) !!}
			        </div>
		        </div>

		        <div class="col-xs-6">
		          	<label>Floor</label>
		          	<input type="text" class="input-text full-width" value="{{ old('floor') }}" id="floor" name="floor">
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-6">
					<label>Internet *</label>
					{!! Form::select('net', array('Yes' => 'Yes', 'No' => 'No') , old('net'), array('required', 'id' => 'net', 'class' => 'full-width')) !!}
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-12">
		          	<label>Internet Fee *</label>
		          	<input type="text" class="input-text full-width" value="{{ old('net_fee') }}" id="netFee" name="net_fee" required>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-6">
		          	<label>Cut Off (In Day) *</label>
		          	<input type="number" class="input-text full-width" value="{{ old('cut_off') }}" id="cutOff" name="cut_off" required>
		        </div>

		        <div class="col-xs-6">
		          	<label>Allotment</label>
		          	<input type="text" class="input-text full-width" value="{{ old('allotment') }}" id="allotment" name="allotment" required>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-6">
					<label>Breakfast (In Pax) *</label>
					{!! Form::select('num_breakfast', array(0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4 ), old('num_breakfast'), array('required', 'id' => 'num_breakfast', 'class' => 'full-width')) !!}
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-12">
	          		<label>Description</label>
					<textarea id="roomDesc" name="room_desc" class="input-text full-width">{{ old('room_desc') }}</textarea>
		        </div>
		    </div>

		    <div class="form-group">
		    	<div class="col-xs-12">
	          		<b>Rate</b>
	          		<hr>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-6">
		          	<label>Type *</label>
		          	{!! Form::select('rate_type', array('Nett' => 'Nett', 'Commision' => 'Commision') , old('rate_type'), array('required', 'ng-model' => 'field.rate_type', 'ng-change' => 'rateTypeChange()', old('id') ? 'disabled' : '', 'class' => 'full-width')) !!}
		        </div> 

		        <div class="col-xs-6">
		          	<label>Daily Price</label>
		          	<input type="text" class="input-text full-width" id="dailyPrice" name="daily_price" value="{{ old('daily_price', 0) }}" required>
		        </div>
		    </div>
			
		    <div class="form-group" ng-show="field.rate_type == 'Commision'">
				<div class="col-xs-6">
		          	<label>Type Commision</label>
		          	<div class="selector">
			          	{!! Form::select('comm_type', array('%' => '%', 'Value' => 'Value') , null, array('required', 'ng-model' => 'field.comm_type', old('id') ? 'disabled' : '', 'class' => 'full-width')) !!}
		          	</div>
		        </div> 

		        <div class="col-xs-6" ng-if="field.comm_type == '%'">
		          	<label>% Commision</label>
		          	<input type="text" class="input-text full-width" id="commPct" name="comm_pct" value="{{ old('comm_pct', 0) }}" required {{ old('id') ? 'disabled' : '' }}>
		        </div>

		        <div class="col-xs-6" ng-if="field.comm_type == 'Value'">
		          	<label>Commision Value</label>
		          	<input type="text" class="input-text full-width" id="commValue" name="comm_value" value="{{ old('comm_value', 0) }}" required {{ old('id') ? 'disabled' : '' }}>
		        </div>
		    </div>

		
	    	<div class="form-group">
		        <div class="col-xs-12">
					<button type="submit" class="button">{{ empty(old('id')) ? 'Add New Room' : 'Update Room' }}</button>          
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
		$scope.field.mst023_id = "{{ old('mst023_id', '') }}";
		$scope.field.comm_type = "{{ old('comm_type') }}";
		$scope.field.rate_type = "{{ old('rate_type', 'Nett') }}";

		// $scope.field = {};
		var kosong = [{'id' : '', 'room_name' : 'Select a Room'}]
		$scope.rooms = kosong.concat({!! $rooms !!});
		console.log($scope.rooms);

		$scope.rateTypeChange = function(){
			if($scope.field.rate_type != 'Nett'){
				$scope.field.comm_type = '%';
			} else {
				delete $scope.field.comm_type;
			}
		}

		$scope.roomChange = function(){

			var room = $filter('filter')($scope.rooms, { id: $scope.field.mst023_id});
			if(room.length > 0){
				var selectedRoom = room[0];
				$('#numAdults').val(selectedRoom.num_adults);
				$('#numChild').val(selectedRoom.num_child);
				$('#bedType').val(selectedRoom.bed_type);
				$('#net').val(selectedRoom.net);
				$('#netFee').val(selectedRoom.net_fee);
				$('#numBreakfast').val(selectedRoom.num_breakfast);
				$('#roomDesc').val(selectedRoom.room_desc);
			}

		}
	});
</script>
@stop
