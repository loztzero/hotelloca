@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Hotel Input</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li><a href="{{ url('admin/hotel-vs-user') }}">Hotel Vs User</a></li>
	            <li class="active">Hotel Input</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

		<a href="{{ url('admin/hotel-vs-user') }}" class="button tiny secondary"><< Back</a><br>
		<div class="travelo-box col-xs-12 col-md-8">
			<form action="{{url('/admin/hotel-vs-user/save')}}" method="post" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				@if(!empty(old('id')))
					<input type="hidden" name="id" value="{{ old('id') }}">
				@endif

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
			            <label>Type *</label>
			            <div class="selector">
		             		{!! Form::select('types', $hotelTypes , old('types'), array('required', 'class' => 'full-width')) !!}
			            </div>
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
				           <select ng-model="field.city" name="mst003_id" required id="city" class="full-width" ng-change="cityChange()">
					          	<option value="">Select A City</option>
					          	<option ng-repeat="city in cities" value="@{{city.id}}" ng-selected="field.city == city.id">@{{city.city_name}}</option>
				          	</select>
			          	</div>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Postcode *</label>
			            <input type="text" class="input-text full-width" value="{{old('postcode')}}" id="postCode" name="postcode" required>
			        </div>

					<div class="col-xs-6">
			            <label>Location *</label>
			            <div class="selector" id="locationSelector">
				            <select ng-model="field.location" name="mst030_id" id="location" class="full-width">
					          	<option value="">Select A Location</option>
					          	<option ng-repeat="location in locations" value="@{{location.id}}" ng-selected="field.location == location.id">@{{location.area}} - @{{location.location}}</option>
				          	</select>
				          </div>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Landmark Name</label>
			            <input type="text" class="input-text full-width" value="{{old('landmark_name')}}" id="landmarkName" name="landmark_name">
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
			            <input type="text" class="input-text full-width"  value="{{old('fax_number')}}" id="faxNumber" name="fax_number">
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
			            <input type="text" class="input-text full-width" value="{{ number_format(old('meal_price', 0), 0, ',', '.') }}" name="meal_price" id="mealPrice">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Bed Price *</label>
			            <input type="text" class="input-text full-width" value="{{ number_format(old('bed_price', 0), 0, ',', '.') }}" name="bed_price" id="bedPrice">
			        </div>
			    </div>

			    <div class="row form-group">
			    	<div class="col-xs-12">
			    		<input type="hidden" value="@{{ field.group_flg }}" name="group_flg" >
				    	<input type="checkbox" class="pull-left" ng-model="field.group_flg" ng-true-value="'Yes'" ng-false-value="'No'">
				    	<label class="pull-left">&nbsp; Part Of Group</label>
			    	</div>
			    </div>

			    <div class="row form-group" ng-show="field.group_flg == 'Yes'">
					<div class="col-xs-12">
			          	<label>Group Name</label>
			          	<input type="text" class="input-text full-width" value="{{ old('group_name') }}" id="groupName" name="group_name">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
		            	<label>Description Hotel</label>
						<textarea name="description" id="description" rows="10">
			                {{ old('description') }}
			            </textarea>
			            <script>
			                // Replace the <textarea id="editor1"> with a CKEditor
			                // instance, using default configuration.
			                CKEDITOR.replace( 'description' );
							CKEDITOR.config.removePlugins = 'about, link';
			            </script>
			        </div>
			    </div>

			    <hr />

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
		$scope.locations = [];
		$scope.getCity = function(){
			console.log($scope.field);
			$http.post('{{url("admin/hotel/city-from-country")}}', $scope.field).success(function(response){
				$scope.cities = response;
				$scope.field.city = '{{ old("mst003_id", "") }}';
				$scope.field.location = '{{ old("mst030_id", "") }}';

				var oldCity = $filter('filter')($scope.cities, { id : $scope.field.city }, true);
				if(oldCity.length == 0){
					$scope.field.city = '';
					tjq('#citySelector span').html('Select A City');
				} else {
					tjq('#citySelector span').html(oldCity[0].city_name);

					//for load location list
					$scope.locations = oldCity[0].locations;
					//track if have location value
					var oldLocation = $filter('filter')($scope.locations, { id : $scope.field.location }, true);
					if(oldLocation.length == 0){
						$scope.field.location = '';
						tjq('#locationSelector span').html('Select A Location');
					} else {
						tjq('#locationSelector span').html(oldLocation[0].area + ' - ' + oldLocation[0].location);
					}
				}
			})
		}

		$scope.getCity();

		$scope.cityChange = function(){
			if($scope.field.city != ''){
				var currentCity = $filter('filter')($scope.cities, { id : $scope.field.city }, true);
				$scope.field.location = '';
				$scope.locations = currentCity[0].locations;
				tjq('#locationSelector span').html('Select A Location');
			}
		}

	});


</script>
@endsection
