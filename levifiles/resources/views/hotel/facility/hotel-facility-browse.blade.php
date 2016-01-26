@extends('layouts.layout-hotel')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<div class="large-12 columns">

		<h3>Facility</h3>
		@include('layouts.message-helper')

		<table>
			<caption style="text-align:left;">
				<a data-reveal-id="myModal">Add New Facility</a>
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
						<form action="{{ url('hotel/facility/delete')}}" method="post" class="right">
							<input type="hidden" value="{{ csrf_token() }}" name="_token">
			            	<input type="hidden" value="{{ $facility->id }}" name="id">
			            	<button type="submit" class="tiny alert rem-btm-margin confirm-delete" title="Delete Rate"><i class="fi-page-delete"></i></button>
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

	@include('hotel.facility.hotel-facility-input-dialog')

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
