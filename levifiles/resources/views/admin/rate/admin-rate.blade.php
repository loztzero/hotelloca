@extends('layouts.layout-hotel-admin')
@section('content')
	
<div class="row" ng-controller="MainCtrl">
	<div class="large-12 columns">

		<h3>Browse Rate</h3>
		@include('layouts.message-helper')

		<form class="form-horizontal" role="form" method="GET" action="{{url('admin/rate')}}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="large-3 medium-4 columns">
		          <label for="orderNo" class="right inline show-for-medium-up">Date Period From / To
		          </label>
		          <label for="orderNo" class="show-for-small-only">Date Period</label>
		        </div>
		        <div class="small-12 medium-8 large-3 columns left">
		        	<input type="text" class="span2" value="" id="dateFrom" name="date_from" value="{{ isset($request->date_from) ? $request->date_from : ''  }}">
		        </div>

		        <div class="small-12 medium-8 large-3 columns left">
		        	<input type="text" class="span2" value="" id="dateTo" name="date_end">
		        </div>
		    </div>
	    	
		    <div class="row">
		        <div class="small-12 medium-5 large-4 large-offset-3 medium-offset-4 columns left">
		          <button type="submit" class="button small">Search</button>
		        </div>
		    </div>
		</form>

		<table>
			<caption style="text-align:left;">
				<a href="{{ url('admin/rate/input')}}">Add New Daily Rate</a>
			</caption>
		  <thead>
		    <tr>
		      <th class="action-gap">Aksi</th>
		      <th>Date</th>
		      <th>Currency 1</th>
		      <th>Value Currency 1</th>
		      <th>Currency 2</th>
		      <th>Value Currency 2</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($rates as $rate)
		  	<tr>
		  		<td>
		  			<form action="{{ url('admin/rate/load-data')}}" method="post" class="left">
						<input type="hidden" value="{{ csrf_token() }}" name="_token">
		            	<input type="hidden" value="{{ $rate->id }}" name="id">
		            	<button type="submit" class="tiny rem-btm-margin" title="Edit Rate"><i class="fi-page-edit"></i></button>
					</form>
		  		</td>
			  	<td>{{ $helpers::dateFormatter($rate->daily_period) }}</td>
			  	<td>{{ $rate->currency1->curr_name }}</td>
			  	<td class="numeric-value">{{ number_format($rate->kurs1_val, 2, '.', ',') }}</td>
			  	<td>{{ $rate->currency2->curr_name }}</td>
			  	<td class="numeric-value">{{ number_format($rate->kurs2_val, 2, '.', ',') }}</td>
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

$('#dateFrom').fdatepicker({
	format : 'dd-mm-yyyy'
});

$('#dateTo').fdatepicker({
	format : 'dd-mm-yyyy'
});

@if(Input::get('date_end') != null)
$('#dateTo').fdatepicker('setDate', new Date({{ strtotime(Input::get('date_end')) * 1000 }}));
@endif

@if(Input::get('date_from') != null)
$('#dateFrom').fdatepicker('setDate', new Date({{ strtotime(Input::get('date_from')) * 1000 }}));
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