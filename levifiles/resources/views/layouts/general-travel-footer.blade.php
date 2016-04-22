<footer id="footer">
    <div class="footer-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <h2>Discover</h2>
                    <ul class="discover triangle hover row">
                        <li class="col-xs-12"><a href="{{ url('register/agent') }}">Become our partner</a></li>
                        <li class="col-xs-12"><a href="{{ url('register/hotel') }}">Register your hotel</a></li>
                        <li class="col-xs-12"><a href="{{ url('/main/company-profile') }}">Company Profile</a></li>
                        <li class="col-xs-12"><a href="{{ url('/main/services') }}">Service</a></li>
                        <li class="col-xs-12"><a href="{{ url('/main/term-and-condition') }}">Term And Condition</a></li>
                        <li class="col-xs-12"><a href="{{ url('/main/contact-us') }}">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h2>Travel News</h2>
                    <ul class="travel-news">
                        <li>
                            <div class="thumb">
                                <a href="#">
                                    <img src="{{ url('assets/images/main-63/telephone.jpg') }}" alt="" width="63" height="63" />
                                </a>
                            </div>
                            <div class="description">
                                <h5 class="s-title"><a href="#">Amazing Places</a></h5>
                                <p>London - Amsterdam - Paris - Milan - Dubai - Maldives - Bali</p>
                                <span class="date">{{ date('Y') }}</span>
                            </div>
                        </li>
                        <li>
                            <div class="thumb">
                                <a href="#">
                                    <img src="{{ url('assets/images/main-63/peace-of-mind.jpg') }}" alt="" width="63" height="63" />
                                </a>
                            </div>
                            <div class="description">
                                <h5 class="s-title"><a href="#">Travel Insurance</a></h5>
                                <p>A Powerful earthquake rocks the southern Japanese city of Kumamoto in the middle of the night</p>
                                <span class="date">{{ date('Y') }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h2>Mailing List</h2>
                    <p>Sign up for our mailing list to get latest updates and offers.</p>
                    <br />
                    <div class="icon-check">
                        <input type="text" class="input-text full-width" placeholder="your email" />
                    </div>
                    <br />
                    <span>We respect your privacy</span>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h2>About Hotelloca</h2>
                    <p>We are providing the best hotel rate for retailer agents in indonesia.</p>
                    <br />
                    <address class="contact-details">
                        <span class="contact-phone"><i class="soap-icon-phone"></i> +62-8HOTEL-LOCA</span>
                        <br />
                        <a href="#" class="contact-email">help@hotelloca.com</a>
                    </address>
                    <ul class="social-icons clearfix">
                        <li class="twitter"><a title="twitter" href="#" data-toggle="tooltip"><i class="soap-icon-twitter"></i></a></li>
                        <li class="googleplus"><a title="googleplus" href="#" data-toggle="tooltip"><i class="soap-icon-googleplus"></i></a></li>
                        <li class="facebook"><a title="facebook" href="#" data-toggle="tooltip"><i class="soap-icon-facebook"></i></a></li>
                        <li class="linkedin"><a title="linkedin" href="#" data-toggle="tooltip"><i class="soap-icon-linkedin"></i></a></li>
                        <li class="vimeo"><a title="vimeo" href="#" data-toggle="tooltip"><i class="soap-icon-vimeo"></i></a></li>
                        <li class="dribble"><a title="dribble" href="#" data-toggle="tooltip"><i class="soap-icon-dribble"></i></a></li>
                        <li class="flickr"><a title="flickr" href="#" data-toggle="tooltip"><i class="soap-icon-flickr"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom gray-area">
        <div class="container">
            <div class="logo pull-left">
                <a href="index.html" title="Travelo - home">
                    <img src="{{ url('/') }}/assets/images/logo.png" alt="Travelo HTML5 Template" />
                </a>
            </div>
            <div class="pull-right">
                <a id="back-to-top" href="#" class="animated" data-animation-type="bounce"><i class="soap-icon-longarrow-up circle"></i></a>
            </div>
            <div class="copyright pull-right">
                <p>&copy; {{ date('Y') }} Hotelloca</p>
            </div>
        </div>
    </div>
</footer>
