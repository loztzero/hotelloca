@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Activation</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li>Register</li>
	            <li>Agent</li>
                <li class="active">Activation</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
<div class="container">

	<div class="travelo-box long-description">
		<div style="text-align:justify;">
			<h1>Activation</h1>
			{{ $message }}<br>
            <a href="{{ url('auth/login') }}" class="button">Go To Login Page</a>

		</div>
	</div>
</div>


@endsection
