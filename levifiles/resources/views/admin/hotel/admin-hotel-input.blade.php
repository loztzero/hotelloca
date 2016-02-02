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

		<a href="{{ url('admin/hotel') }}" class="button tiny secondary"><< Back</a>
		<div class="travelo-box col-xs-12 col-md-8">
			<form action="{{url('/admin/hotel/save')}}" method="post" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<h3>Hotel Input</h3>
				@include('layouts.message-helper')

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Hotel Name *</label>
			            <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name" required>
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
			            <label>Hotel Name *</label>
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
			            <div class="selector">
				            <select ng-model="field.city" name="mst003_id" required id="city" class="selector full-width">
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
			            <input type="text" class="input-text full-width" value="{{old('meal_price')}}" name="meal_price" id="mealPrice">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Bed Price *</label>
			            <input type="text" class="input-text full-width" value="{{old('bed_price')}}" name="bed_price" id="bedPrice">
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
		$scope.cities = [];
		$scope.getCity = function(){
			console.log($scope.field);
			$http.post('{{url("admin/hotel/city-from-country")}}', $scope.field).success(function(response){
				$scope.cities = response;
				$scope.field.city = '{{ old("mst003_id", "") }}';
				tjq('#citySelector span').html('{{ old("mst003_id", "") }}');

				var oldCity = $filter('filter')($scope.cities, { id : $scope.field.city });
				if(oldCity.length == 0){
					$scope.field.city = '';
					tjq('#citySelector span').html('');
				}

			})
		}

		$scope.getCity();

	});
</script>
@endsection
