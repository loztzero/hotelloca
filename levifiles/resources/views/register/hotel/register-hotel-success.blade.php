@extends('layouts.foundation-angular')
@section('content')
<div class="row" ng-controller="MainCtrl">
<h1>Your Register Successful</h1>
Thank you for register, we will check it as soon as possible and you will receive a mail with login when we add you in our hotel list.<br/>
<a href="{{ url() }}">Back to Main Page</a>
</div>

@endsection

@section('script')
<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {


	});
</script>
@stop
