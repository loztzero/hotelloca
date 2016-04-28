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
                            <input type="text" name="date_from" id="dateFrom" class="input-text full-width" placeholder="dd-mm-yy" />
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <label>Check Out Date</label>
                        <div class="datepicker-wrap">
                            <input type="text" name="date_to" id="dateTo" class="input-text full-width" placeholder="dd-mm-yy" />
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
                        <label>Status Order</label>
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
                        <th class="hide-for-small">Payment Date</th>
                        <th class="hide-for-small">Status</th>
                        <th class="td-right">Total Payment</th>
                        <th>Payment Method</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingList as $booking)
                    <tr>
                        <td>{{ $booking->order_no }}</td>
                        <td>{{ date('d-m-Y', strtotime($booking->check_in_date)) }}</td>
                        <td>{{ date('d-m-Y', strtotime($booking->check_out_date)) }}</td>
                        <td>{{ $booking->first_name }}</td>
                        <td>{{ $booking->transfer_date }}</td>
                        <td>{{ $booking->status_flag }}</td>
                        <td class="td-right">{{ number_format($booking->tot_payment, 0, ',', '.') }}</td>
                        <td>
                            @if($booking->payment_method == 'PendingPayment')
                                Pending Payment
                            @else
                                {{ $booking->payment_method }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('agent/booking-history/order-detail/').'/'.$booking->order_no }}" class="button btn-small green">Order Detail</a>
                            <a href="{{ url('agent/booking-history/invoice/').'/'.$booking->order_no }}" class="button btn-small green">Invoice</a>
                            @if($booking->status_flag != 'Cancel' && $booking->status_pymnt == 'Pending' && $booking->show_cancel)
                                <a href="{{ url('agent/booking-history/cancel/').'/'.$booking->order_no }}" class="button btn-small green" onclick="javascript: return confirm('Cancellation can not be undone, are you sure?')">Cancel</a>
                            @endif
                            @if($booking->status_pymnt == 'Pending' && $booking->status_flag == 'Pending' && $booking->payment_method == 'PendingPayment')
                                <a href="{{ url('agent/booking-history/payment/').'/'.$booking->order_no }}" class="button btn-small green">Payment</a>
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
<script type="text/javascript">
    tjq('#dateFrom').datepicker({
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

    tjq('#dateTo').datepicker({
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

    // tjq('#dateTo').fdatepicker({
    // 	format : 'dd-mm-yyyy'
    // });

    @if(Input::get('date_to') != null)
    tjq('#dateTo').datepicker('setDate', new Date({{ strtotime(Input::get('date_to')) * 1000 }}));
    @endif

    @if(Input::get('date_from') != null)
    tjq('#dateFrom').datepicker('setDate', new Date({{ strtotime(Input::get('date_from')) * 1000 }}));
    @endif
</script>
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
