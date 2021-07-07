<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge" /> -->
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ABPON</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Order bulk industrial fasteners online. Browse over 35,000 unique screws, nuts, bolts, washers, rivets, military fasteners and more. Get same day shipping.">
    <!-- <meta name="author" content=""> -->

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">

    <!-- chat -->
    <script src="https://unpkg.com/vue"></script>
    <script src="https://unpkg.com/marked@0.3.6"></script>
    <script src="https://unpkg.com/lodash@4.16.0"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animated-headline.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{URL::asset('css/box2.css')}} ">
    <link rel="stylesheet" href="{{URL::asset('css/chatbtn.css')}} ">
    
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" media="screen" href="{{ asset('assets/tp-fastener/style/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" media="screen" href="{{ asset('assets/tp-fastener/style/css/style.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{asset('assets/tp-fastener/style/css/cart-n.css')}}">
    <!-- spinners -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login/css/spinners.css')}}">
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com"> -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

    <!-- dataTable -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.dataTables.css') }}">

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader d-flex align-items-center justify-content-center">
            <div class="loader__figure"></div>
            <div class="preloader-img pere-text">
                <img src="{{ asset('assets/img/logo/loder.png') }}" alt="">
            </div>  
        </div>
    </div>

    <div style="z-index:100;position:absolute"></div>
    <div class="navbar navbar-inverse" role="navigation">
    <section class="top_row">
            <div class="container nav-tp-j" style="align-items: center;"> 
                <span class="number"><a href="tel:8632515258">{{ $companyData['phone']['value'] }}</a></span>
                <ul class="admin_box d-flex justify-content-center float-righ">
                    @if(Auth::check())
                        <!-- <li class="login"><a href="{{ route('home') }}">{{ Auth::user()->name }}</a></li> -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="align-items: center;">{{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu text-left" style="margin-top: -3px;min-width: 167px;min-height: 77px;">
                                <li style="padding: 0 0 0 0px;">
                                    <a href="{{ route('home') }}" style="margin-right: 0;width: 165px">{{ __('index.header.purchase_order') }}</a>
                                </li><br>
                                <li style="padding: 0 0 0 0px;">
                                    <a href="{{ route('profile') }}" style="margin-right: 0;width: 165px">{{ __('index.header.account') }}</a>
                                </li><br>
                                <li style="padding: 0 0 0 0px;">
                                    <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-right: 0;width: 165px">
                                        <i class="fa fa-sign-out"></i><span class="hide-menu">{{ __('login.header.logout') }}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="login"><a href="{{ route('login') }}">{{ __('index.header.login') }} / {{ __('index.header.register') }}</a></li>
                    @endif
                    <li class="cart">
                        <div class="dropdown">
                                <span class='badge-n badge-warning-n' id='lblCartCount'>{{ $data['cart']->totalQuantity }}</span>
                                <a href="{{ route('cartIndex') }}" data-toggle="dropdown">{{ __('index.header.cart') }}</a>
                            
                            <div class="dropdown-menu-cart example"  style="background-color: #fff;border-radius: 1rem;padding: 20px;margin-right: -11rem;margin-left: 9rem;">
                                <div class="row total-header-section">
                                    <div class="col-lg-11 col-sm-11 col-11 total-section text-right">
                                        <p>{{ __('index.header.subtotal') }}: <span class="text-info">{{ number_format($data['cart']->totalPrice, 2) }}</span></p>
                                    </div>
                                </div> 
                                <div class="row cart-detail">
                                    @foreach($data['cart']->items as $item)
                                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img" style="padding: 0;">
                                            <img src="{{ asset('storage') }}/product_images/{{ $item['data']['prodCode'] }}/{{ $item['image'] }}">
                                        </div>
                                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product text-left">
                                            <p>{{ $item['data']['prodTName'] }}</p>
                                            <span class="price text-info"> ${{ number_format($item['totalSinglePrice'], 2) }}</span> <span class="count"> {{ __('index.header.quantity') }} : {{ $item['quantity'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <form action="{{ route('cartIndex') }}">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                            <button class="btn btn-danger-tp btn-block">Checkout</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="dropdown-menu-cart" style="box-shadow: none;background-color: #fff0;margin-left: 14rem;"></div>
                        </div>
                    </li>
                    <li class="email">
                        <a href="{{ route('Blog') }}">{{ __('index.header.blog') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('locale.setting', 'th') }}" @if(Session::get('locale')=='en') style="background: unset;padding-left: 1px;" @else style="background: unset;padding-left: 1px;text-decoration: underline;" @endif class="ml-5 mr-0">TH</a>
                    </li>
                    <li>
                        <a style="background: unset;padding-left: 1px;" class="mr-0">|</a>
                    </li>
                    <li>
                        <a href="{{ route('locale.setting', 'en') }}" @if(Session::get('locale')=='en') style="background: unset;padding-left: 1px;text-decoration: underline;" @else style="background: unset;padding-left: 1px;" @endif>EN</a>
                    </li>
                    <!-- <li class="email"><a href="#">Email</a></li> -->
                </ul>
            </div>
        </section>
        <section class="mid_row">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a href="{{ route('Index') }}" class="navbar-brand">
                        <img src="{{ asset('assets/tp-fastener/style/image/logo.png') }}" alt="Logo" />
                    </a>

                    <span class="head_image">
                        <img src="{{ asset('assets/tp-fastener/style/image/header_image.jpg') }}" alt="Header image" />
                    </span>

                    <form action="" method="get" class="search_form">
                        <fieldset>
                            <span class="input">
                                <input type="text" name='query' value="" placeholder="{{ __('index.header.search_product') }}">
                            </span>
                            <input type="button" value="{{ __('index.header.search') }}" style="position: relative;">
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
        <section class="nav_row">
            <div class="container">
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav" style="display: inline-block;">
                        @foreach($data['menugroup'] as $item)
                            <li><a href="{{ route('categoriesIndex', [ 'id' => $item->PMenuGroupCode, 'name' => $item->PMenuGroupName ]) }}">{{ $item->PMenuGroupName }}</a></li>
                        @endforeach
                        {{-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ __('index.header.other_categories') }}</a>
                            <ul class="dropdown-menu">
                                <li><a href="">Pins</a></li>
                                <li><a href="">Retaining Rings</a></li>
                                <li><a href="">Electronic Hard ware</a></li>
                                <li><a href="">Anchors</a></li>
                                <li><a href="">Tools</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <div class="system_message">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <p>{{ __('index.header.alert') }}</p>
                </div>
            </div>
        </div>
    </div>
