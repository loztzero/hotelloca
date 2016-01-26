@extends('layouts.foundation-angular')
@section('content')
<div class="row" ng-controller="MainCtrl">
	<h3>Register as Agent</h3>

{{-- 	@if(Session::get('error'))
		@foreach(Session::get('error') as $key => $value)
		{{$value}}<br>
		@endforeach
	@endif --}}
	@include('layouts.message-helper')

	<div class="large-12 colums">
		<form class="form-horizontal" role="form" method="POST" action="{{App::make('url')->to('/')}}/auth/save" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="compName" class="right inline show-for-medium-up">Company Name *</label>
		          <label for="compName" class="show-for-small-only">Company Name *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('comp_name')}}" id="compName" name="comp_name" required>
		          <small class="error">Company Name Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="address" class="right inline show-for-medium-up">Address *</label>
		          <label for="address" class="show-for-small-only">Address *</label>
		        </div>
		        <div class="small-12 medium-9 large-7 columns left">
		          <textarea id="address"style="height:5em;" required name="address">{{old('address')}}</textarea>
		          <small class="error">Address Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="postCode" class="right inline show-for-medium-up">Postcode *</label>
		          <label for="postCode" class="show-for-small-only">Postcode *</label>
		        </div>
		        <div class="small-12 medium-9 large-3 columns left">
		          <input type="text" class="span2" value="{{old('postcode')}}" id="postCode" name="postcode" required>
		          <small class="error">Postcode Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="country" class="right inline show-for-medium-up">Country *</label>
		          <label for="country" class="show-for-small-only">Country *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          {!! Form::select('country', $countries, null, array('ng-model' => 'field.country', 'ng-change' => 'getCity()', 'required')) !!}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="city" class="right inline show-for-medium-up">City *</label>
		          <label for="city" class="show-for-small-only">City *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <select ng-model="field.city" name="city" required id="city">
		          	<option value=""></option>
		          	<option ng-repeat="city in cities" value="@{{city.id}}">@{{city.city_name}}</option>
		          </select>
		          <small class="error">City must be selected</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="phoneNumber" class="right inline show-for-medium-up">Phone Number *</label>
		          <label for="phoneNumber" class="show-for-small-only">Phone Number *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('phone_number')}}" id="phoneNumber" name="phone_number" required>
		          <small class="error">Phone number required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="faxNumber" class="right inline show-for-medium-up">Fax No</label>
		          <label for="faxNumber" class="show-for-small-only">Fax No</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('fax_number')}}" id="faxNumber" name="fax_number">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="email" class="right inline show-for-medium-up">Email Address *</label>
		          <label for="email" class="show-for-small-only">Email Address *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="email" class="span2" value="{{old('email')}}" id="email" name="email" required>
		          <small class="error">Email required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="website" class="right inline show-for-medium-up">Website</label>
		          <label for="website" class="show-for-small-only">Website</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('website')}}" id="website">
		        </div>
		    </div>

		    <div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
					<input id="checkbox1" type="checkbox">
					<small>
						Check for agreed to the <a href="#">Terms & Conditions</a>
					</small>		          
		        </div>
		    </div>

	    	<div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
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
