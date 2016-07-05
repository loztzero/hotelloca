<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>New Booking</title>
</head>
<body>

<h3>Payment Settled for invoice number <b>{{ $invoiceNumber }}</b></h3>
Thank you for your payment.<br>
Click this link for your payment for this booking
<a href="{{ $bookingHistoryLink }}"><b>{{ $bookingHistoryLink }}</b></a>

</body>
</html>
