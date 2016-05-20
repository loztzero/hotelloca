@extends('layouts.general-travel-layout')

@section('titleContainer')
	<div class="page-title-container">
	    <div class="container">
	        <div class="page-title pull-left">
	            <h2 class="entry-title">Deposit Agent</h2>
	        </div>
	        <ul class="breadcrumbs pull-right">
	            <li><a href="#">Admin</a></li>
	            <li class="active">Deposit Agent</li>
	        </ul>
	    </div>
	</div>
@endsection

@section('content')
	<div class="container" ng-controller="MainCtrl">

		<div class="travelo-box">
			<form action="{{ url('/admin/agent-deposit') }}" method="get" >

				<h3>Deposit Agent</h3>
				@include('layouts.message-helper')
			    <div class="row form-group">
			        <div class="col-xs-12">
			            <label>Agent</label>
			            <input type="text" class="input-text full-width" value="{{ Request::get('email') }}" id="email" name="email">
			        </div>
			    </div>

			    <div class="row form-group">
			        <div class="col-xs-12">
			            <button type="submit" class="button small">Search</button>
			        </div>
			    </div>
			</form>
		</div>

		<div class="travelo-box">
			<table class="table table-striped">
				<caption style="text-align:left;">
					<a href="{{ url('admin/agent-deposit/input')}}" class="view"><i class="soap-icon-roundtriangle-right"></i>&nbsp;&nbsp; Add New Deposit</a>
				</caption>
				<thead>
					<tr>
						<th width="100px">Action</th>
						<th>Agent</th>
						<th>Email</th>
						<th class="hide-for-small">Currency</th>
						<th class="hide-for-small td-right">Deposit Value</th>
						<th class="hide-for-small td-right">Used Value</th>
						<th class="hide-for-small td-right">Remaining Deposit</th>
					</tr>
				</thead>
				<tbody>
					@foreach($deposits as $deposit)
					<tr>
						<td>
							<form action="{{URL::to('admin/agent-deposit/load-data')}}" method="post" class="pull-left">
								<input type="hidden" value="{{ csrf_token() }}" name="_token">
				            	<input type="hidden" value="{{ $deposit->email }}" name="email">
				            	<button type="submit" class="btn-primary" title="Edit Deposit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
							</form>
						</td>
						<td>{{ $deposit->comp_name }}</td>
						<td class="hide-for-small">{{ $deposit->email }}</td>
						<td class="hide-for-small">{{ $deposit->curr_code }}</td>
						<td class="hide-for-small td-right">{{ number_format($deposit->deposit_value, 0, ',', '.') }}</td>
						<td class="hide-for-small td-right">{{ number_format($deposit->used_value, 0, ',', '.') }}</td>
						<td class="hide-for-small td-right">{{ number_format($deposit->remain_value, 0, ',', '.') }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7" id="pagination">
							{{--} $hotelList->appends(Request::only('hotel_name', 'country', 'city'))->render()--}}
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
@endsection

@section('script')
<script>
	var app = angular.module("ui.hotelloca", []);
	app.controller("MainCtrl", function ($scope, $http, $filter) {


	});
</script>
@endsection
