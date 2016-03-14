@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Hotel Input</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li><a href="{{ url('admin/hotel') }}">Hotels</a></li>
	            <li class="active">Hotel Input</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

		<a href="{{ url('admin/agent-deposit') }}" class="button tiny secondary"><< Back</a><br>
		<div class="travelo-box col-xs-12">
			<form action="{{url('/admin/hotel/save')}}" method="post" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<h3>Deposit Agent Input</h3>
				@include('layouts.message-helper')

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Agent *</label>
			            <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name" required>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-5">
			            <label>Deposit Value *</label>
			            <div class="selector">
			            	{!! Form::select('mst004_id', $currencies, old('mst004_id'), array('required', 'class' => 'selector full-width')) !!}
		            	</div>
			        </div>
			        <div class="col-xs-7">
			            <label>&nbsp;</label>
			            <div class="selector">
			            	<input type="text" class="input-text full-width" value="{{old('meal_price', 0)}}" name="meal_price" id="mealPrice">	
		            	</div>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Used Value</label>
			            <input type="text" class="input-text full-width" value="{{old('meal_price', 0)}}" name="meal_price" id="mealPrice">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Remaining Deposit *</label>
			            <input type="text" class="input-text full-width" value="{{old('bed_price', 0)}}" name="bed_price" id="bedPrice">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <button type="submit" class="button small">Submit</button>
			        </div>
			    </div>

			</form>
		</div>
	</div>
@endsection

@section('script')
<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {


	});

	
</script>
@endsection
