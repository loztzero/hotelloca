@if (Session::has('error'))
    <div class="alert alert-error">
	    @if(is_array(Session::get('error')))
			@foreach(Session::get('error') as $error)
			Error : {{$error}}<br>
			@endforeach
		@else
			Error : {{ Session::get('error') }}<br>
		@endif
	    <span class="close"></span>
	</div>
@elseif(Session::has('message'))
	<div class="alert alert-success">
        @if(is_array(Session::get('message')))
			@foreach(Session::get('message') as $message)
			{{$message}}<br>
			@endforeach
		@else
			{{ Session::get('message') }}<br>
		@endif
        <span class="close"></span>
    </div>
@endif 



                
