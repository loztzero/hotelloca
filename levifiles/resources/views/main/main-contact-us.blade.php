@extends('layouts.foundation-angular')
@section('content')

<div class="row" style="padding:20px 0px;">
	@include('main.main-pic-slide')

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
