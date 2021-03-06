@extends('layouts.general-travel-layout')
@section('content')
	
<div class="container" ng-controller="MainCtrl">

	<div class="travelo-box">
		<form action="{{url('/agent/profile/save')}}" method="post" >
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="id" value="{{ $profile->id }}">

			<h3>Profile</h3>
			@include('layouts.message-helper')
		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Company Name *</label>
		            <input type="text" class="input-text full-width" value="{{ old('comp_name', $profile->comp_name) }}" id="compName" name="comp_name">
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>Address *</label>
		            <textarea name="address" rows="6" class="input-text full-width" placeholder="write message here">{{old('address', $profile->address)}}</textarea>
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
		            <label>Country *</label>
		            <input type="text" class="input-text full-width" value="{{ $profile->country->country_name }}" readonly>
		        </div>
		    </div>

		    <div class="row form-group">
		        <div class="col-xs-12">
		            <label>City *</label>
		            <input type="text" class="input-text full-width" value="{{ $profile->city->city_name }}" readonly>
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
@endsection