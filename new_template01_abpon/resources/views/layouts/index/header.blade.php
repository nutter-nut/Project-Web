<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset = "UTF-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ABPON</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- chat -->
    <script src="https://unpkg.com/vue"></script>
    <script src="https://unpkg.com/marked@0.3.6"></script>
    <script src="https://unpkg.com/lodash@4.16.0"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/progressbar_barfiller.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightslider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/price_rangs.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animated-headline.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- chat -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="{{URL::asset('css/box2.css')}} ">
  	<link rel="stylesheet" href="{{URL::asset('css/chatbtn.css')}} ">
<!-- 
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('css/slick.css')}}"/>
	<link type="text/css" rel="stylesheet" href="{{asset('css/slick-theme.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('css/nouislider.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('css/main_style.css')}}"/>	 -->
    <!-- chat -->

    <!-- zoom product image -->
    <link rel="stylesheet" href="{{URL::asset('css/zoom.css')}} ">
    <script src="{{ asset('js/zoom-product-image.js') }}"></script>
    <!-- zoom product image -->
</head>

<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset('assets/img/logo/loder.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start-->
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="row menu-wrapper align-items-center justify-content-between">
                        <div class="header-left d-flex align-items-center">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="/"><img src="{{ asset('assets/img/logo/logo.png') }}" alt=""></a>
                            </div>
                            <!-- Logo-2 -->
                            <div class="logo2">
                                <a href="/"><img src="{{ asset('assets/img/logo/logo-footer.png') }}" alt=""></a>
                            </div>
                            <!-- Main-menu -->
                            <div class="main-menu d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="/" style="{{ Request::url() == route('Index') ? 'color:crimson' : '' }}"><i class="fa fa-home"></i> {{ __('index.header.home') }}</a></li>
                                        <li><a href="#" style="">{{ __('index.header.categrie') }}</a></li>
                                        <li><a href="{{ route('About') }}" style="{{ Request::url() == route('About') ? 'color:crimson' : '' }}">{{ __('index.header.about') }}</a></li>
                                        <li><a href="{{ route('Blog') }}" style="{{ Request::url() == route('Blog') || Request::url() == route('blogDetails',['id' => $blog['id'] ?? 0 ]) ? 'color:crimson' : '' }}">{{ __('index.header.blog') }}</a></li>
                                        <li><a href="{{ route('Contact') }}" style="{{ Request::url() == route('Contact') ? 'color:crimson' : '' }}">{{ __('index.header.contact') }}</a></li>
                                        @if(Session::get('locale')=='en')
                                        <li><a href="{{ route('locale.setting', 'th') }}">TH</a></li>
                                        @else
                                        <li><a href="{{ route('locale.setting', 'en') }}">EN</a></li>
                                        @endif                      
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="header-right1 d-flex align-items-center">               
                            <ul class="d-flex align-items-center" id="navigation">
                                <li>
                                    <!-- Search Box -->
                                    <form action="{{ route('searchProduct') }}" class="form-box f-right" style="right: 80px;">
                                        <input type="text" name="search_text" placeholder="{{ __('index.header.search_product') }}" value="{{ $search_text ?? '' }}">
                                        <div class="search-icon">
                                            <button class="btn text-success" style="padding: 10px;">
                                                <i class="fa fa-search" aria-hidden="true" style="color: #fff;"></i>
                                            </button>
                                        </div>
                                    </form>
                                </li>
                                <li>
                                    <div class="form-box f-right" style="right: 50px;">
                                        @if(Auth::check())
                                        <a href="/home" class="account-btn" target="_self">{{Auth::user()->name}}</a>
                                        @else
                                        <a href="/login" class="account-btn" target="_self">{{ __('index.header.login') }}</a>
                                        @endif
                                    </div>
                                </li>
                                <li>
                                    <div class="form-box f-right">
                                        <div class="search-icon">
                                            <div class="card-stor">
                                                <a href="" style="padding: 0px 0px;">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    <span>0</span>  
                                                </a>           
                                            </div>  
                                        </div>  
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <!-- header end -->
