@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Agent Booking List</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li class="active">Agent Booking List</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

		<div class="travelo-box">
			<form action="" method="get" >

                <h3>Agent Booking List</h3>
                @include('layouts.message-helper')

                <div class="row form-group">
                    <div class="col-xs-12">
                        <label>Booking Number</label>
                        <input type="text" class="input-text full-width"  value="{{ Request::get('order_no')}}" id="orderNo" name="order_no">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Check In Date</label>
                        <div class="datepicker-wrap">
                            <input type="text" name="date_from" class="input-text full-width" placeholder="dd-mm-yy" />
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <label>Check Out Date</label>
                        <div class="datepicker-wrap">
                            <input type="text" name="date_to" class="input-text full-width" placeholder="dd-mm-yy" />
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Country</label>
                        <div class="selector">
                            {!! Form::select('country', ['' => 'All'] + $countries->toArray(), null, array('ng-model' => 'field.country', 'ng-change' => 'getCity()', 'class' => 'full-width')) !!}
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <label>City</label>
                        <div class="selector" id="citySelector">
                            <select ng-model="field.city" name="city" id="city">
                                <option value="">All</option>
                                <option ng-repeat="city in cities" value="@{{city.id}}">@{{city.city_name}}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Status Pesanan</label>
                        <div class="selector">
                            {!! Form::select('status', array('' => 'All', 'Pending' => 'Pending', 'Done' => 'Done', 'Cancel' => 'Cancel'), null, array('class' => 'full-width')) !!}
                        </div>
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
						<th>Agent</th>
						<th>Booking Number</th>
						<th>Check In</th>
						<th>Check Out</th>
						<th>Tamu</th>
						<th>Tanggal Pembayaran</th>
						<th>Status</th>
						<th class="td-right">Total Payment</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					@foreach($bookingList as $booking)
                    <tr>
						<td>Agent Name</td>
                        <td>{{ $booking->order_no }}</td>
                        <td>{{ $booking->check_in_date }}</td>
                        <td>{{ $booking->check_out_date }}</td>
                        <td>{{ $booking->first_name }}</td>
                        <td>{{ $booking->transfer_date }}</td>
                        <td>{{ $booking->status_flg }}</td>
                        <td class="td-right">{{ number_format($booking->tot_payment, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ url('agent/booking-history/order-detail/').'/'.$booking->order_no }}" class="button btn-small green">Order Detail</a>
                        </td>
                    </tr>
                    @endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9" id="pagination">
							{!! $bookingList->appends(Request::only('hotel_name', 'date_from', 'date_to', 'country', 'city', 'status'))->render() !!}
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
					tjq('#citySelector span').html('All');
				} else {
					tjq('#citySelector span').html(oldCity[0].city_name);
				}
			})
		}

		$scope.getCity();
    	$scope.field.city = '{{ Request::get("city", '') }}';

	});
</script>
@endsection
