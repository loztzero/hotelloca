@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Confirmation Payment</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Agent</a></li>
	            <li class="active">Confirmation Payment</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

		<div class="travelo-box col-xs-12">
			<form action="{{url('/agent/confirmation-payment/save')}}" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<h3>Agent Confirmation Payment</h3>
				@include('layouts.message-helper')

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Order No *</label>
			            <input type="text" class="input-text full-width"  value="{{ old('order_no')}}" id="orderNo" name="order_no" required>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-5">
			            <label>Order Date *</label>
		            	<input type="text" class="input-text full-width"  value="{{ old('order_date')}}" id="orderDate" name="order_date" required readonly>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Email</label>
			            <input type="email" class="input-text full-width" value="{{ old('email') }}" id="email" name="email">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-6">
			            <label>Tranfer To *</label>
						<div class="selector">
							{!! Form::select('transfer_to',
								array('BCA-12345' => 'BCA-12345', 'MANDIRI-12345' => 'MANDIRI-12345', 'BNI-12345' => 'BNI-12345'),
								old('transfer_to'), array('required', 'class' => 'input-text full-width', 'required')) !!}
						</div>
			        </div>
			    </div>

				<div class="row form-group">
			        <div class="col-xs-12">
			            <label>Payment Value *</label>
			            <input type="text" class="input-text full-width" value="{{ old('payment_val', 0) }}" id="paymentVal" name="payment_val">
			        </div>
			    </div>

				<div class="row form-group">
			        <div class="col-xs-6">
			            <label>Transfer Date *</label>
						<div class="datepicker-wrap">
				          	<input type="text" class="input-text full-width" value="{{ old('transfer_date') }}" id="transferDate" name="transfer_date" readonly>
			          	</div>
			        </div>
			    </div>

				<div class="row form-group">
			        <div class="col-xs-12">
			            <label>Bank Transfer From *</label>
			            <input type="text" class="input-text full-width" value="{{ old('bank_transfer') }}" id="bankTransfer" name="bank_transfer">
			        </div>
			    </div>

				<div class="row form-group">
			        <div class="col-xs-12">
			            <label>Account Transfer *</label>
			            <input type="text" class="input-text full-width" value="{{ old('account_transfer') }}" id="accountTransfer" name="account_transfer">
			        </div>
			    </div>

				<div class="row form-group">
			        <div class="col-xs-12">
			            <label>Name *</label>
			            <input type="text" class="input-text full-width" value="{{ old('name') }}" id="name" name="name" requried>
			        </div>
			    </div>

				<div class="row form-group">
			        <div class="col-xs-12">
			            <label>Note</label>
			            <textarea id="note" name="note" class="full-width">{{ old('note') }}</textarea>
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <button type="submit" class="button small">Submit</button>
			        </div>
			    </div>

			</form>
		</div>
	</div>
@endsection

@section('script')
<script type="text/javascript">
tjq('#transferDate').datepicker({
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

tjq("#orderNo").blur(function(){
	var orderNo = tjq("#orderNo").val();
	//alert(orderNo);
	tjq.ajax({
		url: "{{ url('agent/confirmation-payment/balance-order-date') }}" + '/' + orderNo,
		success: function(result){
	    	tjq("#orderDate").val(result);
		}
	});
});
</script>

<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {


	});


</script>
@endsection
