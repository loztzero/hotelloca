@extends('layouts.general-travel-layout')\

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Rate Input</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li><a href="{{ url('admin/rate') }}">Rate</a></li>
	            <li class="active">Rate Input</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
<div class="container" ng-controller="MainCtrl">
	
	<a href="{{ url('admin/rate') }}" class="button tiny secondary"><< Back</a>
	<div class="travelo-box">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('admin/rate/save') }}">

			<h3>Rate Input</h3>
			@include('layouts.message-helper')

			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			@if(!empty(old('id')))
				<input type="hidden" value="{{ old('id')}}" name="id">
			@endif

		    <div class="row form-group">
				<div class="col-xs-6">
		          	<label>Currency 1 *</label>
		          	<div class="selector">
	        			{!! Form::select('curr1_id', $currencies , old('curr1_id'), array('required', 'id' => 'curr1Id', 'class' => 'full-width')) !!}
		          	</div>
		        </div>

				<div class="col-xs-6">
		          	<label>Currency 1 Value *</label>
	        		<input type="number" name="kurs1_val" value="{{ old('kurs1_val', 1) }}" required readonly class="input-text full-width">
		        </div>
		    </div>

		    <div class="row form-group">
		    </div>

		    <div class="row form-group">
				<div class="col-xs-6">
		          	<label>Currency 2 *</label>
		          	<div class="selector">
	        			{!! Form::select('curr2_id', $currencies , old('curr2_id', $idr->id), array('required', 'id' => 'curr2Id', 'disabled', 'class' => 'full-width')) !!}
		        		{!! Form::hidden('curr2_id', $idr->id) !!}
		          	</div>
		        </div>

				<div class="col-xs-6">
		          	<label>Currency 2 Value *</label>
	        		<input type="text" name="kurs2_val" value="{{ old('kurs2_val', 0) }}" required class="input-text full-width">
		        </div>
		    </div>
		
	    	<div class="row form-group">
		        <div class="col-xs-12">
					<button type="submit" class="button">{{ empty(old('id')) ? 'Add New Rate' : 'Update Rate' }}</button>          
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
