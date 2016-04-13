@extends('layouts.general-travel-layout')

@section('titleContainer')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">My Booking</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="#">Agent</a></li>
                <li class="active">My Booking</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" ng-controller="MainCtrl">
        <div class="travelo-box col-xs-12">
            <form action="" method="get" >

                <h3>My Booking</h3>
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

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No Booking</th>
                        <th class="hide-for-small">Check In</th>
                        <th class="hide-for-small">Check Out</th>
                        <th>Tamu</th>
                        <th class="hide-for-small">Tanggal Pembayaran</th>
                        <th class="hide-for-small">Status</th>
                        <th class="hide-for-small td-right">Total Pembayaran</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingList as $booking)
                    <tr>
                        <td>{{ $booking->order_no }}</td>
                        <td>{{ $booking->check_in_date }}</td>
                        <td>{{ $booking->check_out_date }}</td>
                        <td>{{ $booking->first_name }}</td>
                        <td>{{ $booking->transfer_date }}</td>
                        <td>{{ $booking->status_flg }}</td>
                        <td class="td-right">{{ number_format($booking->tot_payment, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ url('agent/booking-history/order-detail/').'/'.$booking->order_no }}" class="button btn-small green">Order Detail</a>
                            <a href="{{ url('agent/booking-history/invoice/').'/'.$booking->order_no }}" class="button btn-small green">Invoice</a>
                            @if($booking->status_flag == 'Cancel' && $booking->status_pymnt == 'Pending' && $booking->show_cancel)
                                <a href="{{ url('agent/booking-history/order-detail/').'/'.$booking->order_no }}" class="button btn-small green">Cancel</a>
                            @endif
                            @if($booking->status_pymnt == 'Pending')
                                <a href="{{ url('agent/booking-history/order-detail/').'/'.$booking->order_no }}" class="button btn-small green">Payment</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" id="pagination">
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
    	$scope.field.country = "{{ Request::get('country') }}";
    	$scope.cities = [];
    	$scope.getCity = function(){
    		$http.post('{{ url("agent/hotel/city-from-country") }}', $scope.field).success(function(response){
    			$scope.cities = response;
    			$scope.field.city = '';
    			tjq('#citySelector span').html('All');
    			// console.log(response);
    		})
    	}

    	$scope.getCity();
    	$scope.field.city = '{{ Request::get("city", '') }}';

    });


</script>
@endsection
