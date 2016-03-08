@extends('layouts.general-travel-layout')

@section('titleContainer')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Booking List</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="#">Agent</a></li>
                <li class="active">Booking</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" ng-controller="MainCtrl">

        <a href="{{ url('admin/hotel') }}" class="button tiny secondary"><< Back</a><br>
        <div class="travelo-box col-xs-12">
            <form action="{{url('/admin/hotel/save')}}" method="post" >

                <h3>My Booking</h3>
                @include('layouts.message-helper')

                <div class="row form-group">
                    <div class="col-xs-12">
                        <label>Booking Number</label>
                        <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name" required>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Check In Date</label>
                        <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name" required>
                    </div>

                    <div class="col-xs-6">
                        <label>Check Out Date</label>
                        <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name" required>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Country</label>
                        <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name" required>
                    </div>

                    <div class="col-xs-6">
                        <label>City</label>
                        <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name" required>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <label>Status Pesanan</label>
                        <input type="text" class="input-text full-width"  value="{{ old('hotel_name')}}" id="hotelName" name="hotel_name" required>
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
                <thead>
                    <tr>
                        <th>No Booking</th>
                        <th class="hide-for-small">Check In</th>
                        <th class="hide-for-small">Check Out</th>
                        <th>Tamu</th>
                        <th class="hide-for-small">Tanggal Pembayaran</th>
                        <th class="hide-for-small">Status</th>
                        <th class="hide-for-small">Total Pembayaran</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(array() as $hotel)
                    <tr>
                        <td>
                            <form action="{{URL::to('admin/hotel/load-data')}}" method="post" class="pull-left">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                <input type="hidden" value="{{ $hotel->id }}" name="id">
                                <button type="submit" class="btn-primary" title="Edit Hotel"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                            </form>
                            @if($hotel->active_flg == 'Inactive')
                                <form action="{{URL::to('admin/hotel/activate-hotel')}}" method="post" class="pull-right">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                    <input type="hidden" value="{{$hotel->id}}" name="id">
                                    <button class="btn-primary" title="Activate the hotel"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></button>
                                </form>
                            @elseif($hotel->active_flg == 'Active')
                                <form action="{{URL::to('admin/hotel/deactivate-hotel')}}" method="post" class="pull-right">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                    <input type="hidden" value="{{$hotel->id}}" name="id">
                                    <button class="btn-warning" title="Deadactivated the hotel"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button>
                                </form>
                            @endif
                        </td>
                        <td>{{ $hotel->hotel_name }}</td>
                        <td class="hide-for-small">{{ $hotel->country->country_name }}</td>
                        <td class="hide-for-small">{{ $hotel->city->city_name }}</td>
                        <td class="hide-for-small">{{ $hotel->address }}</td>
                        <td class="hide-for-small">{{ $hotel->phone_number }}</td>
                        <td>
                            {{ $hotel->active_flg }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" id="pagination">
                            {{-- $hotelList->appends(Request::only('hotel_name', 'country', 'city'))->render() --}}
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
