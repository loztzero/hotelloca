@extends('layouts.layout-hotel')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<a href="{{ url('hotel/room') }}" class="button tiny secondary">Back</a>

	<h3>Hotel Rooms</h3>
	@include('layouts.message-helper')

	<div class="large-12 colums">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('hotel/room/save') }}" enctype="multipart/form-data" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			@if(!empty(old('id')))
				<input type="hidden" value="{{ old('id')}}" name="id">
			@endif
			<input type="hidden" value="{{ $profile->id }}" name="mst020_id">
			<div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="hotelName" class="right inline show-for-medium-up">Hotel Picture</label>
		          <label for="hotelName" class="show-for-small-only">Hotel Picture</label>
		        </div>
				<div class="large-3 medium-3 columns left">
		         	<input type="file" name="image" />
		        </div>
		    </div>

		    @if(!empty(old('id')))
		    	@if(File::exists('./uploads/hotels/'. old('mst020_id'). '/'.old('id').'/room.jpg'))
				    <div class="row">
				    	<div class="small-12 medium-9 large-4 large-offset-2 columns left">
					         <a class="th" role="button" aria-label="Thumbnail" href="{{ url().'/uploads/hotels/'. old('mst020_id'). '/'.old('id').'/room.jpg' }}" data-lightbox="image-1" data-title="{{ old('room_name') }}">
								<img src="{{ url().'/uploads/hotels/'. old('mst020_id'). '/'.old('id').'/room.jpg' }}">
							</a>
							<br><br>
				        </div>
				    </div>
			    @endif
		    @endif

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="hotelName" class="right inline show-for-medium-up">Hotel Name *</label>
		          <label for="hotelName" class="show-for-small-only">Hotel Name *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ $profile->hotel_name }}" id="hotelName" name="hotel_name" readonly>
		          <small class="error">Hotel Name Required</small>
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
		          {!! Form::select('num_child', $numberChildren , old('num_child'), array('required')) !!}
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
		          <label for="floor" class="right inline show-for-medium-up">Floor</label>
		          <label for="floor" class="show-for-small-only">Floor</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('floor') }}" id="floor" name="floor" required>
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
		          <label for="numBreakfast" class="right inline show-for-medium-up">Breakfast (In Pax) *</label>
		          <label for="numBreakfast" class="show-for-small-only">Breakfast (In Pax) *</label>
		        </div>
		        <div class="small-12 medium-9 large-1 columns left">
		          {!! Form::select('num_breakfast', array(0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4 ), old('num_breakfast'), array('required')) !!}
		          <small class="error">Breakfast Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="roomDesc" class="right inline show-for-medium-up">Desciption</label>
		          <label for="roomDesc" class="show-for-small-only">Description</label>
		        </div>
		        <div class="small-12 medium-9 large-8 columns left">
		          <textarea id="roomDesc" name="room_desc">{{ old('room_desc') }}</textarea>
		        </div>
		    </div>
		
		    <div class="row">
		    	<table id="tabel">
		    		<tr>
		    			<td>Test</td>
		    		</tr>
		    	</table>
		    </div>

	    	<div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
					<button type="submit" class="button small">{{ empty(old('id')) ? 'Add New Room' : 'Update Room' }}</button>          
		        </div>
		    </div>
	    </form>
    </div>

</div>

@endsection

@section('script')
<script>

var data = [{'nilai' : 'angsa'}, {'nilai' : 'bebek'}];
$.each(data, function(i, item){
	$("#tabel").append('<tr><td>' + item.nilai +'</td></tr>');
});


</script>

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
		$scope.field.comm_type = "{{ old('comm_type') }}";
		$scope.field.rate_type = "{{ old('rate_type', 'Nett') }}";

		$scope.rateTypeChange = function(){
			if($scope.field.rate_type != 'Nett'){
				$scope.field.comm_type = '%';
			} else {
				delete $scope.field.comm_type;
			}
		}
	});
</script>
@stop
