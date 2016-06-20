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

	<a href="{{ url('hotel/room') }}" class="button">Back</a>

	<div class="travelo-box">
		<h3>Hotel Rooms</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="POST" action="{{ url('hotel/room/save') }}" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			@if(!empty(old('id')))
				<input type="hidden" value="{{ old('id')}}" name="id">
			@endif

			<input type="hidden" value="{{ $profile->id }}" name="mst020_id">
			<div class="form-group">
				<div class="col-xs-12">
		          	<label for="hotelName">Hotel Picture</label>
		         	<input type="file" name="image" />
		         </div>
		    </div>

		    @if(!empty(old('id')))
		    	@if(File::exists('./uploads/hotels/'. old('mst020_id'). '/'.old('id').'/room.jpg'))
		    		<div class="form-group">
						<div class="col-xs-12">
				          	<a class="th" role="button" aria-label="Thumbnail" href="{{ url().'/uploads/hotels/'. old('mst020_id'). '/'.old('id').'/room.jpg' }}" data-lightbox="image-1" data-title="{{ old('room_name') }}">
								<img src="{{ url().'/uploads/hotels/'. old('mst020_id'). '/'.old('id').'/room.jpg' }}">
							</a>
				         </div>
				    </div>
			    @endif
		    @endif

		    <div class="form-group">
				<div class="col-xs-12">
		          	<label>Hotel Name</label>
		         	<input type="text" class="input-text full-width" value="{{ $profile->hotel_name }}" id="hotelName" name="hotel_name" readonly>
		         </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-12">
		          	<label>Room Name</label>
		         	<input type="text" class="input-text full-width" value="{{ old('room_name') }}" id="hotelName" name="room_name" required>
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
			         	{!! Form::select('bed_type', Config::get('enums.bedTypes') , old('bed_type'), array('required', 'id' => 'bedType', 'class' => 'full-width')) !!}
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
		          	<input type="text" class="input-text full-width" value="{{ old('net_fee', 0) }}" id="netFee" name="net_fee" required>
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
					<script>
						// Replace the <textarea id="editor1"> with a CKEditor
						// instance, using default configuration.
						CKEDITOR.replace( 'roomDesc' );
						CKEDITOR.config.removePlugins = 'about, link';
					</script>
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
