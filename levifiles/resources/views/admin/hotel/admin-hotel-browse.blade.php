@extends('layouts.layout-hotel-admin')
@section('content')

<div class="row" ng-controller="MainCtrl">
	<div class="large-12 columns">

		<h3>Browse Hotels</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="get" action="{{url('/admin/hotel/input')}}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="large-3 medium-3 columns">
					<label for="orderNo" class="right inline show-for-medium-up">Hotel Name
					</label>
					<label for="orderNo" class="show-for-small-only">Hotel Name</label>
				</div>
				<div class="small-12 medium-9 large-4 columns left">
					<input type="text" name="hotel_name" id="orderNo" value="{{ Request::get('hotel_name') }}" >
				</div>
			</div>

			<div class="row">
				<div class="large-3 medium-3 columns">
					<label for="right-label" class="right inline show-for-medium-up">Country</label>
					<label for="right-label" class="show-for-small-only">Country</label>
				</div>
				<div class="small-12 medium-9 large-4 columns left">
					{!! Form::select('country', array('' => 'All') + $countries->toArray(), null, array('ng-model' => 'field.country', 'ng-change' => 'getCity()')) !!}
				</div>
			</div>

			<div class="row">
				<div class="large-3 medium-3 columns">
					<label for="right-label" class="right inline show-for-medium-up">City</label>
					<label for="right-label" class="show-for-small-only">City</label>
				</div>
				<div class="small-12 medium-9 large-4 columns left">
					<select ng-model="field.city" name="city" id="city">
						<option value="">All</option>
						<option ng-repeat="city in cities" value="@{{city.city_name}}">@{{city.city_name}}</option>
					</select>
				</div>
			</div>


			<div class="row">
				<div class="small-12 medium-9 large-4 large-offset-3 medium-offset-3 columns left">
					<button type="submit" class="button small">Search</button>
				</div>
			</div>
		</form>

		<table>
			<caption style="text-align:left;">
				<a href="{{ url('admin/hotel/input')}}">Tambah Hotel Baru</a>
			</caption>
			<thead>
				<tr>
					<th width="120px">Action</th> 	
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
						<form action="{{URL::to('admin/hotel/load-data')}}" method="post" class="left">
							<input type="hidden" value="{{ csrf_token() }}" name="_token">
			            	<input type="hidden" value="{{ $hotel->id }}" name="id">
			            	<button type="submit" class="tiny rem-btm-margin" title="Edit Hotel"><i class="fi-page-edit"></i></button>
						</form>
						@if($hotel->active_flg == 'Inactive')
							<form action="{{URL::to('admin/hotel/activate-hotel')}}" method="post" class="right">
								<input type="hidden" value="{{ csrf_token() }}" name="_token">
				            	<input type="hidden" value="{{$hotel->id}}" name="id">
				            	<button class="tiny rem-btm-margin" title="Activate the hotel"><i class="fi-checkbox"></i></button>
							</form>
						@elseif($hotel->active_flg == 'Active')
							<form action="{{URL::to('admin/hotel/deactivate-hotel')}}" method="post" class="right">
								<input type="hidden" value="{{ csrf_token() }}" name="_token">
				            	<input type="hidden" value="{{$hotel->id}}" name="id">
				            	<button class="tiny warning rem-btm-margin" title="Deadactivated the hotel"><i class="fi-x-circle"></i></button>
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
						{!! str_replace('/?', '?', $hotelList->appends(Request::only('hotel_name', 'country', 'city'))->render())!!}
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">

$('#transferDate').fdatepicker({
	format : 'dd-mm-yyyy'
});

//set default date
$('#transferDate').fdatepicker('setDate', new Date());


$(window).resize(function() {
  windowsize = $(window).width();
  if (windowsize < 641) {
  	$('#pagination').attr("colspan", 3);
  } else {
  	$('#pagination').attr("colspan", 7);
  }
});

</script>

<script>

var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function ($scope, $http, $filter) {

	$scope.field = {};
	$scope.field.country = "{{ Request::input('country') }}";
	$scope.cities = [];
	$scope.getCity = function(){
		$http.post('{{url("/admin/hotel/city-from-country")}}', $scope.field).success(function(response){
			$scope.cities = response;
			$scope.field.city = "{{ Request::input('city', '') }}";
			// console.log(response);
		})
	}

	$scope.getCity();

});

// app.directive('helloWorld', function(){
// 	return {
// 		restrict : 'E',
// 		templateUrl : "{{url('/assets/directivepartial')}}/hello.html"
// 	}
// })
</script>
@stop