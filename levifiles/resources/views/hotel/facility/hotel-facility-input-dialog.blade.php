<div id="myModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" data-options="close_on_background_click:false;close_on_esc:false;">
  <b id="title">Input Facility</h2>
  <div class="row">
  	<div class="small-12 columns">
  		<form method="POST" action="{{ url('hotel/facility/save') }}">
  			<input type="hidden" value="{{ csrf_token() }}" name="_token">
  			<div class="row">
	  			<div class="small-2 columns">
	  				<label for="facility" class="right inline">Facility</label>
	  			</div>
	  			<div class="small-10 columns left">
	  				<input type="text" name="facility">
	  			</div>
  			</div>

  			<div class="row">
  				<div class="small-10 small-offset-2 columns">
  					<button class="btn small" type="submit">Add</button>
  				</div>
  			</div>
  		</form>
  	</div>
  </div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>