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
        <div class="travelo-box col-md-9">
            <form method="post" action="{{ url('agent/booking-history/voucher') }}" target="_blank">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h3>Detail Order</h3>
                @include('layouts.message-helper')

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Booking Number</label>
                        <input type="text" class="input-text full-width" name="order_no" value="{{ $order->order_no }}" readonly>
                    </div>

                    <div class="col-xs-6">
                        <label>Booking Date</label>
                        <input type="text" class="input-text full-width"  value="{{ $helpers::dateFormatterMysql($order->order_date) }}" readonly>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Guest</label>
                        <input type="text" class="input-text full-width"  value="{{ $order->quest }}" readonly>
                    </div>

                    <div class="col-xs-6">
                        <label>Nationality</label>
                        <input type="text" class="input-text full-width"  value="{{ $order->market }}" readonly>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Check In Date</label>
                            <input type="text" class="input-text full-width" value="{{ $helpers::dateFormatterMysql($order->check_in_date) }}" readonly />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Check Out Date</label>
                        <input type="text" name="date_to" class="input-text full-width" value="{{ $helpers::dateFormatterMysql($order->check_out_date) }}" readonly />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Country</label>
                        <input type="text" class="input-text full-width" value="{{ $order->country_name }}" readonly>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>City</label>
                        <input type="text" class="input-text full-width" value="{{ $order->city_name }}" readonly>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Status</label>
                        <input type="text" class="input-text full-width" value="{{ $order->status_flg }}" readonly>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-12">
                        <button type="submit" class="button small">Send Email</button>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-md-5">
                        <button type="submit" class="button small" name="voucher_agent">Print Voucher For Agent</button>
                        <button type="submit" class="button small" name="voucher_customer">Print Voucher For Customer</button>
                    </div>
                </div>

            </form>
        </div>

        <div class="sidebar col-md-3">
            <article class="detailed-logo">
                <figure>
                    <img width="114" height="85" src="http://placehold.it/114x85" alt="">
                </figure>
                <div class="booking-details">
                    <h2 class="box-title">{{ $order->hotel_name }}<small><i class="soap-icon-departure yellow-color"></i><span class="fourty-space">{{ $order->address }}</span></small></h2>

                    <div class="feedback">
                        <div data-placement="bottom" data-toggle="tooltip" class="five-stars-container" title="{{ $order->star }} stars">
                            @if($order->star == 2)
                                <span class="five-stars" style="width: 40%;"></span>
                            @elseif($order->star == 3)
                                <span class="five-stars" style="width: 60%;"></span>
                            @elseif($order->star == 4)
                                <span class="five-stars" style="width: 80%;"></span>
                            @elseif($order->star == 5)
                                <span class="five-stars" style="width: 100%;"></span>
                            @else
                                <span class="five-stars" style="width: 20%;"></span>
                            @endif
                        </div>
                        <span class="review pull-right">{{ $order->star }} Stars</span>
                    </div>

                    <br>
                    <b>Other Details</b>
                    <dl class="other-details">
                        <dt>Room</dt><dd>{{ $order->room }}</dd>
                        <dt>Adult</dt><dd>{{ $order->num_adults }}</dd>
                        <dt>Child</dt><dd>{{ $order->num_child }} </dd>
                        <dt>{{ $order->num_breakfast > 0 ? 'Breakfast' : 'Room Only' }}</dt><dd>{{ $order->num_breakfast > 0 ? $order->num_breakfast : '' }} </dd>
                    </dl>
                    <p class="description">{{ $order->description }}</p>
                </div>

            </article>

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
