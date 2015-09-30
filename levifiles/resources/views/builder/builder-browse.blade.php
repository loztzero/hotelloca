@extends('layouts.frontpage')
@section('content')
<div class="row">
	<form role="form">
		<div class="form-group">
			<label for="exampleInputPassword1">Select Table</label>
			<select class="form-control">
				@foreach ($tables as $table)
					<option>{{$table->TABLE_NAME}}</options>
				@endforeach
			</select>
		</div>
	</form>
</div>
@stop