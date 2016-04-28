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
			<form>

        </form>

			<form action="{{url('/admin/hotel-vs-user')}}" method="get" >
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
					<a href="{{ url('admin/hotel-vs-user/input')}}" class="view"><i class="soap-icon-roundtriangle-right"></i>&nbsp;&nbsp; Tambah Hotel Baru</a>
				</caption>
				<thead>
					<tr>
						<th width="100px">Action</th>
						<th>Hotel Name</th>
						<th class="hide-for-small">Country</th>
						<th class="hide-for-small">City</th>
						<th class="hide-for-small">Address</th>
						<th class="hide-for-small">Phone Number</th>
						<th class="hide-for-small">Created At</th>
						<th class="hide-for-small">Updated At</th>
						<th>Active</th>
						<th>Facilities And Rooms</th>
					</tr>
				</thead>
				<tbody>
					@foreach($hotelList as $hotel)
					<tr>
						<td>
							<form action="{{URL::to('admin/hotel-vs-user/load-data')}}" method="post" class="pull-left">
								<input type="hidden" value="{{ csrf_token() }}" name="_token">
				            	<input type="hidden" value="{{ $hotel->id }}" name="id">
				            	<button type="submit" class="btn-primary" title="Edit Hotel"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
							</form>
						</td>
						<td>{{ $hotel->hotel_name }}</td>
						<td class="hide-for-small">{{ $hotel->country_name }}</td>
						<td class="hide-for-small">{{ $hotel->city_name }}</td>
						<td class="hide-for-small">{{ $hotel->address }}</td>
						<td class="hide-for-small">{{ $hotel->phone_number }}</td>
						<td class="hide-for-small">{{ $hotel->created_at }}</td>
						<td class="hide-for-small">{{ $hotel->updated_at }}</td>
						<td>
							{{ $hotel->active_flg }}
						</td>
						<td>
							<a href="{{ url('admin/hotel-vs-user/facility') . '?hotel=' . $hotel->id }}" class="button btn-small sky-blue2">Add Facility</a>
							<a href="{{ url('admin/hotel-vs-user/room') . '?hotel=' . $hotel->id }}" class="button btn-small sky-blue2">Add Rooms</a><br><br>
							<a href="{{ url('admin/hotel-vs-user/picture') . '?hotel=' . $hotel->id }}" class="button btn-small sky-blue2">Add Picture</a>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="8" id="pagination">
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
		$scope.field.country = "{{ Request::input('country', '') }}";
		$scope.cities = [];
		$scope.getCity = function(){
			console.log($scope.field);
			$http.post('{{url("admin/hotel/city-from-country")}}', $scope.field).success(function(response){
				$scope.cities = response;
				$scope.field.city = '{{ Request::input("city", "") }}';

				var oldCity = $filter('filter')($scope.cities, { city_name : $scope.field.city }, true);
				if(oldCity.length == 0){
					$scope.field.city = '';
					tjq('#citySelector span').html('Select A City');
				} else {
					tjq('#citySelector span').html(oldCity[0].city_name);
				}
			})
		}

		$scope.getCity();

	});
</script>
@endsection
