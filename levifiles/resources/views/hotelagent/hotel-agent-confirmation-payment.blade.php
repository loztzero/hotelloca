@extends('layouts.foundation-login')
@section('content')
	
<div class="row" ng-controller="MainCtrl">
	<div class="large-12 columns">
		<ul class="breadcrumbs">
		  <li class="unavailable"><a href="#">Hotel</a></li>
		  <li class="unavailable"><a href="#">Result</a></li>
		  <li class="unavailable"><a href="#">Package Detail</a></li>
		  <li class="unavailable"><a href="#">Payment</a></li>
		  <li class="current"><a href="#">Confirm</a></li>
		</ul>


		<h3>Confirmation Payment</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="POST" action="{{url('/hotel-agent/validate-confirmation-payment')}}" data-abide>
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
		          <label for="orderDate" class="right inline show-for-medium-up">Order Date * 	<span data-tooltip aria-haspopup="true" class="has-tip" title="Fill The Correct order number will automaticly show the order date"><i class="fi-info"></i></span>
		          </label>
		          <label for="orderDate" class="show-for-small-only">Order Date * 
		          	<span data-tooltip aria-haspopup="true" class="has-tip" title="Fill The Correct order number will automaticly show the order date"><i class="fi-info"></i></span>
		          </label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="text" name="order_date" id="orderDate" value="{{old('order_date')}}" readonly>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="email" class="right inline show-for-medium-up">Email *</label>
		          <label for="email" class="show-for-small-only">Email *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="email" name="email" id="email" value="{{old('email')}}" required>
		        	<small class="error">Email required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="transferTo" class="right inline show-for-medium-up">Transfer To *</label>
		          <label for="transferTo" class="show-for-small-only">Transfer To *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
	        		{!! Form::select('transfer_to', config('enums.banks'), old('transfer_to'), array('required')) !!}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="paymentValue" class="right inline show-for-medium-up">
		          	Payment Value *
		          	<span data-tooltip aria-haspopup="true" class="has-tip" title="Fill with number only. sample : 20000"><i class="fi-info"></i></span>
		          </label>
		          <label for="paymentValue" class="show-for-small-only">
		          	Payment Value *
		          	<span data-tooltip aria-haspopup="true" class="has-tip" title="Fill with number only. sample : 20000"><i class="fi-info"></i></span>
		          </label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="text" name="payment_val" id="paymentValue" value="{{old('payment_val')}}" required>
		        	<small class="error">Payment value required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="transferDate" class="right inline show-for-medium-up">
		          	Transfer Date *
		          	<span data-tooltip aria-haspopup="true" class="has-tip" title="Click the input date for pop up calender"><i class="fi-info"></i></span>
		          </label>
		          <label for="transferDate" class="show-for-small-only">
		          	Transfer Date *
		          	<span data-tooltip aria-haspopup="true" class="has-tip" title="Click the input date for pop up calender"><i class="fi-info"></i></span>
		          </label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="text" name="transfer_date" id="transferDate" value="{{old('transfer_date')}}" readonly required>
		        	<small class="error">Transfer date required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="bankTransfer" class="right inline show-for-medium-up">Bank Transfer From *</label>
		          <label for="bankTransfer" class="show-for-small-only">
		          	Bank Transfer From *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="text" name="bank_transfer" id="bankTransfer" value="{{old('bank_transfer')}}" required>
		        	<small class="error">Bank transfer from required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="accountTransfer" class="right inline show-for-medium-up">Account Transfer *</label>
		          <label for="accountTransfer" class="show-for-small-only">Account Transfer *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="text" name="account_transfer" id="accountTransfer" value="{{old('account_transfer')}}" required>
		        	<small class="error">Account transfer required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="name" class="right inline show-for-medium-up">Account Transfer Name *</label>
		          <label for="name" class="show-for-small-only">Account Transfer Name *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="text" name="name" id="name" value="{{old('name')}}" required>
		        	<small class="error">Account transfer name required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-3 medium-3 columns">
		          <label for="note" class="right inline show-for-medium-up">Note</label>
		          <label for="note" class="show-for-small-only">Note</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<textarea name="note" id="note">{{old('note')}}</textarea>
		        </div>
		    </div>
	    	
		    <div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-3 medium-offset-3 columns left">
		          <button type="submit" class="button small">Confirm Payment</button>
		        </div>
		    </div>

		</form>
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