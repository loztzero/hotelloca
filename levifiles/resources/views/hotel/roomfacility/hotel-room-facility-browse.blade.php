@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Hotel Room Facility</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li>Hotel Room</li>
	            <li class="active">Facility</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
<div class="container" ng-controller="MainCtrl">
	
	<div class="travelo-box">
		<h3>Facility {{ $room->room_name }}</h3>
		@include('layouts.message-helper')

		<table class="table table-striped">
			<caption style="text-align:left;">
				<i class="soap-icon-roundtriangle-right"></i>&nbsp;&nbsp; <a  class="soap-popupbox" href="#modal">Add New Facility</a>
			</caption>
			<thead>
				<tr>
					<th>Action</th> 	
					<th>Facility</th>
				</tr>
			</thead>
			<tbody>
			@foreach($facilities as $facility)
				<tr>
					<td>
						<form action="{{ url('hotel/room-facility/delete')}}" method="post">
							<input type="hidden" value="{{ $room->id }}" name="room_id">
							<input type="hidden" value="{{ csrf_token() }}" name="_token">
			            	<input type="hidden" value="{{ $facility->id }}" name="id">
			            	<button type="submit" class="button red confirm-delete" title="Delete Rate"><i class="glyphicon glyphicon-remove"></i></button>
						</form>
					</td>
					<td>{{ $facility->facility }}</td>
				</tr>
			@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						
					</td>
				</tr>
			</tfoot>
		</table>
	</div>

	@include('hotel.roomfacility.hotel-room-facility-input-dialog')

</div>

@endsection

@section('script')
<script>

tjq(".confirm-delete").on("click", function(e) {
	e.preventDefault();
	var form = tjq(this).parents('form');
	swal({   
		title: "Are you sure?",   
		text: "This picture will be deleted",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#f04124",   
		confirmButtonText: "Yes, delete it!", 
		confirmButtonClass: 'normal-lh',   
		cancelButtonClass: 'normal-lh', 
		closeOnConfirm: false }, 
	function(confirmed){   
		if (confirmed) form.submit();
	});

});

	

</script>
<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {


	});
</script>
@stop
