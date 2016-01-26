@extends('layouts.layout-hotel-admin')
@section('content')
	
<div class="row" ng-controller="MainCtrl">
	<div class="large-12 columns">

		<h3>Browse Payment</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="POST" actio n="{{url('/hotel-agent/validate-confirmation-payment')}}" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="orderNo" class="right inline show-for-medium-up">Order Number *
		          </label>
		          <label for="orderNo" class="show-for-small-only">Order Number *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="text" name="order_no" id="orderNo" value="{{old('order_no')}}" required>
		        	<small class="error">Order No Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="orderDate" class="right inline show-for-medium-up">Order Date * </span>
		          </label>
		          <label for="orderDate" class="show-for-small-only">Order Date * </span>
		          </label>
		        </div>
		        <div class="small-12 medium-4 large-3 columns left">
		        	<input type="text" name="order_date" id="orderDate" value="{{old('order_date')}}" readonly>
		        </div>
		        <div style="float:left;margin-top:5px;" class="middle-text">
		        	Until
		        </div>
		        <div class="small-12 medium-4 large-3 columns left">
		        	<input type="text" name="order_date" id="orderDate" value="{{old('order_date')}}" readonly>
		        </div>
		    </div>
	    	
		    <div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-3 medium-offset-3 columns left">
		          <button type="submit" class="button small">Search</button>
		        </div>
		    </div>
		</form>

		<table>
		  <thead>
		    <tr>
		      <th class="action-gap">Aksi</th>
		      <th>Kode</th>
		      <th>Nama</th>
		      <th>Status</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  	<td></td>
		  </tbody>
		  <tfoot>
		  	<tr>
		  		<td colspan="4">
		  		{{-- 	{!! str_replace('/?', '?', $unitList->appends(Request::only('kodeUnit', 'namaUnit', 'status'))->render())!!} --}}
		  		</td>
		  	</tr>
		  </tfoot>
		</table>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">

$('#transferDate').fdatepicker({
	format : 'dd-mm-yyyy'
});

//set default date
$('#transferDate').fdatepicker('setDate', new Date());

</script>

<script>

var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function ($scope, $http, $filter) {


});

// app.directive('helloWorld', function(){
// 	return {
// 		restrict : 'E',
// 		templateUrl : "{{url('/assets/directivepartial')}}/hello.html"
// 	}
// })
</script>
@stop