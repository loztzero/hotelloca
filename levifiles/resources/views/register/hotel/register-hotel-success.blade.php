@extends('layouts.general-travel-layout')
@section('content')
<div class="container" ng-controller="MainCtrl">

	<div class="travelo-box">
		<h1>Your Register Successful</h1>
		Thank you for register, we will check it as soon as possible and you will receive a mail with login when we add you in our hotel list.<br/>
		<a href="{{ url('/') }}" class="button btn-small green">Go to Login Page</a>
		<a href="{{ url('/main') }}" class="button btn-small green">Back to Main Page</a>
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
