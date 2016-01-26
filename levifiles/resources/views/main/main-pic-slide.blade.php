<div class="large-8 columns hide-for-small hide-for-medium">
	<ul class="example-orbit" data-orbit data-options="bullets:false;">
	  <li>
	    <img src="{{ url() }}/assets/img/promo.jpg" alt="slide 1" />
	    <div class="orbit-caption">
	      Caption One.
	    </div>
	  </li>
	  <li class="active">
	    <img src="{{ url() }}/assets/img/promo.jpg" alt="slide 2" />
	    <div class="orbit-caption">
	      Caption Two.
	    </div>
	  </li>
	  <li>
	    <img src="{{ url() }}/assets/img/promo.jpg" alt="slide 3" />
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

		@if(Session::has('error'))
		<div data-alert class="alert-box alert">
			<a href="#" class="close">&times;</a>
			- {{ Session::get('error') }}			
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

			<span style="font-size:12px;"><a href="{{ url('auth/register') }}">Register New Account Here</a></span>
			<button type="submit" class="button small right">LOGIN</button>
			<div style="clear:both;"></div>
		</form>
	</div>
</div>