<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Voucher</title>

<style>
.full-width {width: 100%;}
.right {text-align: right;}
.left {text-align: left;}
.small-gap {width: 5px;vertical-align: top;}
.td-left {width: 120px;vertical-align: top;}
</style>
</head>
<body>

<table class="full-width">
    <tr>
        <td><img src="{{ url() . '/assets/images/logo.png' }}"</td>
        <td style="vertical-align:bottom;text-align:right">Invoice</td>
    </tr>
</table>

<hr>
<br>
<h3 style="text-align:center">Detail Payment</h3>
<div style="margin:0 auto;">
<table width="100%">
    <tr>
        <td class="td-left">Hotel Name</td>
        <td class="small-gap">:</td>
        <td colspan="4">{{ $invoice->hotel_name }}</td>
    </tr>
    <tr>
        <td class="td-left">Nationality</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->market }}</td>
    </tr>
    <tr>
        <td class="td-left">Booking Number</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->order_no }}</td>
        <td class="td-left">Booking Date</td>
        <td class="small-gap">:</td>
        <td>{{ date('d-m-Y', strtotime($invoice->order_date)) }}</td>
    </tr>
    <tr>
        <td class="td-left">Payment Date</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->payment_date }}</td>
        <td class="td-left">Adults</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->num_adults }}</td>
    </tr>
    <tr>
        <td class="td-left">Agent</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->num_adults }}</td>
        <td class="td-left">Childs</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->num_child }}</td>
    </tr>
    <tr>
        <td class="td-left">Guest Name</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->guest }}</td>
        <td class="td-left">Breakfast</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->num_breakfast }}</td>
    </tr>
    <tr>
        <td class="td-left">Room Name</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->room_name }}</td>
        <td class="td-left">Total Room</td>
        <td class="small-gap">:</td>
        <td>{{ $invoice->room_num }}</td>
    </tr>
</table>
</div>

<br>
<?php $totalPayment = 0 ;?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="left">Date</th>
            <th class="right">Price</th>
            <th class="right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($details as $detail)
        <tr>
            <td>{{ $detail->check_in_date }}</td>
            <td class="right">{{ number_format($detail->daily_price, 0, ',', '.') }}</td>
            <td class="right">{{ number_format($detail->total, 0, ',', '.') }}</td>
        </tr>
        <?php $totalPayment += $detail->total; ?>
        @endforeach
    </tbody>
</table>

<b>Total Payment : </b>{{ number_format($totalPayment, 0, ',', '.') }}

</body>
</html>
