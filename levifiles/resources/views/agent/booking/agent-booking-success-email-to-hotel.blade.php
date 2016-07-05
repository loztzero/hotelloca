<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>New Booking</title>
</head>
<body>

<h3>{{ $title }} {{ $firstName }} {{ $lastName }} hotel booking information</h3>
<table cellspacing="0" cellpadding="2" border="0" width="500">
	<tr>
		<td width="150"><b>Booking Number</b></th>
		<td width="350">{{ $orderNumber }}</th>
	</tr>
	<tr>
		<td width="150"><b>Title</b></th>
		<td width="350">{{ $title }}</th>
	</tr>
	<tr>
		<td width="150"><b>First Name</b></th>
		<td width="350">{{ $firstName }}</th>
	</tr>
	<tr>
		<td width="150"><b>Last Name</b></th>
		<td width="350">{{ $lastName }}</th>
	</tr>
	<tr>
		<td width="150"><b>Hotel</b></th>
		<td width="350">{{ $hotelName }}</th>
	</tr>
	<tr>
		<td width="150"><b>Room Name</b></th>
		<td width="350">{{ $roomName }}</th>
	</tr>
	<tr>
		<td width="150"><b>Room Numbers</b></th>
		<td width="350">{{ $roomNums }}</th>
	</tr>
	<tr>
		<td width="150"><b>Check In Date</b></th>
		<td width="350">{{ $checkInDate }}</th>
	</tr>
	<tr>
		<td width="150"><b>Check Out Date</b></th>
		<td width="350">{{ $checkOutDate }}</th>
	</tr>
	<tr>
		<td width="150"><b>Nights</b></th>
		<td width="350">{{ $nights }}</th>
	</tr>
	<tr>
		<td width="150"><b>Adults</b></th>
		<td width="350">{{ $numAdults }} Person</th>
	</tr>
	<tr>
		<td width="150"><b>Childs</b></th>
		<td width="350">{{ $numChilds }} Person</th>
	</tr>
	<tr>
		<td width="150"><b>Breakfast Number</b></th>
		<td width="350">{{ $numBreakfast }}</th>
	</tr>
	<tr>
		<td width="150"><b>Non Smoking</b></th>
		<td width="350">{{ $nonSmokingFlag }}</th>
	</tr>
	<tr>
		<td width="150"><b>Interconnection Room</b></th>
		<td width="350">{{ $interConnectionFlag }}</th>
	</tr>
	<tr>
		<td width="150"><b>Early Check In</b></th>
		<td width="350">{{ $earlyCheckInFlag }}</th>
	</tr>
	<tr>
		<td width="150"><b>Late Check In</b></th>
		<td width="350">{{ $lateCheckInFlag }}</th>
	</tr>
	<tr>
		<td width="150"><b>High Floor</b></th>
		<td width="350">{{ $highFloorFlag }}</th>
	</tr>
	<tr>
		<td width="150"><b>Low Floor</b></th>
		<td width="350">{{ $lowFloorFlag }}</th>
	</tr>
	<tr>
		<td width="150"><b>Twin Bed</b></th>
		<td width="350">{{ $twinFlag }}</th>
	</tr>
	<tr>
		<td width="150"><b>Honeymoon</b></th>
		<td width="350">{{ $honeymoonFlag }}</th>
	</tr>
</table>

</body>
</html>
