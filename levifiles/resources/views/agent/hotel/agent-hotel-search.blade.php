@extends('layouts.general-travel-layout')

@section('titleContainer')
<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">Hotel Search Results</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="#">Agent</a></li>
            <li>Hotel</li>
            <li class="active">Hotel Search Results</li>
        </ul>
    </div>
</div>
@endsection


@section('content')

<div class="container" ng-controller="MainCtrl">
    <div id="main">
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <h4 class="search-results-title"><i class="soap-icon-search"></i><b>{{ count($hotels) }}</b> results found.</h4>
                <div class="toggle-container filters-container">
                    <div class="panel style1 arrow-right">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#price-filter" class="collapsed">Price</a>
                        </h4>
                        <div id="price-filter" class="panel-collapse collapse">
                            <div class="panel-content">
                                <div id="price-range"></div>
                                <br />
                                <span class="min-price-label pull-left"></span>
                                <span class="max-price-label pull-right"></span>
                                <div class="clearer"></div>
                            </div><!-- end content -->
                        </div>
                    </div>
                    
                    <div class="panel style1 arrow-right">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#rating-filter" class="collapsed">User Rating</a>
                        </h4>
                        <div id="rating-filter" class="panel-collapse collapse filters-container">
                            <div class="panel-content">
                                <div id="rating" class="five-stars-container editable-rating"></div>
                                <br />
                                <small>2458 REVIEWS</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="panel style1 arrow-right">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#modify-search-panel" class="collapsed">Modify Search</a>
                        </h4>
                        <div id="modify-search-panel" class="panel-collapse collapse">
                            <div class="panel-content">
                                <form method="get" action="{{ url('agent/hotel/search') }}">
                                    <div class="form-group">
                                        <label>nationality</label>
                                        <div class="selector">
                                            {!! Form::select('nationality', $countries2,Request::input('nationality', 'Indonesia'), array('required', 'class' => 'full-width')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>country</label>
                                        <div class="selector">
                                            {!! Form::select('country', $countries, null, array('ng-model' => 'field.country', 'ng-change' => 'getCity()', 'required', 'class' => 'full-width')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>city</label>
                                        <div class="selector" id="citySelector">
                                        <select ng-model="field.city" name="city" required id="city">
                                            <option value="">Select A City</option>
                                            <option ng-repeat="city in cities" value="@{{city.id}}" ng-selected="field.city == city.id">@{{city.city_name}}</option>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label>hotel name</label>
                                        <input type="text" class="input-text full-width" placeholder="" value="{{ Request::input('hotel_name') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label>check in</label>
                                        <div class="datepicker-wrap">
                                            <input type="text" name="date_from" class="input-text full-width" placeholder="dd-mm-yy" value="{{ Request::input('date_from') }}" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>check out</label>
                                        <div class="datepicker-wrap">
                                            <input type="text" name="date_to" class="input-text full-width" placeholder="dd-mm-yy" value="{{ Request::input('date_to') }}" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>room</label>
                                        <div class="selector">
                                            {!! Form::select('room', array('1' => '01', '2' => '02', '3' => '03', '4' => '04'), Request::input('room'), array('class' => 'full-width')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>adults</label>
                                        {!! Form::select('adults', array('1' => '01', '2' => '02', '3' => '03', '4' => '04'), Request::input('adults'), array('class' => 'full-width')) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>childs</label>
                                        {!! Form::select('child', array('0' => '00', '1' => '01', '2' => '02', '3' => '03', '4' => '04'), Request::input('child'), array('class' => 'full-width')) !!}
                                    </div>
                                    <br />
                                    <button class="btn-medium icon-check uppercase full-width">search again</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-md-9">
                <div class="sort-by-section clearfix">
                    <h4 class="sort-by-title block-sm">Sort results by:</h4>
                    <ul class="sort-bar clearfix block-sm">
                        <li class="sort-by-name"><a class="sort-by-container" href="#"><span>name</span></a></li>
                        <li class="sort-by-price"><a class="sort-by-container" href="#"><span>price</span></a></li>
                        <li class="clearer visible-sms"></li>
                        <li class="sort-by-rating active"><a class="sort-by-container" href="#"><span>rating</span></a></li>
                        <li class="sort-by-popularity"><a class="sort-by-container" href="#"><span>popularity</span></a></li>
                    </ul>
                    
                </div>
                <div class="hotel-list listing-style3 hotel">
                    @foreach($hotels as $hotel)
                        <article class="box">
                            <figure class="col-sm-5 col-md-4">
                                <a title="" href="ajax/slideshow-popup.html" class="hover-effect popup-gallery"><img width="270" height="160" alt="" src="{{ url('uploads/hotels/'.$hotel->id.'/'.$hotel->pict.'.jpg') }}" width="100%"></a>
                            </figure>
                            <div class="details col-sm-7 col-md-8">
                                <div>
                                    <div>
                                        <h4 class="box-title">{{ $hotel->hotel_name }}<small><i class="soap-icon-departure yellow-color"></i>{{ $hotel->address }}</small></h4>
                                    </div>
                                    <div>
                                        <div class="five-stars-container">
                                            @if($hotel->star == 2)
                                                <span class="five-stars" style="width: 40%;"></span>
                                            @elseif($hotel->star == 3)
                                                <span class="five-stars" style="width: 60%;"></span>
                                            @elseif($hotel->star == 4)
                                                <span class="five-stars" style="width: 80%;"></span>
                                            @elseif($hotel->star == 5)
                                                <span class="five-stars" style="width: 100%;"></span>
                                            @else
                                                <span class="five-stars" style="width: 20%;"></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p>
                                        {{ $hotel->description }}
                                    </p>
                                    <div>
                                        <span class="price"><small>RATE / Night / Rp</small>{{ number_format($hotel->nett_value, 0, ',', '.') }}</span>
                                        <a class="button btn-small full-width text-center" title="" href="{{ url('agent/hotel/hotel-detail?hotel='.$hotel->id.'&checkIn='.$request->date_from.'&checkOut='.$request->date_to.'&room='.$request->room.'&adults='.$request->adults.'&child='.$request->child) }}">SELECT</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    @if(count($hotels) == 0)
                        Data Hotels not found, please try again with another filter.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
var app = angular.module("ui.hotelloca", ['ngSanitize']);
app.controller("MainCtrl", function ($scope, $http, $filter) {

    $scope.field = {};
    $scope.field.country = '{{ Request::input("country") }}';
    $scope.cities = [];
    $scope.getCity = function(){
        $http.post('{{ url("agent/hotel/city-from-country") }}', $scope.field).success(function(response){
            $scope.cities = response;
            $scope.field.city = '';
            tjq('#citySelector span').html('Select A City');
            // console.log(response);
        })
    }

    $scope.getCity();

});
</script>
@endsection