@extends('layouts.foundation-angular')
@section('content')
<div class="row">
	<h3>Agent Register</h3>
	<div class="large-12 colums">
		<form class="form-horizontal" role="form" method="POST" action="{{App::make('url')->to('/')}}/auth/bebek">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Company Name *</label>
		          <label for="right-label" class="show-for-small-only">Company Name *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="" id="dp1">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Address *</label>
		          <label for="right-label" class="show-for-small-only">Address *</label>
		        </div>
		        <div class="small-12 medium-9 large-7 columns left">
		          <textarea id="dp1"style="height:5em;"></textarea>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Postcode *</label>
		          <label for="right-label" class="show-for-small-only">Postcode *</label>
		        </div>
		        <div class="small-12 medium-9 large-3 columns left">
		          <input type="text" class="span2" value="" id="dp1">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Country *</label>
		          <label for="right-label" class="show-for-small-only">Country *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <select>
		          </select>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">City *</label>
		          <label for="right-label" class="show-for-small-only">City *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <select>
		          </select>
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Phone Number *</label>
		          <label for="right-label" class="show-for-small-only">Phone Number *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="" id="dp1">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Fax No</label>
		          <label for="right-label" class="show-for-small-only">Fax No</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="" id="dp1">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Email Address *</label>
		          <label for="right-label" class="show-for-small-only">Email Address *</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="" id="dp1">
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Website</label>
		          <label for="right-label" class="show-for-small-only">Website</label>
		        </div>
		        <div class="small-12 medium-9 large-4 columns left">
		          <input type="text" class="span2" value="" id="dp1">
		        </div>
		    </div>

		    <div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
					<input id="checkbox1" type="checkbox">
					<small>
						Check for agreed to the <a href="#">Terms & Conditions</a>
					</small>		          
		        </div>
		    </div>

	    	<div class="row">
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
					<button type="submit" class="button small">Register</button>          
		        </div>
		    </div>
	    	
		</form>
	</div>
</div>

@endsection
