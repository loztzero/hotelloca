@if (Session::has('error'))
    <div class="alert alert-danger" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Error:</span>
	  {{Session::get('error')}}
	</div>
@elseif(Session::has('message'))
	<div class="alert alert-info" role="alert">
	  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
	  {{Session::get('message')}}
	</div>
@endif 