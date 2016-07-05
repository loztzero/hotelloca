@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Display Confirmation Payment</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li class="active">Display Confirmation Payment</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

		<div class="travelo-box">
			<form action="{{ url('/admin/display-confirmation-payment') }}" method="get" >

				<h3>Agent Payment Statement</h3>
				@include('layouts.message-helper')
				<div class="row form-group">
			        <div class="col-xs-6">
			            <label>Start Date Confirmation Payment</label>
						<div class="datepicker-wrap">
			            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('tranfer_date_from') }}" id="transferDateFrom" name="tranfer_date_from">
						</div>
			        </div>

			         <div class="col-xs-6">
			            <label>End Date Confirmation Payment</label>
						<div class="datepicker-wrap">
			            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('tranfer_date_to') }}" id="transferDateTo" name="tranfer_date_to">
						</div>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Order Number</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('order_no') }}" id="orderNo" name="order_no">
			        </div>
			    </div>

				<div class="row form-group">
			        <div class="col-xs-6">
			            <label>Start Order Date</label>
						<div class="datepicker-wrap">
			            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('order_date_from') }}" id="orderDateFrom" name="order_date_from">
						</div>
			        </div>

					<div class="col-xs-6">
			            <label>End Order Date</label>
						<div class="datepicker-wrap">
			            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('order_date_to') }}" id="orderDateTo" name="order_date_to">
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
						<th>No Order</th>
						<th>Order Date</th>
						<th class="td-right">Payment Value</th>
						<th>Transfer Date</th>
						<th>Bank Transfer</th>
						<th>Account Transfer</th>
						<th>Name</th>
						<th>Status Booking</th>
						<th>Status Payment</th>
						<th>Note</th>
					</tr>
				</thead>
				<tbody>
					@foreach($confirmations as $confirmation)
					<tr>
						<td>{{ $confirmation->order_no }}</td>
						<td>{{ $helpers::dateFormatterMysql($confirmation->order_date) }}</td>
						<td class="td-right">{{ number_format($confirmation->payment_val, 0, ',', '.') }}</td>
						<td>{{ $confirmation->transfer_date }}</td>
						<td>{{ $confirmation->bank_transfer }}</td>
						<td>{{ $confirmation->account_transfer }}</td>
						<td>{{ $confirmation->name }}</td>
						<td>{{ $confirmation->status_flag }}</td>
						<td>{{ $confirmation->status_pymnt }}</td>
						<td>{{ $confirmation->note }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7" id="pagination">
							{{-- str_replace('/?', '?', $confirmations->appends(Request::only('tranfer_date_from', 'tranfer_date_to', 'order_no', 'order_date_from', 'order_date_to'))->render()) --}}
							{!! $confirmations->appends(Request::only('tranfer_date_from', 'tranfer_date_to', 'order_no', 'order_date_from', 'order_date_to'))->render() !!}
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
