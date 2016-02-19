@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Hotel Browse</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li class="active">Hotel Browse</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

		<div class="travelo-box">
			<form action="{{url('/admin/hotel')}}" method="get" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<h3>Hotels</h3>
				@include('layouts.message-helper')
			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Hotel Name</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel_name') }}" id="hotelName" name="hotel_name">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Country</label>
			            {!! Form::select('country', array('' => 'All') + $countries->toArray(), null, array('class' => 'selector full-width', 'ng-model' => 'field.country', 'ng-change' => 'getCity()')) !!}
			        </div>

			        <div class="col-xs-6">
			            <label>City</label>
			            <select ng-model="field.city" name="city" id="city" class="selector full-width">
							<option value="">All</option>
							<option ng-repeat="city in cities" value="@{{city.city_name}}">@{{city.city_name}}</option>
						</select>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <button type="submit" class="button small">Search</button>
			        </div>
			    </div>
			</form>
		</div>

		<div class="travelo-box">
			<table class="table table-striped">
				<caption style="text-align:left;">
					<a href="{{ url('admin/hotel/input')}}" class="view"><i class="soap-icon-roundtriangle-right"></i>&nbsp;&nbsp; Tambah Hotel Baru</a>
				</caption>
				<thead>
					<tr>
						<th width="100px">Action</th> 	
						<th>Hotel Name</th>
						<th class="hide-for-small">Country</th>
						<th class="hide-for-small">City</th>
						<th class="hide-for-small">Address</th>
						<th class="hide-for-small">Phone Number</th>
						<th>Active</th>
					</tr>
				</thead>
				<tbody>
					@foreach($hotelList as $hotel)
					<tr>
						<td>
							<form action="{{URL::to('admin/hotel/load-data')}}" method="post" class="pull-left">
								<input type="hidden" value="{{ csrf_token() }}" name="_token">
				            	<input type="hidden" value="{{ $hotel->id }}" name="id">
				            	<button type="submit" class="btn-primary" title="Edit Hotel"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
							</form>
							@if($hotel->active_flg == 'Inactive')
								<form action="{{URL::to('admin/hotel/activate-hotel')}}" method="post" class="pull-right">
									<input type="hidden" value="{{ csrf_token() }}" name="_token">
					            	<input type="hidden" value="{{$hotel->id}}" name="id">
					            	<button class="btn-primary" title="Activate the hotel"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></button>
								</form>
							@elseif($hotel->active_flg == 'Active')
								<form action="{{URL::to('admin/hotel/deactivate-hotel')}}" method="post" class="pull-right">
									<input type="hidden" value="{{ csrf_token() }}" name="_token">
					            	<input type="hidden" value="{{$hotel->id}}" name="id">
					            	<button class="btn-warning" title="Deadactivated the hotel"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button>
								</form>
							@endif
						</td>
						<td>{{ $hotel->hotel_name }}</td>
						<td class="hide-for-small">{{ $hotel->country->country_name }}</td>
						<td class="hide-for-small">{{ $hotel->city->city_name }}</td>
						<td class="hide-for-small">{{ $hotel->address }}</td>
						<td class="hide-for-small">{{ $hotel->phone_number }}</td>
						<td>
							{{ $hotel->active_flg }}
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7" id="pagination">
							{!! $hotelList->appends(Request::only('hotel_name', 'country', 'city'))->render()!!}
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
@endsection

@section('script')
<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {

		$scope.field = {};
		$scope.cities = [];
		$scope.getCity = function(){
			console.log($scope.field);
			$http.post('{{url("admin/hotel/city-from-country")}}', $scope.field).success(function(response){
				$scope.cities = response;
				$scope.field.city = '{{ old("mst003_id", "") }}';

				var oldCity = $filter('filter')($scope.cities, { id : $scope.field.city }, true);
				if(oldCity.length == 0){
					$scope.field.city = '';
					tjq('#citySelector span').html('Select A City');
				} else {
					tjq('#citySelector span').html(oldCity[0].city_name);
				}
			})
		}

	});
</script>
@endsection
