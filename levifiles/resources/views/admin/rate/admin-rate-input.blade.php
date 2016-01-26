@extends('layouts.layout-hotel-admin')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<h3>Rate Input</h3>
	@include('layouts.message-helper')

	<div class="large-12 colums">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('admin/rate/save') }}" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			@if(!empty(old('id')))
				<input type="hidden" value="{{ old('id')}}" name="id">
			@endif

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="curr1Id" class="right inline show-for-medium-up">Currency 1 *</label>
		          <label for="curr1Id" class="show-for-small-only">Currency 1 *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	{!! Form::select('curr1_id', $currencies , old('curr1_id'), array('required', 'id' => 'curr1Id')) !!}
		          <small class="error">Currency 1 must be selected</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="kurs1Val" class="right inline show-for-medium-up">Currency 1 Value *</label>
		          <label for="kurs1Val" class="show-for-small-only">Currency 1  Value *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="text" name="kurs1_val" value="{{ old('kurs1_val', 1) }}" required readonly>
		          	<small class="error">Currency 1 Value Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="curr2Id" class="right inline show-for-medium-up">Currency 2 *</label>
		          <label for="curr2Id" class="show-for-small-only">Currency 2 *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	{!! Form::select('curr2_id', $currencies , old('curr2_id', $idr->id), array('required', 'id' => 'curr2Id', 'disabled')) !!}
		        	{!! Form::hidden('curr2_id', $idr->id) !!}
		          <small class="error">Currency 2 value must be selected</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="kurs2Value" class="right inline show-for-medium-up">Currency 2 Value *</label>
		          <label for="kurs2Value" class="show-for-small-only">Currency 2 Value *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	<input type="text" name="kurs2_val" value="{{ old('kurs2_val', 0) }}" required>
		          	<small class="error">Currency 2 Value Required</small>
		        </div>
		    </div>
		
	    	<div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
					<button type="submit" class="button small">{{ empty(old('id')) ? 'Add New Rate' : 'Update Rate' }}</button>          
		        </div>
		    </div>
	    </form>
    </div>

</div>

@endsection

@section('script')
<script>

var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var fromDate = $('#fromDate').fdatepicker({
	format : 'dd-mm-yyyy',
	onRender: function (date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
	}	
});

var endDate = $('#endDate').fdatepicker({
	format : 'dd-mm-yyyy',
	onRender: function (date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
	}	
});

$(".confirm-delete").on("click", function(e) {
	e.preventDefault();
	var form = $(this).parents('form');
	swal({   
		title: "Are you sure?",   
		text: "This picture will be deleted",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#f04124",   
		confirmButtonText: "Yes, delete it!",   
		closeOnConfirm: false }, 
	function(confirmed){   
		if (confirmed) form.submit();
	});

});

	

</script>
<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {

	});
</script>
@stop
