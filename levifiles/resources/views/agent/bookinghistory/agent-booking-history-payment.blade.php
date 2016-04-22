@extends('layouts.general-travel-layout')

@section('titleContainer')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Detail Order</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="#">Agent</a></li>
                <li><a href="{{ url('agent/booking-history') }}">My Booking</a></li>
                <li class="active">Detail Order</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" ng-controller="MainCtrl">
        <a href="{{ url('agent/booking-history') }}" class="button tiny secondary"><< Back</a><br>
        <div class="travelo-box col-md-9">
            <form method="post" action="{{ url('agent/booking-history/confirm-payment') }}" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h3>Payment Method For Order Number : {{ $order->order_no }}</h3>
                @include('layouts.message-helper')

                <div class="row-form-group">
                    <div class="form-group row">
                        <div class="col-sm-6 col-md-12">
                            <b>Total Payment : {{ $order->currency->curr_code }} {{ number_format($order->tot_payment, 0, ',', '.') }}</b>
                        </div>
                    </div>
                </div>

                <div class="card-information">
                    <div class="form-group">
                        <div class="radio col-sm-6 col-md-4">
                            <label><input type="radio" name="payment_method" ng-model="payment" value="Balance">Deposit</label>
                        </div>
                        <div class="radio col-sm-6 col-md-4">
                            <label><input type="radio" name="payment_method" ng-model="payment" value="Transfer">Transfer</label>
                        </div>
                        <div class="radio col-sm-6 col-md-4">
                            <label><input type="radio" name="payment_method" ng-model="payment" value="CreditCard">Credit Card</label>
                        </div>
                    </div>
                    <div style="clear:both;"></div>

                    <!-- balance -->
                    <div ng-show="payment == 'Balance'">
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-5">
                                <label>Deposit</label>
                                <input type="text" class="input-text full-width" name="balance_payment" value="{{ number_format($order->tot_payment, 0, ',', '.') }}" readonly />
                            </div>

                            <div class="col-sm-6 col-md-5">
                                <label>Remaning Deposit</label>
                                <input type="text" class="input-text full-width" value="{{ $deposit ? number_format($deposit->deposit_value - $deposit->used_value, 0, ',', '.') : 0 }}" readonly />
                            </div>
                        </div>
                    </div>

                    <!-- transfer -->
                    <!-- <div ng-show="payment == 'Transfer'">
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-5">
                                <label>Account Name</label>
                                <input type="text" class="input-text full-width" value="" placeholder="" />
                            </div>
                        </div>
                    </div> -->

                    <!-- for credit card -->
                    <div ng-show="payment == 'CreditCard'">
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-5">
                                <label>Credit Card Type</label>
                                <div class="selector">
                                    <input type="hidden" name="order_no" value="{{ $order->order_no }}" >
                                    <select class="full-width" name="card_type">
                                        <option>Visa</option>
                                        <option>Master</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <label>Card holder name</label>
                                <input type="text" class="input-text full-width" value="{{ old('card_name') }}" name="card_name" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-5">
                                <label>Card number</label>
                                <input type="text" class="input-text full-width" value="{{ old('card_number') }}" name="card_number" />
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <label>Card identification number</label>
                                <input type="text" class="input-text full-width" value="{{ old('ccv') }}" name="ccv" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-5">
                                <label>Expiration Date</label>
                                <div class="constant-column-2">
                                    <div class="selector">
                                        <select class="full-width">
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    <div class="selector">
                                        <select class="full-width">
                                            <option value="2016">2016</option>
                                            <option value="2016">2017</option>
                                            <option value="2016">2019</option>
                                            <option value="2016">2019</option>
                                            <option value="2016">2020</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-form-group">
                    <div class="form-group row">
                        <div class="col-sm-6 col-md-12">
                            <b><u>WARNING</u></b><br>
                            <b>Transfer</b> must be done in <b style="color:red">30 minutes</b> or it will be automaticly cancelled.<br>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-12">
                        <button type="submit" class="button small">Confirm Payment</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
    var app = angular.module("ui.hotelloca", []);
    app.controller("MainCtrl", function ($scope, $http, $filter) {

        $scope.payment = "{{ old('payment_method', 'Transfer') }}";

    });


</script>
@endsection
