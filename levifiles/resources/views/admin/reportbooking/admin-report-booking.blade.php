@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Report Booking</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li class="active">Report Booking</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

		<div class="travelo-box">
			<form action="{{ url('/admin/report-booking') }}" method="get" >

				<h3>Hotels</h3>
				@include('layouts.message-helper')
			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Hotel Name</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel_name') }}" id="hotelName" name="hotel_name">
			        </div>

			        <div class="col-xs-6">
			            <label>Confirmation Number</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel_name') }}" id="hotelName" name="hotel_name">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Check In Date From</label>
						<div class="datepicker-wrap">
				            <input type="text" class="input-text full-width date-handle" value="{{ Request::get('check_in_from') }}" id="checkInFrom" name="check_in_from">
						</div>
			        </div>

			        <div class="col-xs-6">
			            <label>Check In Date Until</label>
						<div class="datepicker-wrap">
			            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('check_in_to') }}" id="checkInTo" name="check_in_to">
						</div>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Check Out Date From</label>
						<div class="datepicker-wrap">
			            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('check_out_from') }}" id="checkOutFrom" name="check_out_from">
						</div>
			        </div>

			        <div class="col-xs-6">
			            <label>Check Out Date Until</label>
						<div class="datepicker-wrap">
			            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('check_out_to') }}" id="checkOutTo" name="check_out_to">
						</div>
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
			        <div class="col-xs-6">
			            <label>Status Order</label>
						<div class="selector">
							{!! Form::select('status', array('' => 'All', 'Pending' => 'Pending', 'Confirmed' => 'Confirmed', 'Cancel' => 'Cancel'), Request::get('status_flag'), array('class' => 'full-width')) !!}
						</div>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <button type="submit" class="button small" value="search">Search</button>
			            <button type="submit" class="button small" value="print">Print PDF</button>
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
						<th>Action</th>
						<th>Hotel</th>
						<th>Order Booking</th>
						<th>Guest</th>
						<th>Confirmation Number</th>
						<th>Room Name</th>
						<th>Check In Date</th>
						<th>Night</th>
						<th>Status</th>
						<th>Status Payment</th>
						<th class="td-right">Total Payment</th>
					</tr>
				</thead>
				<tbody>
					@foreach($bookingList as $booking)
					<tr>
						<td>
							<form action="{{URL::to('admin/hotel/load-data')}}" method="post" class="pull-left">
								<input type="hidden" value="{{ csrf_token() }}" name="_token">
				            	<input type="hidden" value="{{ $booking->id }}" name="id">
				            	<button type="submit" class="btn-primary" title="Edit Hotel"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
							</form>
							@if($booking->active_flg == 'Inactive')
								<form action="{{URL::to('admin/hotel/activate-hotel')}}" method="post" class="pull-right">
									<input type="hidden" value="{{ csrf_token() }}" name="_token">
					            	<input type="hidden" value="{{ $booking->id }}" name="id">
					            	<button class="btn-primary" title="Activate the hotel"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></button>
								</form>
							@elseif($booking->active_flg == 'Active')
								<form action="{{URL::to('admin/hotel/deactivate-hotel')}}" method="post" class="pull-right">
									<input type="hidden" value="{{ csrf_token() }}" name="_token">
					            	<input type="hidden" value="{{ $booking->id }}" name="id">
					            	<button class="btn-warning" title="Deadactivated the hotel"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button>
								</form>
							@endif
						</td>
						<td>{{ $booking->hotel_name }}</td>
						<td>{{ $booking->order_no }}</td>
						<td>{{ $booking->title }}. {{ $booking->first_name }} {{ $booking->last_name }}</td>
						<td class="hide-for-small">{{ $booking->no_conf_order }}</td>
						<td class="hide-for-small">{{ $booking->room_name }}</td>
						<td class="hide-for-small">{{ $helpers::dateFormatter($booking->check_in_date) }}</td>
						<td class="hide-for-small">{{ $booking->night }}</td>
						<td class="hide-for-small">{{ $booking->status_flag }}</td>
						<td class="hide-for-small">{{ $booking->status_pymnt }}</td>
						<td class="td-right">{{ number_format($booking->tot_payment, 0, ',', '.') }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7" id="pagination">
							{!! $bookingList->setPath('')->appends(Request::only('hotel_name', 'order_no',
								'check_in_from', 'check_in_to',
								'check_out_from', 'check_out_to',
								'country', 'city', 'status', 'status_payment'))->render() !!}
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
@endsection

@section('script')
<script>
	tjq('.date-handle').datepicker({
	    showOn: 'button',
	    buttonImage: '{{ url("assets/images/icon/blank.png") }}',
	    buttonText: '',
	    buttonImageOnly: true,
	    changeYear: false,
	    dateFormat: "dd-mm-yy",
	    dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
	    beforeShow: function(input, inst) {
	        var themeClass = tjq(input).parent().attr("class").replace("datepicker-wrap", "");
	        tjq('#ui-datepicker-div').attr("class", "");
	        tjq('#ui-datepicker-div').addClass("ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all");
	        tjq('#ui-datepicker-div').addClass(themeClass);
	    }
	});
</script>

<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {

		$scope.field = {};
		$scope.cities = [];
		$scope.getCity = function(){
			console.log($scope.field);
			$http.post('{{url("admin/report-booking/city-from-country")}}', $scope.field).success(function(response){
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
