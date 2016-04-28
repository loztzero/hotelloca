@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Hotel Profile</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Hotel</a></li>
	            <li class="active">Hotel Profile</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
<div class="container" ng-controller="MainCtrl">

	<div class="travelo-box">

		<form action="{{url('/hotel/profile/save')}}" method="post" >
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="id" value="{{ $profile->id }}">

			<h3>Profile</h3>
			@include('layouts.message-helper')

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Hotel Name *</label>
		            <input type="text" class="input-text full-width" value="{{ old('hotel_name', $profile->hotel_name) }}" id="hotelName" readonly>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Address *</label>
		            <textarea name="address" class="input-text full-width" placeholder="write message here">{{ old('address', $profile->address) }}</textarea>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-6">
		            <label>Country *</label>
		            <input type="text" class="input-text full-width" value="{{ $profile->country->country_name }}" readonly>
		        </div>

		        <div class="col-xs-6">
		            <label>City *</label>
		            <input type="text" class="input-text full-width" value="{{ $profile->city->city_name }}" readonly>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Postcode *</label>
		            <input type="text" class="input-text full-width" value="{{old('postcode', $profile->postcode)}}" id="postCode" name="postcode">
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Landmark Name</label>
		            <input type="text" class="input-text full-width" value="{{old('landmark_name', $profile->postcode)}}" id="landmarkName" name="landmark_name" required>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Phone Number *</label>
		            <input type="text" class="input-text full-width" value="{{old('phone_number', $profile->phone_number)}}" id="phoneNumber" name="phone_number">
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Fax No</label>
		            <input type="text" class="input-text full-width" value="{{old('fax_number', $profile->fax_number)}}" id="faxNumber" name="fax_number">
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>email Address *</label>
		            <input type="email" class="input-text full-width" value="{{ $profile->email }}" readonly>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Website</label>
		            <input type="text" class="input-text full-width" value="{{old('website', $profile->website)}}" id="website" name="website">
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-6">
		            <label>Currency *</label>
		            <input type="text" class="input-text full-width" value="{{ $profile->currency->curr_code }}" id="currency" readonly>
		        </div>
		    </div>

			<div class="row form-group">
				<div class="col-xs-12">
					<label>Meal Price *</label>
					<input type="text" class="input-text full-width" value="{{ number_format(old('meal_price', $profile->meal_price), 0, ',', '.') }}" name="meal_price" id="mealPrice">
				</div>
			</div>

			<div class="row form-group">
				<div class="col-xs-12">
					<label>Bed Price *</label>
					<input type="text" class="input-text full-width" value="{{ number_format(old('bed_price', $profile->bed_price), 0, ',', '.') }}" name="bed_price" id="bedPrice">
				</div>
			</div>

			<div class="row form-group">
				<div class="col-xs-12">
					<label>Description Hotel</label>
					<textarea name="description" id="description" rows="10">
						{{ old('description', $profile->description) }}
					</textarea>
					<script>
						// Replace the <textarea id="editor1"> with a CKEditor
						// instance, using default configuration.
						CKEDITOR.replace( 'description' );
						CKEDITOR.config.removePlugins = 'about, link';
					</script>
				</div>
			</div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <button type="submit" class="button small">Update Profile</button>
		        </div>
		    </div>
		</form>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

// $('#transferDate').fdatepicker({
// 	format : 'dd-mm-yyyy'
// });

// //set default date
// $('#transferDate').fdatepicker('setDate', new Date());

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
@endsection
