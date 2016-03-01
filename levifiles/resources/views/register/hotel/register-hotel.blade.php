@extends('layouts.general-travel-layout')
@section('content')
<div class="container" ng-controller="MainCtrl">
	

	<div class="travelo-box">

		<h3>Register as Hotel</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="POST" action="{{ url('register/hotel/save') }}" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			@if(!empty(old('id')))
				<input type="hidden" value="{{ old('id')}}" name="id">
			@endif

			<div class="form-group">
				<div class="col-xs-12">
		            <label>Hotel Name *</label>
		          	<input type="text" class="input-text full-width" value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name" required>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-6">
		            <label>Star *</label>
		            <div class="selector">
	             		{!! Form::select('star', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5') , old('star'), array('required', 'class' => 'full-width')) !!}
		            </div>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
	            	<label>Address *</label>
	           		<textarea id="address" class="full-width" required name="address">{{old('address')}}</textarea>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-6">
		            <label>Country *</label>
		            <div class="selector">
		            {!! Form::select('mst002_id', $countries, null, array('ng-model' => 'field.country', 'ng-change' => 'getCity()', 'required', 'class' => 'full-width')) !!}
	            	</div>
		        </div>

		        <div class="col-xs-6">
		            <label>City *</label>
		            <div class="selector" id="citySelector">
			            <select ng-model="field.city" name="mst003_id" required id="city" class="full-width">
				          	<option value="">Select A City</option>
				          	<option ng-repeat="city in cities" value="@{{city.id}}" ng-selected="field.city == city.id">@{{city.city_name}}</option>
			          	</select>
			          </div>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Postcode *</label>
		            <input type="text" class="input-text full-width" value="{{old('postcode')}}" id="postCode" name="postcode" required>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Landmark Name</label>
		            <input type="text" class="input-text full-width" value="{{old('landmark_name')}}" id="landmarkName" name="landmark_name" required>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Phone Number *</label>
		            <input type="text" class="input-text full-width" value="{{old('phone_number')}}" id="phoneNumber" name="phone_number" required>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Fax No</label>
		            <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" value="{{old('fax_number')}}" id="faxNumber" name="fax_number">
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Email *</label>
		            <input type="text" class="input-text full-width" value="{{old('email')}}" id="email" name="email" required>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Website</label>
		            <input type="text" class="input-text full-width"  value="{{old('website')}}" name="website" id="website">
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-6">
		            <label>Currency *</label>
		            <div class="selector">
		            	{!! Form::select('mst004_id', $currencies, old('mst004_id'), array('required', 'class' => 'selector full-width')) !!}
	            	</div>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Meal Price *</label>
		            <input type="text" class="input-text full-width" value="{{ old('meal_price', 0) }}" name="meal_price" id="mealPrice">
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Bed Price *</label>
		            <input type="text" class="input-text full-width" value="{{ old('bed_price', 0)}}" name="bed_price" id="bedPrice">
		        </div>
		    </div>

		    <div class="form-group">
		    	<div class="col-xs-12">
		    		<input type="hidden" value="@{{ field.group_flg }}" name="group_flg" >
			    	<input type="checkbox" class="pull-left" ng-model="field.group_flg" ng-true-value="'Yes'" ng-false-value="'No'"> 
			    	<label class="pull-left">&nbsp; Part Of Group</label>
		    	</div>
		    </div>

		    <div class="form-group" ng-show="field.group_flg == 'Yes'">
				<div class="col-xs-12">
		          	<label>Group Name</label>
		          	<input type="text" class="input-text full-width" value="{{ old('group_name') }}" id="groupName" name="group_name">
		        </div>
		    </div>


		    <div class="row form-group">
		        <div class="col-xs-12">
	            	<label>Description Hotel</label>
	           		<textarea id="description" class="full-width" name="description">{{ old('description') }}</textarea>
		        </div>
		    </div>

		    <hr />

	    	<h3>Login</h3>

	    	<div class="row form-group">
		        <div class="col-xs-12">
		            <label>Email *</label>
		            <input type="email" class="input-text full-width" value="{{ old('email_login') }}" name="email_login" id="emailLogin" required {{ !empty(old('id')) ? 'readonly' : '' }} placeholder="Your Login Email">
		        </div>
		    </div>

		    @if(empty(old('id')))
			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Password *</label>
			            <input type="password" class="input-text full-width" id="passwordLogin" name="password" required placeholder="At least 6 Digit">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Confirm Password *</label>
			            <input type="password" class="input-text full-width" id="rePasswordLogin" name="repassword" required placeholder="Must same with Password">
			        </div>
			    </div>
		    @endif

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <button type="submit" class="button small">{{ empty(old('id')) ? 'Register' : 'Update' }}</button>
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

		$scope.field = {};
		$scope.field.country = '{{ old("mst002_id", $indonesia) }}';
		$scope.field.group_flg = '{{ old("group_flg", "No") }}';
		$scope.cities = [];
		$scope.getCity = function(){
			console.log($scope.field);
			$http.post('{{url("register/hotel/city-from-country")}}', $scope.field).success(function(response){
				$scope.cities = response;
				$scope.field.city = '{{ old("mst003_id", "") }}';

				var oldCity = $filter('filter')($scope.cities, { id : $scope.field.city }, true);
				if(oldCity.length == 0){
					$scope.field.city = '';
					tjq('#citySelector span').html('Select A City');
				} else {
					tjq('#citySelector span').html(oldCity[0].city_name);
				}
				console.log(oldCity);
			})
		}

		$scope.getCity();

	});
</script>
@stop
