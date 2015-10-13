@extends('layouts.foundation-login')
@section('content')

<div class="row" style="padding:20px 0px;">
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
					<input type="text" name="password">
				</label>

				<button type="submit" class="button small right">LOGIN</button>
				<div style="clear:both;"></div>
			</form>
		</div>
	</div>
	<div style="clear:both;"></div>
	<div class="large-12 columns">
		<div class="panel">
			<div class="row">
				<div class="large-6 column">
					<form class="form-horizontal" role="form" method="POST" action="{{App::make('url')->to('/')}}/auth/login">
						<b>Contact Us</b>
						<hr>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<label>Name
							<input type="text" class="sm" name="name" value="{{ old('name') }}">
						</label>

						<label>Email Address
							<input type="email" class="sm" name="email" value="{{ old('email') }}">
						</label>

						<label>Phone
							<input type="text" class="sm" name="name" value="{{ old('name') }}">
						</label>

						<label>Subject
							<textarea name="subject"></textarea>
						</label>

						<button type="submit" class="button small right">Send</button>
						<div style="clear:both;"></div>
					</form>
				</div>

				<div class="large-6 column">
					<b>Head Office</b>
					<hr>
					Alamat Dll


				</div>
			</div>
		</div>
	</div>
</div>


@endsection
