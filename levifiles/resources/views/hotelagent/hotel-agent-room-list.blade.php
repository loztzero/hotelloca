@extends('layouts.frontangular')
@section('content')
<div class="row" ng-controller="MainCtrl">

<form method="post" action="{{App::make('url')->to('/hotel/search')}}">
	<div class="form-group">
		<label class="control-label">Hotels</label>
		 <select class="form-control" name="hotel">
			@if(isset($hotels->Hotels))
				@foreach($hotels->Hotels As $key=>$value)
				<option value="{{$value->HotelID}}">{{ $value->HotelName }}</option>
				@endforeach
			@endif
		 </select>
	</div>

	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<button type="submit" class="btn btn-primary">Get Hotel Detail</button>
</form>


@if(isset($rooms) && isset($rooms->Rooms))
<table class="table table-striped">
	<tr>
		<th>Room Name</th>
		<th>Bed Type</th>
		<th>Action</th>
	</tr>
	@if(is_array($rooms->Rooms))
		@foreach($rooms->Rooms As $key=>$value)
		<tr>
			<td>{{$value->RoomName}}</td>
			<td>{{$value->BedType}}</td>
			<td>
				<button class="btn btn-primary btn-sm">Add To Cart</button>
			</td>
		</tr>
		@endforeach
	@else
		<tr>
			<td>
				{{ $rooms->Rooms->RoomName }}
			</td>
			<td>
				{{ $rooms->Rooms->RoomName }}
			</td>
			<td>
				<button class="btn btn-primary btn-sm">Add To Cart</button>
			</td>
		</tr>
	@endif
</table>
@endif

@stop

@section('script')
<script>
var app = angular.module("ui.boardingpassku", ['ngSanitize']);
app.controller("MainCtrl", function ($scope, $http, $filter) {


});
</script>
@stop