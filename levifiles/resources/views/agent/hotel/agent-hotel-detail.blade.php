@extends('layouts.layout-agent')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<div class="row">
		<div class="large-12 column">
			
			<a>
				<b style="font-size:18px;">{{ $hotel->hotel_name }}</b>
				<div class="rateit" data-rateit-value="{{ $hotel->star }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
			</a>

			<p style="font-size:13px;">
				{{ $hotel->address }}, {{ $hotel->city->city_name }}
			</p>
			
			<div class="large-7 column">
				<ul class="example-orbit" data-orbit data-options="bullets:false;">
					@foreach($pictures as $picture)
					  <li>
					    <img src="{{ url('uploads/hotels/'.$hotel->id.'/'.$picture->pict.'.jpg') }}" alt="slide 1" />
					    <div class="orbit-caption">
					      {{ $picture->description }}
					    </div>
					  </li>
					@endforeach
				</ul>
			</div>

			<div class="large-5 column">
				<ul class="large-block-grid-2 hide-for-medium hide-for-small">
					<?php $counter = 1 ;?>
					@foreach($pictures as $picture)

						@if($counter <= 6)
						<li>
							<img src="{{ url('uploads/hotels/'.$hotel->id.'/'.$picture->pict.'.jpg') }}" alt="slide 1" />
						</li>
						@endif
					
						<?php $counter++ ;?>
					@endforeach
					<li>
						<a href="">Show All Picture</a>
					</li>
				</ul>
			</div>

		</div>
	</div>

	<div class="row">

		<div class="large-12 column">
			Room for 3 Nights from {{ Input::get('checkIn') }} to {{ Input::get('checkOut') }}
		</div>

		<div class="large-12 column">
			<div class="row">
		    	<div class="large-3 columns large-offset-2">
		    		<label>Check In
		    			<input type="text" class="span2" value="" id="dp1" readonly name="checkIn" style="float:left;">
		    		</label>
		    	</div>

		    	<div class="large-2 columns">
		    		<label>Night
		    			<select id="night">
		    				@for($i = 1;$i <= 30; $i++)
		    				<option value={{$i}}>{{$i}}</option>
		    				@endfor
		    			</select>
		    		</label>
		    	</div>
		    	<div class="large-3 columns left">
		    		<label>Check Out
		    			<?php
		    				$checkOut = new DateTime('+1 day');
		    				//{{$checkOut->format('d-m-Y')}}
		    			?>
		    			<input type="text" class="span2" value="" id="dp2" readonly name="checkOut">
		    		</label>
		    	</div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Adult</label>
		          <label for="right-label" class="show-for-small-only">Adult</label>
		        </div>
		        <div class="small-12 medium-9 large-2 columns left">
		          {!! Form::select('adults', array('1' => '1', '2' => '2', '3' => '3', '4' => '4'), null) !!}
		        </div>

		        <div class="large-2 medium-12 columns">
		        	<!-- foundation bug ?? -->
		        </div>

		        <div class="large-2 medium-3 large-offset-1 columns left">
		          <label for="endDate" class="right inline show-for-medium-up">Children</label>
		          <label for="endDate" class="show-for-small-only">Children</label>
		        </div>
		        <div class="small-12 medium-9 large-2 columns left">
	          		{!! Form::select('children', array('0' => '0', '1' => '1', '2' => '2'), null) !!}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		          <label for="right-label" class="right inline show-for-medium-up">Room</label>
		          <label for="right-label" class="show-for-small-only">Room</label>
		        </div>
		        <div class="small-12 medium-9 large-2 columns left">
		          	{!! Form::select('children', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'), null) !!}
		        </div>
		    </div>

		    <div class="row">
				<div class="large-2 medium-3 columns">
		        </div>
		        <div class="small-12 medium-9 large-4 large-offset-2 medium-offset-3 columns left">
		          <button type="submit" class="button small">Search</button>
		        </div>
		    </div>
		</div>

	</div>

	<div class="row">

		<pre>
			@foreach($period as $date)
			{{ $date->format("Y-m-d") }}<br>
			@endforeach
		</pre>

		<table>
			<thead>
				<tr>
					<th></th>
					<th>Tipe Kamar</th>
					<th>Jumlah Tamu</th>
					<th>Jumlah</th>
					<th>Harga Total</th>
					<th>Net Value</th>
					<th>From</th>
					<th>End</th>
					<th>Hari</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				<?php $roomId = null ;?>
				<?php $total = 0; ?>
				@foreach($rooms as $room)

					{{-- Looping hari per room --}}
					@foreach($period as $date)
						@if($helpers::isDate1BetweenDate2AndDate3($date->format("Y-m-d"), $room->from_date, $room->end_date))
							<?php $total += $room->nett_value ;?>
						@endif
					@endforeach

					{{-- Jika room id berbeda dengan room id yang sebelumnya --}}
					@if($roomId != $room->mst023_id)
					<?php $roomId = $room->mst023_id ;?>
					<?php //$total = 0; ?>
					<tr>
						<td>
							{{ $room->image }}
						</td>
						<td>
							{{ $room->room_name }}
						</td>
						<td>
							{{ $room->num_adults }} Dewasa {{ $room->num_child }} Anak
						</td>
						<td>
							{!! Form::select('room', array('1' => '1', '2' => '2'), null) !!}
						</td>
						<td>
							{{ $total }}
						</td>
						<td>
							{{ $room->nett_value }}
						</td>
						<td>
							{{ $room->from_date }}
						</td>
						<td>
							{{ $room->end_date }}
						</td>
						<td>
							@foreach($period as $date)
							{{ $date->format("Y-m-d") . ' : ' . $helpers::isDate1BetweenDate2AndDate3($date->format("Y-m-d"), $room->from_date, $room->end_date) }}
							@endforeach
						</td>
						<td>
							<button class="button warning" style="padding:8px;border-radius:5px;margin-bottom:0px;"><b style="font-size:12px;font-family: Arial 'San serif';">Booking</b></button>
						</td>
					</tr>
					@endif
				@endforeach
			</tbody>

		</table>
	</div>
	
	
</div>
@stop

@section('script')
<script>
var app = angular.module("ui.hotelloca", ['ngSanitize']);
app.controller("MainCtrl", function ($scope, $http, $filter) {


});
</script>
@stop