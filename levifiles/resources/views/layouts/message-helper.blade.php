@if (Session::has('error'))
	<div data-alert class="alert-box alert ">
		<i class="fi-alert"></i> Error<br>
		@foreach(Session::get('error') as $error)
		- {{$error}}<br>
		@endforeach
	  <a href="#" class="close">&times;</a>
	</div>
@elseif(Session::has('message'))
	<div data-alert class="alert-box success ">
		@foreach(Session::get('message') as $message)
		- {{$message}}<br>
		@endforeach
	  <a href="#" class="close">&times;</a>
	</div>
@endif 