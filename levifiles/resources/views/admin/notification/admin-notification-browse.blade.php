@extends('layouts.general-travel-layout')
@section('content')

<div class="container">
	<div class="row" ng-controller="MainCtrl">
		<div class="large-12 columns">

			<div class="travelo-box">
				<form action="{{ url('/admin/display-confirmation-payment') }}" method="get" >
					<h3>Confirmation Payment Notification</h3>
					@include('layouts.message-helper')

					<div class="row form-group">
				        <div class="col-xs-6">
				            <label>Start Transfer Date</label>
							<div class="datepicker-wrap">
				            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('order_date_from') }}" id="orderDateFrom" name="order_date_from">
							</div>
				        </div>

				         <div class="col-xs-6">
				            <label>End Transfer Date</label>
							<div class="datepicker-wrap">
				            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('order_date_to') }}" id="orderDateTo" name="order_date_to">
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
				            <label>Start Transfer Date</label>
							<div class="datepicker-wrap">
				            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('transfer_date_from') }}" id="transferDateFrom" name="transfer_date_from">
							</div>
				        </div>

						<div class="col-xs-6">
				            <label>End Transfer Date</label>
							<div class="datepicker-wrap">
				            	<input type="text" class="input-text full-width date-handle" value="{{ Request::get('transfer_date_to') }}" id="transferDateTo" name="transfer_date_to">
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
							<th>Action</th>
							<th>Order No</th>
							<th>Order Date</th>
							<th>Transfer Date</th>
							<th class="td-right">Payment Value</th>
							<th>Note</th>
							<th>Mark As Read</th>
						</tr>
					</thead>
					<tbody>
						@foreach($notifications as $notification)
						<tr>
							<td>
								<a href="{{ url('admin/display-confirmation-payment?order_no=') . $notification->order_no }}" class="button btn-small green">Go To Confirmation Payment</a>
							</td>
							<td>{{ $notification->order_no }}</td>
							<td>{{ $notification->order_date }}</td>
							<td>{{ $notification->transfer_date }}</td>
							<td class="td-right">{{ number_format($notification->payment_val, 0, ',', '.') }}</td>
							<td>{{ $notification->note }}</td>
							<td>
								@if($notification->read_flag == 'No')
									<button id-value='{{ $notification->id }}'>Mark As Read</button>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7">
								{!! str_replace('/?', '?', $notifications->render()) !!}
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
@stop

@section('script')
<script>

tjq("button").click(function(){
	var x = tjq(this).attr('id-value');
	tjq(this).hide();
	tjq.ajax({
        url : "{{ url('admin/notification/mark-as-read') }}",
        type: "POST",
        dataType: 'json',
        data : {id: x, "_token": "{{ csrf_token() }}"},
        success: function(data, textStatus, jqXHR)
        {
			suksess
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
			alert('looks like got error, please refresh this page and try again.');
        },

    });
});

function markAsRead(x){
	tjq(this).hide();
	tjq.ajax({
        url : "{{ url('admin/notification/mark-as-read') }}",
        type: "POST",
        dataType: 'json',
        data : {id: x, "_token": "{{ csrf_token() }}"},
        success: function(data, textStatus, jqXHR)
        {
			alert('sukses');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
			alert('error');
        },

    });
}

var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function ($scope, $http, $filter) {

	$scope.markAsRead = function(x){
		var params = {};
		params.id = x;
		$http.post(" {{ url('admin/notification/mark-as-read') }}", params)
		.success(function(response){
			alert('sukses');
		}).error(function(response){
			alert('terjadi error nich');
		})

	}

});

// app.directive('helloWorld', function(){
// 	return {
// 		restrict : 'E',
// 		templateUrl : "{{url('/assets/directivepartial')}}/hello.html"
// 	}
// })
</script>
@stop
