@extends('layouts.general-travel-layout')

@section('titleContainer')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Report Booking</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="#">Hotel</a></li>
                <li class="active">Report Booking</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" ng-controller="MainCtrl">
        <div class="travelo-box col-xs-12">
            <form action="" method="get" >

                <h3>Report Booking</h3>
                @include('layouts.message-helper')

                <div class="row form-group">
                    <div class="col-xs-12">
                        <label>Confirmation Number</label>
                        <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Check In Date (Start)</label>
                        <div class="datepicker-wrap">
                            <input type="text" name="check_in_start" class="input-text full-width custom-datepicker" placeholder="dd-mm-yy" />
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <label>Check In Date (End)</label>
                        <div class="datepicker-wrap">
                            <input type="text" name="check_in_end" class="input-text full-width custom-datepicker" placeholder="dd-mm-yy" />
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Check Out Date (Start)</label>
                        <div class="datepicker-wrap">
                            <input type="text" name="check_out_start" class="input-text full-width custom-datepicker" placeholder="dd-mm-yy" />
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <label>Check Out Date (End)</label>
                        <div class="datepicker-wrap">
                            <input type="text" name="check_out_end" class="input-text full-width custom-datepicker" placeholder="dd-mm-yy" />
                        </div>
                    </div>
                </div>

                <div class="row form-group">
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
                        <th>Booking Number</th>
                        <th class="hide-for-small">Booking Date</th>
                        <th class="hide-for-small">Guest</th>
                        <th class="hide-for-small">Confirmation Number</th>
                        <th>Room Name</th>
                        <th class="hide-for-small">Check In Date</th>
                        <th class="hide-for-small">Check Out Date</th>
                        <th class="hide-for-small">Night</th>
                        <th class="hide-for-small">Status</th>
                        <th class="hide-for-small td-right">Total Pembayaran</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingList as $booking)
                    <tr>
                        <td>{{ $booking->order_no }}</td>
                        <td>{{ $booking->order_date }}</td>
                        <td>{{ $booking->quest }}</td>
                        <td>{{ $booking->no_conf_order }}</td>
                        <td>{{ $booking->room_name }}</td>
                        <td>{{ $booking->check_in_date }}</td>
                        <td>{{ $booking->check_out_date }}</td>
                        <td>{{ $booking->night }}</td>
                        <td>{{ $booking->status_flg }}</td>
                        <td>{{ $booking->tot_payment }}</td>
                        <td class="td-right">{{ $booking->tot_payment }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="11" id="pagination" class="td-right">
                            {{-- $hotelList->appends(Request::only('hotel_name', 'country', 'city'))->render() --}}
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
	$scope.field.country = '{{ $indonesia->id }}';
	$scope.cities = [];
	$scope.getCity = function(){
		$http.post('{{ url("hotel/report-booking/city-from-country") }}', $scope.field).success(function(response){
			$scope.cities = response;
			$scope.field.city = '';
			tjq('#citySelector span').html('');
			// console.log(response);
		})
	}

	$scope.getCity();
	$scope.field.city = '{{old("city")}}';

});

</script>
@endsection
