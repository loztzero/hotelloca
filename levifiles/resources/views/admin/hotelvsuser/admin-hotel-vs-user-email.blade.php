@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Facilities</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Hotel</a></li>
                <li><a href="#">Room</a></li>
	            <li class="active">Facilities</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
<div class="container" ng-controller="MainCtrl">

	<a href="{{ url('admin/hotel-vs-user') }}" class="button tiny secondary"><< Back</a><br>
	<div class="travelo-box">
        <form action="{{url('/admin/hotel-vs-user/save-user')}}" method="post" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <h3>Register Hotel a User</h3>
            @include('layouts.message-helper')
            <div class="row form-group">
                <div class="col-xs-12">
                    <label>Email</label>
                    <input type="hidden" value="{{ $hotel->id }}" name="id">
                    <input type="email" class="input-text full-width" value="{{ old('email') }}" id="email" name="email" required>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-xs-12">
                    <label>Hotel Name</label>
                    <input type="text" class="input-text full-width" value="{{ $hotel->hotel_name }}" readonly>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-xs-12">
                    <label>Country</label>
                    <input type="text" class="input-text full-width" value="{{ $hotel->country->country_name }}" readonly>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-xs-12">
                    <label>City</label>
                    <input type="text" class="input-text full-width" value="{{ $hotel->city->city_name }}" readonly>
                </div>
            </div>

            <div class="row form-group">
              <div class="col-xs-12">
                  <button type="submit">Register to User</button>
              </div>
            </div>
        </form>

	</div>
</div>

@endsection

@section('script')
<script>

tjq(".confirm-delete").on("click", function(e) {
	e.preventDefault();
	var form = tjq(this).parents('form');
	swal({
		title: "Are you sure?",
		text: "This picture will be deleted",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f04124",
		confirmButtonText: "Yes, delete it!",
		confirmButtonClass: 'normal-lh',
		cancelButtonClass: 'normal-lh',
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
