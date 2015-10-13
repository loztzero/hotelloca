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
					<input type="password" name="password">
				</label>

				<button type="submit" class="button small right">LOGIN</button>
				<div style="clear:both;"></div>
			</form>
		</div>
	</div>
	<div style="clear:both;"></div>
	<div class="large-12 columns">
		<div style="text-align:justify;">
			<h1>Term And Condition</h1>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean semper leo neque, et convallis lacus porta ac. Praesent et justo eget tortor ullamcorper finibus non non lacus. Pellentesque facilisis, libero non lobortis porttitor, felis ante ornare nunc, nec accumsan elit risus hendrerit ipsum. In porttitor ullamcorper urna, vel pellentesque nisi finibus id. Quisque commodo lacinia ultrices. Suspendisse non ligula eu arcu aliquam maximus vel a neque. Etiam fermentum, quam a tincidunt commodo, lectus tortor faucibus ex, iaculis iaculis nunc est nec eros. Suspendisse vitae nibh urna. Donec erat arcu, egestas et quam et, facilisis iaculis nulla. Curabitur bibendum enim est.<br><br>

			Nulla at ullamcorper est. Suspendisse pellentesque ornare dolor a efficitur. Quisque sit amet mollis enim, at lacinia elit. Nam malesuada lacus vel erat porttitor, et maximus turpis dignissim. Duis et sapien ornare, sagittis metus eu, maximus turpis. Donec commodo facilisis cursus. Praesent mattis pellentesque finibus.<br><br>

			Sed nec turpis a sem efficitur elementum nec id tellus. Nullam luctus justo odio, at luctus lectus euismod ut. Maecenas molestie ullamcorper nisi, ac lacinia arcu laoreet in. Phasellus nec odio quis ipsum hendrerit tristique. Nam finibus risus at metus lacinia volutpat. Phasellus egestas blandit nulla, eu pellentesque enim tristique non. Aliquam non volutpat nulla. Nulla fringilla vel turpis vel pretium. Maecenas elit ligula, vestibulum nec fringilla vel, ornare at leo. Duis non ipsum sollicitudin, gravida augue in, convallis metus. Duis massa dui, maximus at risus eget, interdum placerat mi.
		</div>
	</div>
</div>


@endsection
