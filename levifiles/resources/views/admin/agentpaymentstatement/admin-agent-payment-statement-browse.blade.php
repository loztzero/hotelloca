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
			<form action="{{ url('/admin/agent-deposit') }}" method="get" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<h3>Agent Payment Statement</h3>
				@include('layouts.message-helper')
			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Order Number</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel_name') }}" id="hotelName" name="hotel_name">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Agent</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel_name') }}" id="hotelName" name="hotel_name">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Start Order Date</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel_name') }}" id="hotelName" name="hotel_name">
			        </div>

			         <div class="col-xs-6">
			            <label>End Order Date</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel_name') }}" id="hotelName" name="hotel_name">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Order Number</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel_name') }}" id="hotelName" name="hotel_name">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Hotel</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('hotel_name') }}" id="hotelName" name="hotel_name">
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
						<th width="100px" rowspan="2">Action</th>
						<th colspan="2">Order Booking</th>
						<th rowspan="2">Agent</th>
						<th rowspan="2">Total Payment</th>
						<th rowspan="2">Status</th>
						<th rowspan="2">Status Payment</th>
					</tr>
					<tr>
						<th>Number</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($paymentList as $payment)
					<tr>
						<td>
							<form action="{{URL::to('admin/agent-payment-statement/do-something-here')}}" method="post" class="pull-left">
								<input type="hidden" value="{{ csrf_token() }}" name="_token">
				            	<input type="hidden" value="{{ $payment->id }}" name="id">
				            	<button type="submit" class="btn-primary" title="Edit Deposit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
							</form>
						</td>
						<td>{{ $payment->order_no }}</td>
						<td>{{ $helpers::dateFormatterMysql($payment->order_date) }}</td>
						<td>{{ $payment->agent->email }}</td>
						<td>{{ $payment->tot_gross_price }}</td>
						<td>{{ $payment->status_flg }}</td>
						<td>
							<div class="selector">
								<select class="full-width">
									<option value="Cancel">Cancel</option>	
									<option value="Done">Done</option>
								</select>
							</div>
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
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {


	});
</script>
@endsection
