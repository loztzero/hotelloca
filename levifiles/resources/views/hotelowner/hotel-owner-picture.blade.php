@extends('layouts.layout-hotel-owner')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<h3>Hotel Pictures</h3>
	@include('layouts.message-helper')
{{-- 
	<style>
		button.file-upload > input[type='file'] {
		    cursor: pointer;
		    position: absolute;
		    font-size: 0;
		    top: 0;
		    left: 0;
		    opacity: 0;
		    height: 100%;
		    width: 100%;
		}
	</style>

	$('input[name="uploadfile"]').change(function(){
    var fileName = $(this).val();
    alert(fileName);
	}); --}}
	<div class="large-12 column">
		<form method="post" action="{{ url('hotel-owner/hotel-picture') }}" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="large-3 column">
			  <input type="file" name="files" />
			</div>
			<div class="large-3 column">
			  <input type="text" name="title" placeholder="Title" />
			</div>
			<div class="large-3 column left">
			  <button type="submit" class="tiny">Upload New Picture</button>
			</div>
		</form>
	</div>

	<div class="large-12 column" style="margin-bottom:20px;">
		<small>Note: <b>Must Upload picture with ratio 3:2 at least 300px x 200px, recomended at least 450px x 300px, and picture size up to 250 kilobytes</b></small>
	</div>

	<ul class="small-blog-grid-1 large-block-grid-4 medium-block-grid-3">
		@foreach($hotelDetail->pictures as $picture)
		<li>
			<div style="position:relative;">
				<form style="position:absolute;" method="post" action="{{ url('hotel-owner/delete-hotel-picture') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" value="{{ $picture->id }}">
					<button type="submit" class="tiny alert confirm-delete" style="opacity:0.8"><i class="fi-minus-circle"></i></button>
				</form>
				<a class="th" role="button" aria-label="Thumbnail" href="{{ url('uploads/hotels/'.$hotelDetail->id.'/'.$picture->pict.'.jpg') }}" data-lightbox="image-1" data-title="{{ $picture->description }}">
					<img src="{{ url('uploads/hotels/'.$hotelDetail->id.'/'.$picture->pict.'.jpg') }}">
				</a>
			<div>
		</li>
		@endforeach
		<li>
			<a class="th" role="button" aria-label="Thumbnail" href="http://localhost:8080/hotelloca/assets/img/promo.jpg" data-lightbox="image-1" data-title="My caption">
				<img src="http://localhost:8080/hotelloca/assets/img/promo.jpg">
			</a>
		</li>
		<li>
			<a class="th" role="button" aria-label="Thumbnail" href="http://localhost:8080/hotelloca/assets/img/promo.jpg" data-lightbox="image-1" data-title="My caption">
				<img src="http://localhost:8080/hotelloca/assets/img/promo.jpg">
			</a>
		</li>
		<li>
			<a class="th" role="button" aria-label="Thumbnail" href="http://localhost:8080/hotelloca/assets/img/promo.jpg" data-lightbox="image-1" data-title="My caption">
				<img src="http://localhost:8080/hotelloca/assets/img/promo.jpg">
			</a>
		</li>
		<li>
			<a class="th" role="button" aria-label="Thumbnail" href="http://localhost:8080/hotelloca/assets/img/promo.jpg" data-lightbox="image-1" data-title="My caption">
				<img src="http://localhost:8080/hotelloca/assets/img/promo.jpg">
			</a>
		</li>
		<li>
			<a class="th" role="button" aria-label="Thumbnail" href="http://localhost:8080/hotelloca/assets/img/promo.jpg" data-lightbox="image-1" data-title="My caption">
				<img src="http://localhost:8080/hotelloca/assets/img/promo.jpg">
			</a>
		</li>
		<li>
			<a class="th" role="button" aria-label="Thumbnail" href="http://localhost:8080/hotelloca/assets/img/promo.jpg" data-lightbox="image-1" data-title="My caption">
				<img src="http://localhost:8080/hotelloca/assets/img/promo.jpg">
			</a>
		</li>
	</ul>
</div>

@endsection

@section('script')
<script>

$(".confirm-delete").on("click", function(e) {
	e.preventDefault();
	var form = $(this).parents('form');
	swal({   
		title: "Are you sure?",   
		text: "This picture will be deleted",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#f04124",   
		confirmButtonText: "Yes, delete it!",   
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
