@extends('layouts.layout-hotel')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<h3>Hotel Profile</h3>
	@include('layouts.message-helper')

	<div class="large-12 colums">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('hotel/profile/save') }}" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			@if(!empty(old('id', $profile->id)))
				<input type="hidden" value="{{ old('id', $profile->id)}}" name="id">
			@endif
			<div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="hotelName" class="right inline show-for-medium-up">Hotel Name *</label>
		          <label for="hotelName" class="show-for-small-only">Hotel Name *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('hotel_name', $profile->hotel_name) }}" id="hotelName" name="hotel_name" required>
		          <small class="error">Hotel Name Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="address" class="right inline show-for-medium-up">Star *</label>
		          <label for="address" class="show-for-small-only">Star *</label>
		        </div>
		        <div class="small-6 medium-2 large-1 columns left">
		          {!! Form::select('star', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5') , old('star', $profile->star), array('required')) !!}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="address" class="right inline show-for-medium-up">Address *</label>
		          <label for="address" class="show-for-small-only">Address *</label>
		        </div>
		        <div class="small-12 medium-9 large-7 columns left">
		          <textarea id="address"style="height:5em;" required name="address">{{old('address', $profile->address)}}</textarea>
		          <small class="error">Address Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="country" class="right inline show-for-medium-up">Country *</label>
		          <label for="country" class="show-for-small-only">Country *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          {{ $profile->country->country_code }}
		        </div>
		    </div>
		    
		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="city" class="right inline show-for-medium-up">City *</label>
		          <label for="city" class="show-for-small-only">City *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		        	{{ $profile->city->city_code }}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="postCode" class="right inline show-for-medium-up">Postcode *</label>
		          <label for="postCode" class="show-for-small-only">Postcode *</label>
		        </div>
		        <div class="small-12 medium-9 large-3 columns left">
		          <input type="text" class="span2" value="{{old('postcode', $profile->postcode) }}" id="postCode" name="postcode" required>
		          <small class="error">Postcode Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="landmarkName" class="right inline show-for-medium-up">Landmark Name *</label>
		          <label for="landmarkName" class="show-for-small-only">Landmark Name *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('landmark_name', $profile->landmark_name )}}" id="landmarkName" name="landmark_name" required>
		          <small class="error">Landmark name required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="phoneNumber" class="right inline show-for-medium-up">Phone Number *</label>
		          <label for="phoneNumber" class="show-for-small-only">Phone Number *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('phone_number', $profile->phone_number) }}" id="phoneNumber" name="phone_number" required>
		          <small class="error">Phone number required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="faxNumber" class="right inline show-for-medium-up">Fax No</label>
		          <label for="faxNumber" class="show-for-small-only">Fax No</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('fax_number', $profile->fax_number) }}" id="faxNumber" name="fax_number">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="email" class="right inline show-for-medium-up">Email Address *</label>
		          <label for="email" class="show-for-small-only">Email Address *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="email" class="span2" value="{{old('email', $profile->email)}}" id="email" name="email" required>
		          <small class="error">Email required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="website" class="right inline show-for-medium-up">Website</label>
		          <label for="website" class="show-for-small-only">Website</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('website', $profile->website) }}" name="website" id="website">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="website" class="right inline show-for-medium-up">Currency *</label>
		          <label for="website" class="show-for-small-only">Currency *</label>
		        </div>
		        <div class="small-12 medium-5 large-2 columns left">
		         {!! Form::select('mst004_id', $currencies, old('mst004_id', $profile->mst004_id), array('required')) !!}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="mealPrice" class="right inline show-for-medium-up">Meal Price</label>
		          <label for="mealPrice" class="show-for-small-only">Meal Price</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          	<input type="text" class="span2" value="{{old('meal_price', $profile->meal_price) }}" name="meal_price" id="mealPrice">
	           		<small class="error">Email required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="bedPrice" class="right inline show-for-medium-up">Bed Price</label>
		          <label for="bedPrice" class="show-for-small-only">Bed Price</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('bed_price', $profile->bed_price) }}" name="bed_price" id="bedPrice">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="bedPrice" class="right inline show-for-medium-up">Description</label>
		          <label for="bedPrice" class="show-for-small-only">Description</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <textarea name="description" id="description">{{ old('description', $profile->description) }}</textarea>
		        </div>
		    </div>

	    	<div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
					<button type="submit" class="button small">Update Hotel Profile</button>          
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
@stop
