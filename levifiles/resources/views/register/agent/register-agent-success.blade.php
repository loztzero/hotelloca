@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Success</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li>Register</li>
	            <li>Agent</li>
                <li class="active">Success</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
<div class="container">

	<div class="travelo-box long-description">
		<div style="text-align:justify;">
			<h1>Registration Success</h1>
			Thank you for register as our partner.<br>
            Please check your email.

            <br><br>
            If you already do the email activation, you can login to our system.<br>
            <a href="{{ url('auth/login') }}" class="button">Go To Login Page</a>
		</div>
	</div>
</div>


@endsection
