@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Hotel Room Rate</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Hotel</a></li>
	            <li class="active">Hotel Room Rate</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
<div class="container" ng-controller="MainCtrl">
	
	<div class="travelo-box">

		<h3>Hotel Rooms Rate</h3>
		@include('layouts.message-helper')

		<table class="table table-striped">
			<caption style="text-align:left;">
				<i class="soap-icon-roundtriangle-right"></i>&nbsp;&nbsp; <a href="{{ url('hotel/room-rate/input')}}">Add New Room Rate</a>
			</caption>
			<thead>
				<tr>
					<th width="120px">Action</th> 	
					<th>Room Name</th>
					<th>Period</th>
					<th>Daily Price</th>
				</tr>
			</thead>
			<tbody>
			@foreach($rates as $rate)
				<tr>
					<td>
						<form action="{{ url('hotel/room-rate/load-data') }}" method="post" class="left">
							<input type="hidden" value="{{ csrf_token() }}" name="_token">
			            	<input type="hidden" value="{{ $rate->id }}" name="id">
			            	<button type="submit" class="btn-primary" title="Edit Rate"><i class="glyphicon glyphicon-edit"></i></button>
						</form>

						<form action="{{ url('hotel/room-rate/delete')}}" method="post" class="right">
							<input type="hidden" value="{{ csrf_token() }}" name="_token">
			            	<input type="hidden" value="{{ $rate->id }}" name="id">
			            	<button type="submit" class="button red" title="Delete Rate"><i class="glyphicon glyphicon-close"></i></button>
						</form>
					</td>
					<td>{{ $rate->room->room_name }}</td>
					<td>{{ $helpers::dateFormatter($rate->from_date) }} - {{ $helpers::dateFormatter($rate->end_date) }}</td>
					<td align="right">Rp. {{ number_format($rate->daily_price,2,',','.') }}</td>
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

</div>

@endsection

@section('script')
<script>

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

		

	});
</script>
@stop
