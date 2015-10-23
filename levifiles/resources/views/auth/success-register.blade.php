@extends('layouts.foundation-angular')
@section('content')
<div ng-controller="MainCtrl" style="text-align:center;">
	<br><br>
	<img src="{{url('assets/img/logo-home.gif')}}" width="500px" /><br><br>
	<b>Thank You For Register, we will proceed Your data soon.</b>
</div>
@endsection

@section('script')
<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {

	});
</script>
@stop
