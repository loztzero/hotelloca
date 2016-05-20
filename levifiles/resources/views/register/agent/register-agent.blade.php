@extends('layouts.general-travel-layout')
@section('content')
<div class="container" ng-controller="MainCtrl">

	<div class="travelo-box">

		<h3>Register as Agent</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="POST" action="{{ url('register/agent/save') }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group">
				<div class="col-xs-12">
		            <label>Company Name *</label>
		          	<input type="text" class="input-text full-width" value="{{ old('comp_name') }}" id="compName" name="comp_name" required>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-12">
		            <label>Address *</label>
		          	<textarea type="text" class="input-text full-width" id="address" name="address" required>{{ old('address') }}</textarea>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-12">
		            <label>Postcode *</label>
		          	<input type="text" class="input-text full-width" value="{{ old('postcode') }}" id="postCode" name="postcode" required>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-6">
					<label for="country" class="right inline show-for-medium-up">Country *</label>
			        <div class="selector">
		        		{!! Form::select('country', $countries, null, array('ng-model' => 'field.country', 'ng-change' => 'getCity()', 'required', 'class' => 'full-width')) !!}
			        </div>
			    </div>

			    <div class="col-xs-6">
		            <label>City *</label>
		            <div class="selector" id="citySelector">
			            <select ng-model="field.city" name="city" required id="city" class="full-width">
				          	<option value="">Select A City</option>
				          	<option ng-repeat="city in cities" value="@{{city.id}}" ng-selected="field.city == city.id">@{{city.city_name}}</option>
			          	</select>
			          </div>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-12">
		            <label>Phone Number *</label>
		          	<input type="text" class="input-text full-width" value="{{ old('phone_number') }}" id="phoneNumber" name="phone_number" required>
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-12">
		            <label>Fax No</label>
		          	<input type="text" class="input-text full-width" value="{{ old('fax_number') }}" id="faxNumber" name="fax_number" >
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-12">
		            <label>Email Address *</label>
		          	<input type="email" class="input-text full-width" value="{{ old('email') }}" id="email" name="email" >
		        </div>
		    </div>

		    <div class="form-group">
				<div class="col-xs-12">
		            <label>Website</label>
		          	<input type="text" class="input-text full-width" value="{{ old('website') }}" id="website" name="website" >
		        </div>
		    </div>

		    <div class="form-group">
		    	<div class="col-xs-12">
			    	<input type="checkbox">
			    	<small>&nbsp; Check for agreed to the <a href="#">Terms & Conditions</a></small>
		    	</div>
		    </div>

	    	<div class="form-group">
				<div class="col-xs-12">
					<button type="submit" class="button small">Register</button>
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
		$scope.field.country = '{{$indonesia}}';
		$scope.cities = [];
		$scope.getCity = function(){
			$http.post('{{url("/auth/city-from-country")}}', $scope.field).success(function(response){
				$scope.cities = response;
				$scope.field.city = '';
				// console.log(response);

			})
		}
		$scope.getCity();
		$scope.field.city = '{{old("city")}}';

	});
</script>
@stop
