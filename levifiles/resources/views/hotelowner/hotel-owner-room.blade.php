@extends('layouts.layout-hotel-owner')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<div class="large-12 columns">

		<h3>Hotel Rooms</h3>
		@include('layouts.message-helper')

		<table>
			<caption style="text-align:left;">
				<a href="{{ url('hotel-owner/room-input')}}">Add New Rooms</a>
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
