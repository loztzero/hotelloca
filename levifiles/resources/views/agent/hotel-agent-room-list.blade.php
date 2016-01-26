@extends('layouts.foundation-login')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<div class="large-12 columns">
		<a>
			<b style="font-size:18px;">{{ $hotel->hotel_name }}</b>
			<div class="rateit" data-rateit-value="{{ $hotel->star }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
		</a>

		<p style="font-size:13px;">
			{{ $hotel->address }}, {{ $hotel->city }}
		</p>
		
		<div class="large-7">
			<ul class="example-orbit" data-orbit data-options="bullets:false;">
				@foreach($pictures as $picture)
				  <li>
				    <img src="{{ url('http://www.travelmart.com.cn/').$picture->picture_path }}" alt="slide 1" />
				    <div class="orbit-caption">
				      Caption
				    </div>
				  </li>
				@endforeach
			</ul>
		</div>

		<br>
		<u><big>Description</big></u>
		<p style="text-align: justify;">
			{{ $hotel->description }}
		</p>

		<style>
		 .book {background-color: #d80001;margin-bottom:0px;}
		 .book:hover {background-color: #f80000;}
		</style>

		<br>
		<u><big>Rooms</big></u>
		<table class="show-for-medium-up">
			<tr>
				<th>Room Type</th>
				<th>Bed Type</th>
				<th>Breakfast</th>
				<th>CutOff</th>
				<th>Rate</th>
				<th>Book</th>
			</tr>
			@foreach($rooms as $room)
			<tr>
				<td>{{ $room->RoomName }}</td>
				<td>{{ $room->BedType }}</td>
				<td>{{ $room->BF ? $room->BF  }} - Person</td>
				<td>{{ $room->CutOFF }}</td>
				<td>
					<a href="#" data-reveal-id="myModal" ng-click="loadRate({{ json_encode($room->stayDetail) }})">{{ $room->RoomRate }}</a>
				</td>
				<td>
					<button class="button tiny book">Book</button>
				</td>
			</tr>
			@endforeach
		</table>

		<div class="show-for-small">
			@foreach($rooms as $room)
				<table>
					<tr>
						<th>Room Type</th>
						<td>{{ $room->RoomName }}</td>
					</tr>
					<tr>
						<th>Bed Type</th>
						<td>{{ $room->BedType }}</td>
					</tr>
					<tr>
						<th>Breakfast</th>
						<td>{{ $room->BF }} - Person</td>
					</tr>
					<tr>
						<th>CutOff</th>
						<td>{{ $room->CutOFF }}</td>
					</tr>
					<tr>
						<th>Rate</th>
						<td>{{ $room->RoomRate }}</td>
					</tr>
					<tr>
						<th>Book</th>
						<td><button class="button tiny book">Book</button></td>
					</tr>
				</table>
			@endforeach
		</div>
	</div>

	<div class="large-12 column">
		<?php
			echo '<pre>';
			print_r($rooms);
			echo '=========== data rate disini =======================';
			print_r($rate);
		?>

	</div>

	<div id="myModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<p class="lead">Your selected date</p>
		<table>
			<tr>
				<th>Date</th>
				<th>Rate</th>
			</tr>
			<tr ng-repeat="room in field">
				<td>@{{ room.StayDate }}</td>
				<td>@{{ room.Price }}</td>
			</tr>
		</table>
		<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>
</div>

@stop

@section('script')
<script>
var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function ($scope, $http, $filter) {

	$scope.loadRate = function(rates){

		if(angular.isArray(rates)){
			$scope.field = rates;
		} else {
			$scope.field = [rates];
		}
	}


});
</script>
@stop