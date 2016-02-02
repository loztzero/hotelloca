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
                <h4 class="search-results-title"><i class="soap-icon-search"></i><b>1,984</b> results found.</h4>
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
                                <form method="post">
                                    <div class="form-group">
                                        <label>destination</label>
                                        <input type="text" class="input-text full-width" placeholder="" value="Paris" />
                                    </div>
                                    <div class="form-group">
                                        <label>check in</label>
                                        <div class="datepicker-wrap">
                                            <input type="text" name="date_from" class="input-text full-width" placeholder="mm/dd/yy" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>check out</label>
                                        <div class="datepicker-wrap">
                                            <input type="text" name="date_to" class="input-text full-width" placeholder="mm/dd/yy" />
                                        </div>
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
                    
                    <ul class="swap-tiles clearfix block-sm">
                        <li class="swap-list active">
                            <a href="hotel-list-view.html"><i class="soap-icon-list"></i></a>
                        </li>
                        <li class="swap-grid">
                            <a href="hotel-grid-view.html"><i class="soap-icon-grid"></i></a>
                        </li>
                        <li class="swap-block">
                            <a href="hotel-block-view.html"><i class="soap-icon-block"></i></a>
                        </li>
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
                                            <span class="five-stars" style="width: 80%;"></span>
                                        </div>
                                        <span class="review">270 reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id, consectetur adipi deese cing elit maus fringilla bibe endum.</p>
                                    <div>
                                        <span class="price"><small>RATE/NIGHT</small>Rp. {{ number_format($hotel->nett_value, 0, ',', '.') }}</span>
                                        <a class="button btn-small full-width text-center" title="" href="hotel-detailed.html">SELECT</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    @if(count($hotels) == 0)
                        Data Hotels not found, please try again with another filter.
                    @endif
                </div>
                <a href="#" class="uppercase full-width button btn-large">load more listing</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
var app = angular.module("ui.hotelloca", ['ngSanitize']);
app.controller("MainCtrl", function ($scope, $http, $filter) {

	$scope.cities = {};
	$scope.loading = false;
	// $scope.cities.test = 'zz';
	// console.log($scope.cities);
	$scope.getCity = function(){
		$scope.loading = true;
		$http.get("{{ url('/hotel/cities')}}/" + $scope.field.country).success(function(response) {

			// try {
		 //        JSON.parse(response);
		 //        var value = response.replace(/['"]+/g, '');
		 //        $scope.cities = {value};
		 //    } catch (e) {
		 //    	console.log(e);
		        $scope.cities = response;
		 //    }

			 $scope.cities = response;
			 $scope.field.city = '';
			 $scope.loading = false;

		})
	};

});
</script>
@endsection