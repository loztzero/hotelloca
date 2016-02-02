@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Admin</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	        	<li><a href="#">Admin</a></li>
	            <li class="active">Rate</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	
<div class="container" ng-controller="MainCtrl">

	<div class="travelo-box">


		<form role="form" method="GET" action="{{url('admin/rate')}}">

			<h3>Browse Rate</h3>
			@include('layouts.message-helper')

			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row form-group">
				<div class="col-xs-6">
					<label>Date Period From</label>
					<div class="datepicker-wrap">
		          		<input type="text" class="input-text full-width" value="" id="dateFrom" name="date_from" value="{{ isset($request->date_from) ? $request->date_from : ''  }}">
		          	</div>
				</div>

				<div class="col-xs-6">
					<label>Date Period To</label>
					<div class="datepicker-wrap">
			          	<input type="text" class="input-text full-width" value="" id="dateTo" name="date_end">
		          	</div>
				</div>
		    </div>
	    	
		    <div class="row form-group">
		        <div class="col-xs-12">
		          <button type="submit" class="button">Search</button>
		        </div>
		    </div>
		</form>
	</div>

	<div class="travelo-box">

		<table class="table table-striped">
			<caption style="text-align:left;">
				<a href="{{ url('admin/rate/input')}}" class="view"><i class="soap-icon-roundtriangle-right"></i>&nbsp;&nbsp; Add New Daily Rate</a>
			</caption>
			<thead>
				<tr>
					<th>Aksi</th>
					<th>Date</th>
					<th>Currency 1</th>
					<th style="text-align:right">Value Currency 1</th>
					<th>Currency 2</th>
					<th style="text-align:right">Value Currency 2</th>
				</tr>
			</thead>
		  	<tbody>
		  	@foreach($rates as $rate)
			  	<tr>
			  		<td>
			  			<form action="{{ url('admin/rate/load-data')}}" method="post" class="left">
							<input type="hidden" value="{{ csrf_token() }}" name="_token">
			            	<input type="hidden" value="{{ $rate->id }}" name="id">
			            	<button type="submit" class="btn-primary" title="Edit Rate"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
						</form>
			  		</td>
				  	<td>{{ $helpers::dateFormatter($rate->daily_period) }}</td>
				  	<td>{{ $rate->currency1->curr_name }}</td>
				  	<td style="text-align:right">{{ number_format($rate->kurs1_val, 2, '.', ',') }}</td>
				  	<td>{{ $rate->currency2->curr_name }}</td>
				  	<td style="text-align:right">{{ number_format($rate->kurs2_val, 2, '.', ',') }}</td>
			  	</tr>
		  	@endforeach
		  </tbody>
		  <tfoot>
		  	<tr>
		  		<td colspan="6">
		  		{{-- 	{!! str_replace('/?', '?', $unitList->appends(Request::only('kodeUnit', 'namaUnit', 'status'))->render())!!} --}}

		  		</td>
		  	</tr>
		  </tfoot>
		</table>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">

tjq('#dateFrom').datepicker({
    showOn: 'button',
    buttonImage: '{{ url("assets/images/icon/blank.png") }}',
    buttonText: '',
    buttonImageOnly: true,
    changeYear: false,
    dateFormat: "dd-mm-yy",
    dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
    beforeShow: function(input, inst) {
        var themeClass = tjq(input).parent().attr("class").replace("datepicker-wrap", "");
        tjq('#ui-datepicker-div').attr("class", "");
        tjq('#ui-datepicker-div').addClass("ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all");
        tjq('#ui-datepicker-div').addClass(themeClass);
    }
});

tjq('#dateTo').datepicker({
    showOn: 'button',
    buttonImage: '{{ url("assets/images/icon/blank.png") }}',
    buttonText: '',
    buttonImageOnly: true,
    changeYear: false,
    dateFormat: "dd-mm-yy",
    dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
    beforeShow: function(input, inst) {
        var themeClass = tjq(input).parent().attr("class").replace("datepicker-wrap", "");
        tjq('#ui-datepicker-div').attr("class", "");
        tjq('#ui-datepicker-div').addClass("ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all");
        tjq('#ui-datepicker-div').addClass(themeClass);
    }
});

// tjq('#dateTo').fdatepicker({
// 	format : 'dd-mm-yyyy'
// });

@if(Input::get('date_end') != null)
tjq('#dateTo').datepicker('setDate', new Date({{ strtotime(Input::get('date_end')) * 1000 }}));
@endif

@if(Input::get('date_from') != null)
tjq('#dateFrom').datepicker('setDate', new Date({{ strtotime(Input::get('date_from')) * 1000 }}));
@endif


//set default date
//$('#transferDate').fdatepicker('setDate', new Date());

</script>

<script>

var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function ($scope, $http, $filter) {


});

// app.directive('helloWorld', function(){
// 	return {
// 		restrict : 'E',
// 		templateUrl : "{{url('/assets/directivepartial')}}/hello.html"
// 	}
// })
</script>
@stop