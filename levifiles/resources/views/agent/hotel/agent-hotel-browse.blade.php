@extends('layouts.general-travel-layout')

@section('bigSlideshow')
@include('layouts.general-travel-slideshow')
@endsection

@section('content')

<div class="search-box-wrapper" ng-controller="MainCtrl">
    <div class="search-box container">
        <ul class="search-tabs clearfix">
            <li class="active"><a href="#hotels-tab" data-toggle="tab">HOTELS</a></li>
        </ul>
        <div class="visible-mobile">
            <ul id="mobile-search-tabs" class="search-tabs clearfix">
                <li class="active"><a href="#hotels-tab">HOTELS</a></li>
            </ul>
        </div>
        
        <div class="search-tab-content">
            <div class="tab-pane fade active in" id="hotels-tab">
                <form method="get" action="{{ url('agent/hotel/search') }}">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-3">
                            <h4 class="title">Where</h4>
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Nationality</label>
                                    <div class="selector">
                                        {!! Form::select('nationality', $countries2, old('nationality', 'Indonesia'), array('required', 'class' => 'full-width')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label>Country</label>
                                    <div class="selector">
                                        {!! Form::select('country', $countries, null, array('ng-model' => 'field.country', 'ng-change' => 'getCity()', 'required', 'class' => 'full-width')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label>City</label>
                                    <div class="selector" id="citySelector">
										<select ng-model="field.city" name="city" required id="city">
											<option value=""></option>
											<option ng-repeat="city in cities" value="@{{city.id}}">@{{city.city_name}}</option>
										</select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label>Hotel Name</label>
                                    <div class="selector" id="citySelector">
                                        <input type="text" name="hotel_name" class="input-text full-width">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6 col-md-4">
                            <h4 class="title">When</h4>
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Check In</label>
                                    <div class="datepicker-wrap">
                                        <input type="text" name="date_from" class="input-text full-width" placeholder="dd-mm-yy" value="{{ date('d-m-Y') }}" required />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label>Check Out</label>
                                    <div class="datepicker-wrap">
                                        <input type="text" name="date_to" class="input-text full-width" placeholder="dd-mm-yy" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6 col-md-3">
                            <h4 class="title">Who</h4>
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Rooms</label>
                                    <div class="selector">
                                        {!! Form::select('room', array('1' => '01', '2' => '02', '3' => '03', '4' => '04'), null, array('class' => 'full-width')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <label>Adults</label>
                                    <div class="selector">
                                        {!! Form::select('adults', array('1' => '01', '2' => '02', '3' => '03', '4' => '04'), null, array('class' => 'full-width')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <label>Kids</label>
                                    <div class="selector">
                                        {!! Form::select('child', array('0' => '00', '1' => '01', '2' => '02', '3' => '03', '4' => '04'), null, array('class' => 'full-width')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6 col-md-2 fixheight">
                            <label class="hidden-xs">&nbsp;</label>
                            <button type="submit" class="full-width icon-check animated" data-animation-type="bounce" data-animation-duration="1">SEARCH NOW</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>

var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function ($scope, $http, $filter) {

	$scope.field = {};
	$scope.field.passport = '{{ $indonesia->id }}';
	$scope.field.country = '{{ $indonesia->id }}';
	$scope.cities = [];
	$scope.getCity = function(){
		$http.post('{{ url("agent/hotel/city-from-country") }}', $scope.field).success(function(response){
			$scope.cities = response;
			$scope.field.city = '';
			tjq('#citySelector span').html('');
			// console.log(response);
		})
	}

	$scope.getCity();
	$scope.field.city = '{{old("city")}}';

});

// app.directive('helloWorld', function(){
// 	return {
// 		restrict : 'E',
// 		templateUrl : "{{url('/assets/directivepartial')}}/hello.html"
// 	}
// })
</script>
@stop