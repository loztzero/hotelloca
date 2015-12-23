@if (Session::has('error'))
	<div data-alert class="alert-box alert ">
		<i class="fi-alert"></i> Error<br>
		@if(is_array(Session::get('error')))
			@foreach(Session::get('error') as $error)
			- {{$error}}<br>
			@endforeach
		@else
			- {{ Session::get('error') }}<br>
		@endif
		
	  <a href="#" class="close">&times;</a>
	</div>
@elseif(Session::has('message'))
	<div data-alert class="alert-box success ">
		@if(is_array(Session::get('message')))
			@foreach(Session::get('message') as $message)
			- {{$message}}<br>
			@endforeach
		@else
			- {{ Session::get('message') }}<br>
		@endif

	  <a href="#" class="close">&times;</a>
	</div>
@endif 