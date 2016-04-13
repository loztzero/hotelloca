<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Voucher</title>

<style>
.full-width {width: 100%;}
.right {text-align: right;}
.small-gap {width: 5px;vertical-align: top;}
.td-left {width: 120px;vertical-align: top;}
</style>
</head>
<body>

<table class="full-width">
	<tr>
		<td><img src="{{ url() . '/assets/images/logo.png' }}"</td>
		<td style="vertical-align:bottom;text-align:right">Hotel Voucher</td>
	</tr>
</table>

<hr>
<table class="full-width">
	<tr>
		<td class="right">Booking Number : </td>
		<td>{{ $voucher->order_no }}</td>
		<td class="right">Booking Date :</td>
		<td>{{ $helpers::dateFormatterMysql($voucher->order_date) }}</td>
	</tr>
	<tr>
		<td class="right">Guest : </td>
		<td>{{ $voucher->guest }}</td>
		<td class="right">Status :</td>
		<td>{{ $voucher->status_flag }}</td>
	</tr>
	<tr>
		<td class="right">Country :</td>
		<td>{{ $voucher->country_name }}</td>
		<td class="right">Nationality :</td>
		<td>{{ $voucher->market }}</td>
	</tr>
</table>
<hr>

<br>
<h3 style="text-align:center">Detail Hotel</h3>
<div style="margin:0 auto;">
<table align="center">
	<tr>
		<td class="td-left">Hotel Name</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->hotel_name }}</td>
	</tr>
	<tr>
		<td class="td-left">Type Room</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->room_name }}</td>
	</tr>
	<tr>
		<td class="td-left">Address</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->address }}</td>
	</tr>
	<tr>
		<td class="td-left">City</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->city_name }}</td>
	</tr>
	<tr>
		<td class="td-left">Check In Date</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->check_in_date }}</td>
	</tr>
	<tr>
		<td class="td-left">Check Out Date</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->check_out_date }}</td>
	</tr>
	<tr>
		<td class="td-left">Note</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->note }}</td>
	</tr>
	<tr>
		<td class="td-left">Rooms</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->room_num }}</td>
	</tr>
	<tr>
		<td class="td-left">Adults :</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->status_flag }}</td>
	</tr>
	<tr>
		<td class="td-left">Children :</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->status_flag }}</td>
	</tr>
	<tr>
		<td class="td-left">Breakfast :</td>
		<td class="small-gap">:</td>
		<td>{{ $voucher->status_flag }}</td>
	</tr>
</table>
</div>

<br>
<hr>
<table>
	<tr>
		<td>Cancellation Policy</td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>

</body>
</html>
