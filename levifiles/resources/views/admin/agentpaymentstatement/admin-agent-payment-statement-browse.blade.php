@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Agent Payment Statement</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li class="active">Agent Payment Statement</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

		<div class="travelo-box">
			<form action="{{ url('/admin/agent-payment-statement') }}" method="get" >

				<h3>Agent Payment Statement</h3>
				@include('layouts.message-helper')
			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Order Number</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('order_no') }}" id="orderNo" name="order_no">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Agent</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('agent') }}" id="agent" name="agent">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Start Order Date</label>
						<div class="datepicker-wrap">
			            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('start_date') }}" id="startDate" name="start_date">
						</div>
			        </div>

			         <div class="col-xs-6">
			            <label>End Order Date</label>
						<div class="datepicker-wrap">
			            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('end_date') }}" id="endDate" name="end_date">
						</div>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Hotel</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel') }}" id="hotel" name="hotel">
			        </div>

					<div class="col-xs-6">
			            <label>Status Payment</label>
						<div class="selector">
							{!! Form::select('status_payment', array('' => 'All', 'Pending' => 'Pending', 'Done' => 'Done', 'Failed' => 'Failed'), Request::get('status_payment'), array('class' => 'full-width')) !!}
						</div>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Status Order</label>
						<div class="selector">
							{!! Form::select('status_flag', array('' => 'All', 'Pending' => 'Pending', 'Confirmed' => 'Confirmed', 'Cancel' => 'Cancel'), Request::get('status_flag'), array('class' => 'full-width')) !!}
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
				<thead>
					<tr>
						<th colspan="2">Order Booking</th>
						<th rowspan="2">Agent</th>
						<th rowspan="2">Hotel</th>
						<th rowspan="2" class="td-right">Total Payment</th>
						<th rowspan="2">Status</th>
						<th rowspan="2">Status Payment</th>
						<th rowspan="2">Action</th>
					</tr>
					<tr>
						<th>Number</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($paymentList as $payment)
					<tr>
						<td>{{ $payment->order_no }}</td>
						<td>{{ $helpers::dateFormatterMysql($payment->order_date) }}</td>
						<td>{{ $payment->agent->email }}</td>
						<td>{{ $payment->hotel_name }}</td>
						<td class="td-right">{{ $payment->curr_code }}. {{ number_format($payment->tot_gross_price, 0, ',', '.') }}</td>
						<td>{{ $payment->status_flag }}</td>
						<td>{{ $payment->status_pymnt }}</td>
						<td>
							@if($payment->status_pymnt == 'Pending')
			            		<a href="{{ url('admin/agent-payment-statement/change-status/'). '/' .$payment->id }}" class="button btn-small sky-blue1" title="Change Status Payment"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp; Change Status Payment</a>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7" id="pagination">
							{{--} $hotelList->appends(Request::only('hotel_name', 'country', 'city'))->render()--}}
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


	});
</script>
@endsection
