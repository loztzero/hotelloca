@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Agent Payment Statement</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li>Agent Payment Statement</li>
                <li class="active">Change Status</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

        <a href="{{ url('admin/agent-payment-statement') }}" class="button tiny secondary"><< Back</a><br>
		<div class="travelo-box">
			<form action="{{ url('/admin/agent-payment-statement/save-changed-status') }}" method="post" >

				<h3>Agent Payment Statement</h3>
				@include('layouts.message-helper')
			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Order Number</label>
                        <input type="hidden" value="{{ $balanceOrder->id }}" name="id">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
			            <input type="text" class="input-text full-width" value="{{ $balanceOrder->order_no }}" id="orderNo" name="order_no" readonly>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Agent</label>
			            <input type="text" class="input-text full-width" value="{{ $balanceOrder->agent->email }}" id="agent" readonly>
			        </div>
			    </div>

				<div class="row form-group">
					<div class="col-xs-12">
						<label>Room</label>
						<input type="text" class="input-text full-width" value="{{ $balanceOrderBookingSummaryDetail->room->room_name }}" readonly>
					</div>
				</div>

				<div class="row form-group">
			        <div class="col-xs-6">
			            <label>Nights</label>
			            <input type="text" class="input-text full-width" value="{{ $balanceOrderBookingSummaryDetail->night }}" readonly>
			        </div>

					<div class="col-xs-6">
			            <label>Check In Date</label>
			            <input type="text" class="input-text full-width" value="{{ $helpers::dateFormatter($balanceOrderBookingSummaryDetail->check_in_date) }}" readonly>
			        </div>
			    </div>

			    <div class="row form-group">
					<div class="col-xs-6">
			            <label>Status Payment</label>
						<div class="selector">
							{!! Form::select('status_payment', array('' => 'Not Selected', 'Done' => 'Done', 'Failed' => 'Failed'), $balanceOrder->status_pymnt, array('class' => 'full-width')) !!}
						</div>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Status Order</label>
						<input type="text" class="input-text full-width" value="{{ $balanceOrder->status_flag }}" id="statusFlag" readonly>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <button type="submit" class="button small">Save Changed</button>
			        </div>
			    </div>
			</form>
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
