@extends('layouts.frontangular')
@section('content')

<style>
.red {border-color:red;}
.ng-valid {border-color:none;}
</style>

@{{email}}
<form name="form">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="text" 
    	name="email" 
    	class="form-control"
    	ng-class="{red : form.email.$dirty && form.email.$invalid }" 
    	ng-model="email" 
    	id="exampleInputEmail1" 
    	placeholder="Enter email" 
    	ng-minlength=2 
        ng-maxlength=20 required>
    <span ng-show="form.email.$dirty && form.email.$invalid" style="color:red;">
    	<span ng-show="form.email.$error.required">This must be filled<br></span>
	    <span ng-show="form.email.$dirty">already dirty because itz touched<br></span>
	    <span ng-show="form.email.$invalid">already invalid from the start<br></span>
	    <span ng-show="form.email.$pristine">pristine means form never touched<br></span>
	    <span ng-show="form.email.$valid">already valid<br></span>
	    <span ng-show="form.email.$error.minlength">Write at least 2<br></span>
	    <span ng-show="email == 'Ss' ">Only write S ?<br></span>

    </span>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputFile">File input</label>
    <input type="file" id="exampleInputFile">
    <p class="help-block">Example block-level help text here.</p>
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Check me out
    </label>
  </div>
  <button type="button" ng-click="resetForm()" class="btn btn-default">Reset</button>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

@stop

@section('script')
<script type="text/javascript">
var app = angular.module("ui.boardingpassku", ['ui.bootstrap','ngSanitize']);
app.controller("MainCtrl", function ($scope, $http, $filter) {


$scope.resetForm = function ()
    {
      $scope.form.$setPristine();
    };

});


angular.element(document).ready(function () {
    // var scope = angular.element($("body")).scope();
    // scope.$apply(function(){
    //     scope.field.BRTH_DATE_DD = scope.field.BRTH_DATE.toString().substring(8, 10)
    //     scope.field.BRTH_DATE_MM = scope.field.BRTH_DATE.toString().substring(5, 7);
    //     scope.field.BRTH_DATE_YY = scope.field.BRTH_DATE.toString().substring(0, 4);

    //     if(scope.detail.GRDTN_DATE != null){
    //         scope.detail.GRDTN_DATE_DD = scope.detail.GRDTN_DATE.toString().substring(8, 10)
    //         scope.detail.GRDTN_DATE_MM = scope.detail.GRDTN_DATE.toString().substring(5, 7);
    //         scope.detail.GRDTN_DATE_YY = scope.detail.GRDTN_DATE.toString().substring(0, 4);
    //     }
    // })
    
});
</script>
@stop