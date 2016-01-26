@extends('layouts.layout-agent')
@section('content')
	
<div class="row" ng-controller="MainCtrl">
	<div class="large-12 columns">

		<h3>Profile</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="POST" action="{{url('/agent/profile/save')}}" data-abide>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="id" value="{{ $profile->id }}">

			<div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="compName" class="right inline show-for-medium-up">Company Name *</label>
		          <label for="compName" class="show-for-small-only">Company Name *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ old('comp_name', $profile->comp_name) }}" id="compName" name="comp_name">
		          <small class="error">Company Name Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="address" class="right inline show-for-medium-up">Address *</label>
		          <label for="address" class="show-for-small-only">Address *</label>
		        </div>
		        <div class="small-12 medium-9 large-7 columns left">
		          <textarea id="address"style="height:5em;" name="address">{{old('address', $profile->address)}}</textarea>
		          <small class="error">Address Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="postCode" class="right inline show-for-medium-up">Postcode *</label>
		          <label for="postCode" class="show-for-small-only">Postcode *</label>
		        </div>
		        <div class="small-12 medium-9 large-3 columns left">
		          <input type="text" class="span2" value="{{old('postcode', $profile->postcode)}}" id="postCode" name="postcode">
		          <small class="error">Postcode Required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="country" class="right inline show-for-medium-up">Country *</label>
		          <label for="country" class="show-for-small-only">Country *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ $profile->country->country_name }}" readonly>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="city" class="right inline show-for-medium-up">City *</label>
		          <label for="city" class="show-for-small-only">City *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ $profile->city->city_name }}" readonly>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="phoneNumber" class="right inline show-for-medium-up">Phone Number *</label>
		          <label for="phoneNumber" class="show-for-small-only">Phone Number *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('phone_number', $profile->phone_number)}}" id="phoneNumber" name="phone_number">
		          <small class="error">Phone number required</small>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="faxNumber" class="right inline show-for-medium-up">Fax No</label>
		          <label for="faxNumber" class="show-for-small-only">Fax No</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('fax_number', $profile->fax_number)}}" id="faxNumber" name="fax_number">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="email" class="right inline show-for-medium-up">Email Address *</label>
		          <label for="email" class="show-for-small-only">Email Address *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{ $profile->email }}" readonly>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="website" class="right inline show-for-medium-up">Website</label>
		          <label for="website" class="show-for-small-only">Website</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="{{old('website', $profile->website)}}" id="website" name="website">
		        </div>
		    </div>

		    <div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
					<button type="submit" class="button small">Update Profile</button>          
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