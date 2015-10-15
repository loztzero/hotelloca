@extends('layouts.foundation-angular')
@section('content')
<div class="row">
	<div class="large-8 columns hide-for-small hide-for-medium">
		<ul class="example-orbit" data-orbit data-options="bullets:false;">
		  <li>
		    <img src="http://localhost:8080/hotelloca/assets/img/promo.jpg" alt="slide 1" />
		    <div class="orbit-caption">
		      Caption One.
		    </div>
		  </li>
		  <li class="active">
		    <img src="http://localhost:8080/hotelloca/assets/img/promo.jpg" alt="slide 2" />
		    <div class="orbit-caption">
		      Caption Two.
		    </div>
		  </li>
		  <li>
		    <img src="http://localhost:8080/hotelloca/assets/img/promo.jpg" alt="slide 3" />
		    <div class="orbit-caption">
		      Caption Three.
		    </div>
		  </li>
		</ul>
	</div>

	<div class="large-4 columns">
		<div class="panel">
			<b>Partner Login</b>
			<hr>
			@if (count($errors) > 0)
			<div data-alert class="alert-box alert">
				<a href="#" class="close">&times;</a>
				<strong>Whoops!</strong> There were some problems with your input.<br><br>
				
					@foreach ($errors->all() as $error)
					- {{ $error }}<br>
					@endforeach
				
			</div>
			@endif

			<form class="form-horizontal" role="form" method="POST" action="{{App::make('url')->to('/')}}/auth/login">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<label>Email Address
					<input type="email" class="sm" name="email" value="{{ old('email') }}">
				</label>

				<label>Password
					<input type="password" name="password">
				</label>

				<button type="submit" class="button small right">LOGIN</button>
				<div style="clear:both;"></div>
			</form>
		</div>
	</div>

</div>

<div class="row">
	<div class="large-4 columns">
		<div class="panel">
			Put The Promotion Here
			Using Picture Or Panel
		</div>
	</div>

	<div class="large-4 columns">
		<div class="panel">
			Put The Promotion Here
			Using Picture Or Panel
		</div>
	</div>

	<div class="large-4 columns">
		<div class="panel">
			Put The Promotion Here
			Using Picture Or Panel
		</div>
	</div>

	<div class="large-4 columns">
		<div class="panel">
			Put The Promotion Here
			Using Picture Or Panel
		</div>
	</div>

	<div class="large-4 columns">
		<div class="panel">
			This Is The Fifth Panel
			The Special Center One
		</div>
	</div>

	<div class="large-4 columns">
		<div class="panel">
			Put The Promotion Here
			Using Picture Or Panel
		</div>
	</div>

	<div class="large-4 columns">
		<div class="panel">
			Put The Promotion Here
			Using Picture Or Panel
		</div>
	</div>

	<div class="large-4 columns">
		<div class="panel">
			Put The Promotion Here
			Using Picture Or Panel
		</div>
	</div>

	<div class="large-4 columns">
		<div class="panel">
			Put The Promotion Here
			Using Picture Or Panel
		</div>
	</div>

</div>

@endsection
