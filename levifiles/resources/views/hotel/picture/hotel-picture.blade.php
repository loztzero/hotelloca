@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Hotel Picture</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Hotel</a></li>
	            <li class="active">Pictures</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
<div class="container" ng-controller="MainCtrl">
	
	<h3>Hotel Pictures</h3>
	@include('layouts.message-helper')

	<div class="travelo-box">
		<form method="post" action="{{ url('hotel/picture/save') }}" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row form-group">
				<div class="col-xs-6">
					<label>Select A Picture</label>
				  	<input type="file" name="files" />
				</div>
				<div class="col-xs-6">
					<label>Title</label>
				  	<input type="text" name="title" class="input-text full-width" placeholder="Title" />
				</div>
		    </div>

		    <div class="row form-group">
			    <div class="col-xs-6">
			  		<button type="submit">Upload New Picture</button>
				</div>
		    </div>

		    <div class="row form-group">
			    <div class="col-xs-12">
			  		<small>Note: <b>Must Upload picture with ratio 3:2 at least 300px x 200px, recomended at least 450px x 300px, and picture size up to 250 kilobytes</b></small>
				</div>
		    </div>
		</form>
	</div>

	<div class="items-container isotope image-box style9 row">
		@foreach($hotelDetail->pictures as $picture)
		    <div class="iso-item col-xs-12 col-sms-6 col-sm-6 col-md-3">
		        <article class="box">
		            <figure>
		            	<form method="post" action="{{ url('hotel/picture/delete') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{ $picture->id }}">
		                	<a class="hover-effect confirm-delete" title="" href="#"><img width="270" height="160" alt="" src="{{ url('uploads/hotels/'.$hotelDetail->id.'/'.$picture->pict.'.jpg') }}"></a>
						</form>
		            </figure>
		            <div class="details">
		                <h4 class="box-title">{{ $picture->description }}<small></h4>
		            </div>
		        </article>
		    </div>
		@endforeach
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
