<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 4 admin, bootstrap 4, css3 dashboard, bootstrap 4 dashboard, AdminWrap lite admin bootstrap 4 dashboard, frontend, responsive bootstrap 4 admin template, AdminWrap lite design, AdminWrap lite dashboard bootstrap 4 dashboard template">
    <meta name="description"
        content="AdminWrap Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ABPON</title>

    <!-- chat -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">

    <link rel="canonical" href="https://www.wrappixel.com/templates/adminwrap-lite/" />
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/login/node_modules/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/login/node_modules/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <link href="{{ asset('assets/login/node_modules/morrisjs/morris.css') }}" rel="stylesheet">
    <!--c3 CSS -->
    <link href="{{ asset('assets/login/node_modules/c3-master/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <!-- <link href="{{ asset('assets/login/css/style.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('assets/login/css/style_login.css') }}" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{ asset('assets/login/css/pages/dashboard1.css') }}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <!-- <link href="{{ asset('assets/login/css/colors/default.css') }}" id="theme" rel="stylesheet"> -->
    <link href="{{ asset('assets/login/css/colors/default_login.css') }}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <scrip src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></scrip>
    <scrip src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></scrip>
<![endif]-->
    <!-- <scrip src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></scrip> -->

    <!-- chat -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="{{URL::asset('css/box2.css')}} ">
  	<link rel="stylesheet" href="{{URL::asset('css/chatbtn.css')}} ">

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> -->
    <!-- <scrip src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></scrip> -->
    <!-- <scrip src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></scrip>
    <scrip src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></scrip> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!-- Datatable -->
    <!-- <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js" defer></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.dataTables.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.dataTables.css') }}">


    <!-- <scrip src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></scrip> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body ,h1, h2, h3, h4, h5, h6 {
            font-family: 'Bai Jamjuree', sans-serif;
            font-family: 'Kanit', sans-serif;
        }
    </style>

</head>

<body class="fix-header fix-sidebar card-no-border">
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
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('Index') }}">
                        <!-- <img src="{{ asset('assets/login/images/logo.png') }}" alt="homepage" class="dark-logo" /> -->
                        <img src="{{ asset('assets/img/logo/thailand-business-pages.png') }}" alt="homepage" class="dark-logo img-fluid" style="width:230px;padding-inline: 20px;" />
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- style="background-color: #67038F;" -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)">
                            <!-- style="color: aliceblue;" -->
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        @if($userData->isAdmin())
                        <li class="nav-item hidden-xs-down search-box">
                            <a class="nav-link hidden-sm-down waves-effect waves-dark" href="javascript:void(0)">
                                <i class="fa fa-search"></i> {{ $text ?? '' }}
                            </a>
                            <!-- {{ route('searchAll') }} -->
                            <form action="#" method="GET" class="app-search">
                                <input name="search" type="text" class="form-control" placeholder="{{ __('login.index.search') }}" value="{{ $text ?? '' }}">
                                <a class="srh-btn">
                                    <i class="fa fa-times"></i>
                                </a>
                            </form>
                        </li>
                        @endif
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro" style="background-color: white;">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('storage') }}/user_images/{{ Auth::user()->image }}" alt="user" class="" style="height:30px;" />
                                <span class="hidden-md-down">{{ Auth::user()->name }} &nbsp;</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar leftCol-scroll">

            <div class="scroll-sidebar navbar-light">
                <nav class="sidebar-nav navbar-light">
                    <ul id="sidebarnav">
                    <?php $routeName =  \Illuminate\Support\Facades\Route::getFacadeRoot()->current()->getName() ?>
                    @if($userData->isEmployee() || $userData->isAdmin())
                        <li data-toggle="collapse" data-target="#products" class="" onclick="iconUpDown('product', 
                            {{  in_array($routeName, [
                                'productCreate',
                                'adminProductGroup',
                                'adminProductType',
                                'adminProductBrand',
                                'adminProductModel',
                                'adminProduct',
                                'adminProductUnitofmeasurepos',
                                'adminProductMenuGroup'
                            ]) ? 'true' : 'false' }}
                        );"> 
                            <a class="waves-effect waves-dark" aria-expanded="false">
                                <i class="fa fa-product-hunt"></i>
                                <span class="hide-menu">{{ __('login.header.set_products') }}</span>
                                <i id="icon_updown_product" class="pull-right text-right {{ in_array(Request::url(), [ Request::is('admin/product/unitofmeasurepos/edit/*'),Request::is('admin/product/image/*'),Request::is('admin/product/edit/*'),Request::is('admin/product/model/edit/*'),Request::is('admin/product/brand/edit/*'),Request::is('admin/product/type/edit/*'),Request::is('admin/product/group/edit/*'),Request::is('admin/product/menu/group/edit/*')]) || in_array($routeName, [ 'productCreate','adminProductGroup','adminProductType','adminProductBrand','adminProductModel','adminProduct','adminProductUnitofmeasurepos','adminProductMenuGroup']) ? 'fa fa-angle-up' : 'fa fa-angle-down' }}"></i>
                            </a>
                        </li>
                        <ul class="sub-menu collapse {{ in_array(Request::url(), [
                                Request::is('admin/product/unitofmeasurepos/edit/*'), 
                                Request::is('admin/product/image/*'), 
                                Request::is('admin/product/edit/*'), 
                                Request::is('admin/product/model/edit/*'), 
                                Request::is('admin/product/brand/edit/*'), 
                                Request::is('admin/product/type/edit/*'), 
                                Request::is('admin/product/group/edit/*'),
                                Request::is('admin/product/menu/group/edit/*')
                            ]) || in_array($routeName, [
                                'productCreate',
                                'adminProductGroup',
                                'adminProductType',
                                'adminProductBrand',
                                'adminProductModel',
                                'adminProduct',
                                'adminProductUnitofmeasurepos',
                                'adminProductMenuGroup'
                            ]) ? 'show' : '' }}"
                            id="products"
                            >
                            <li class="pl-3"><a href="{{ route('adminProductGroup') }}" class="{{ Request::url() == Request::is('admin/product/group/*') ? 'active' : '' }}"><i class="fa fa-cube"></i><span class="hide-menu"> {{ __('login.header.product_group') }}</span></a></li>
                            <li class="pl-3"><a href="{{ route('adminProductType') }}" class="{{ Request::url() == Request::is('admin/product/type/*') ? 'active' : '' }}"><i class="fa fa-cubes"></i><span class="hide-menu"> {{ __('login.header.product_type') }}</span></a></li>
                            <li class="pl-3"><a href="{{ route('adminProductBrand') }}" class="{{ Request::url() == Request::is('admin/product/brand/*') ? 'active' : '' }}"><i class="fa fa-th"></i><span class="hide-menu"> {{ __('login.header.brand') }}</span></a></li>
                            <li class="pl-3"><a href="{{ route('adminProductModel') }}" class="{{ Request::url() == Request::is('admin/product/model/*') ? 'active' : '' }}"><i class="fa fa-th-list"></i><span class="hide-menu"> {{ __('login.header.product_model') }}</span></a></li>
                            <li class="pl-3"><a href="{{ route('adminProduct') }}" class="{{ $routeName == 'productCreate' || in_array(Request::url(), [Request::is('admin/product/image/*'), Request::is('admin/product/edit/*')]) ? 'active' : '' }}"><i class="fa fa-shopping-bag"></i><span class="hide-menu"> {{ __('login.header.product_p') }}</span></a></li>
                            <li class="pl-3"><a href="{{ route('adminProductUnitofmeasurepos') }}" class="{{ Request::url() == Request::is('admin/product/unitofmeasurepos/*') ? 'active' : '' }}"><i class="fa fa-filter"></i><span class="hide-menu"> {{ __('login.header.unit_count') }}</span></a></li>
                            <li class="pl-3"><a href="{{ route('adminProductMenuGroup') }}" class="{{ Request::url() == Request::is('admin/product/menu/group/*') ? 'active' : '' }}"><i class="fas fa-eye"></i><span class="hide-menu"> กลุ่มเมนูขาย</span></a></li>
                        </ul>
                        <li data-toggle="collapse" data-target="#treasury" onclick="iconUpDown('treasury',
                                {{ in_array(Request::url(), [
                                    Request::is('admin/treasury'), 
                                    Request::is('admin/stock')
                                ]) ? 'true' : 'false' }}
                        );"> 
                            <a class="waves-effect waves-dark" aria-expanded="false">
                                <i class="fa fa-database"></i>
                                <span class="hide-menu">{{ __('login.header.warehouse_and_purchasing') }}</span>
                                <i id="icon_updown_treasury" class="pull-right text-right {{ in_array(Request::url(), [ Request::is('admin/treasury/edit/*'),Request::is('admin/treasury'),Request::is('admin/stock/edit/*'),Request::is('admin/stock') ]) ? 'fa fa-angle-up' : 'fa fa-angle-down' }}"></i>
                            </a>
                        </li>
                        <ul class="sub-menu collapse {{ in_array(Request::url(), [
                                Request::is('admin/treasury/edit/*'), 
                                Request::is('admin/stock/edit/*')
                            ]) ? 'show' : '' }}"
                            id="treasury"
                        >
                            <li class="pl-3"><a href="{{ route('adminTreasury') }}" class="{{ Request::url() == Request::is('admin/treasury/edit/*') ? 'active' : '' }}"><i class="fa fa-stop"></i><span class="hide-menu"> {{ __('login.header.build_warehouse') }}</span></a></li>
                            <li class="pl-3"><a href="{{ route('adminStock') }}" class="{{ Request::url() == Request::is('admin/stock/edit/*') ? 'active' : '' }}"><i class="fa fa-download"></i><span class="hide-menu"> {{ __('login.header.stock') }}</span></a></li>
                        </ul>
                        <li class="{{ in_array(Request::url(), [route('home'), Request::is('admin/payment_detail/*')]) ? 'active' : '' }}">
                            <a class="waves-effect waves-dark" href="{{ route('home') }}" aria-expanded="false">
                                <i class="fa fa-shopping-bag"></i><span class="hide-menu">{{ __('login.header.orders') }}</span>
                            </a>
                        </li>
                        <li class="{{ Request::url() == route('profile') || in_array($user['id'] ?? null, $user_id ?? []) ? 'active' : '' }}">
                            <a href="{{ route('profile') }}" class="waves-effect waves-dark" aria-expanded="false">
                                <i class="fa fa-user-circle-o"></i><span class="hide-menu">{{ __('login.header.profile') }}</span>
                            </a>
                        </li>
                        @if($userData->isAdmin())
                        <hr>
                        <li class="{{ (Request::url() == route('adminDisplayDashboards')) || (Request::url() == route('adminDisplayDashboards') . '/year') ? 'active' : '' }}">
                            <a href="{{ route('adminDisplayDashboards') }}" class="waves-effect waves-dark" aria-expanded="false">
                                <i class="fa fa-dashboard"></i><span class="hide-menu">{{ __('login.header.dashboards') }}</span>
                            </a>
                        </li>
                        <li data-toggle="collapse" data-target="#promotion" class="" onclick="iconUpDown('promotion',
                                {{ in_array(Request::url(), [
                                    Request::is('admin/promotion/group'),
                                    Request::is('admin/promotion')
                                ]) ? 'true' : 'false' }}
                            );"> 
                            <a class="waves-effect waves-dark" aria-expanded="false">
                                <i class="fa fa-tags"></i>
                                <span class="hide-menu">{{ __('login.header.promotion_s') }}</span>
                                <i id="icon_updown_promotion" class="pull-right text-right {{ in_array(Request::url(), [ Request::is('admin/promotion/group/edit/*'),Request::is('admin/promotion/edit/*'),Request::is('admin/promotion/group'),Request::is('admin/promotion/group/edit/*'),Request::is('admin/promotion/edit/*'),Request::is('admin/promotion') ]) ? 'fa fa-angle-up' : 'fa fa-angle-down' }}"></i>
                            </a>
                        </li>
                        <ul class="sub-menu collapse {{ in_array(Request::url(), [
                                Request::is('admin/promotion/group/edit/*'),
                                Request::is('admin/promotion/edit/*')
                            ]) ? 'show' : '' }}"
                            id="promotion"
                        >
                            <li class="pl-3"><a href="{{ route('adminPromotionGroup') }}" class="{{ Request::url() == Request::is('admin/promotion/group/edit/*') ? 'active' : '' }}"><i class="fa fa-cube"></i><span class="hide-menu"> {{ __('login.header.promotion_pro_group') }}</span></a></li>
                            <li class="pl-3"><a href="{{ route('adminPromotion') }}" class="{{ Request::url() == Request::is('admin/promotion/edit/*') ? 'active' : '' }}"><i class="fa fa-tag"></i><span class="hide-menu"> {{ __('login.header.promotion') }}</span></a></li>
                        </ul>
                        <li>
                            <a class="{{ Request::url() == route('adminBlogs') || Request::url() == route('addBlog') || in_array($blog[0]['id'] ?? null, $blog_id ?? []) || Request::url() == route('adminSearchBlog') ? 'active' : '' }}" href="{{ route('adminBlogs') }}" aria-expanded="false">
                                <i class="fa fa-bullhorn"></i><span class="hide-menu">{{ __('login.header.blogs') }}</span>
                            </a>
                        </li>
                        <li class="{{ Request::url() == route('adminUsers') || in_array($user['id'] ?? null, $users_id ?? []) || Request::url() == route('adminSearchUser') ? 'active' : '' }}">
                            <a class="waves-effect waves-dark" href="{{ route('adminUsers') }}" aria-expanded="false">
                                <i class="fa fa fa-address-card-o"></i><span class="hide-menu">{{ __('login.header.users') }}</span>
                            </a>
                        </li>
                        <li class="{{ Request::url() == route('adminSetting') }}">
                            <a class="waves-effect waves-dark" href="{{ route('adminSetting') }}" aria-expanded="false">
                                <i class="fa fa-gear"></i><span class="hide-menu">{{ __('login.header.setting') }}</span>
                            </a>
                        </li>
                        <!-- <li data-toggle="collapse" data-target="#setting" onclick="iconUpDown('setting',
                                {{ in_array(Request::url(), [
                                    
                                ]) ? 'true' : 'false' }}
                        );"> 
                            <a class="waves-effect waves-dark" aria-expanded="false">
                                <i class="fa fa-gear"></i>
                                <span class="hide-menu">{{ __('login.header.setting') }}</span>
                                <i id="icon_updown_setting" class="pull-right text-right {{ in_array(Request::url(), [ Request::is('/*'),Request::is('/'),Request::is('/*'),Request::is('/') ]) ? 'fa fa-angle-up' : 'fa fa-angle-down' }}"></i>
                            </a>
                        </li>
                        <ul class="sub-menu collapse {{ in_array(Request::url(), [
                                route('adminSetting')
                            ]) ? 'show' : '' }}"
                            id="setting"
                        >
                            <li class="pl-3">
                                <a href="{{ route('adminTreasury') }}" class="{{ Request::url() == Request::is('/*') ? 'active' : '' }}">
                                    <i class="fa fa-spinner"></i>
                                    <span class="hide-menu"> Title</span>
                                </a>
                            </li>
                            <li class="pl-3">
                                <a href="{{ route('adminStock') }}" class="{{ Request::url() == Request::is('/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o-notch"></i>
                                    <span class="hide-menu"> Mata</span>
                                </a>
                            </li>
                            <li class="pl-3 {{ Request::url() == route('adminSetting') }}">
                                <a href="{{ route('adminSetting') }}" class="{{ Request::url() == Request::is('/*') ? 'active' : '' }}">
                                    <i class="fa fa-gear"></i>
                                    <span class="hide-menu"> {{ __('login.header.setting') }}</span>
                                </a>
                            </li>
                        </ul> -->
                        <hr>
                        @endif
                        <li>
                            <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i><span class="hide-menu">{{ __('login.header.logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="{{ Request::url() == route('home') ? 'active' : '' }}">
                            <a class="waves-effect waves-dark" href="/home" aria-expanded="false">
                                <i class="fa fa-shopping-bag"></i><span class="hide-menu">{{ __('login.header.myOrder') }}</span>
                            </a>
                        </li>
                        <li class="{{ Request::url() == route('profile') ? 'active' : '' }}">
                            <a class="waves-effect waves-dark" href="/profile" aria-expanded="false">
                                <i class="fa fa-user-circle-o"></i><span class="hide-menu">{{ __('login.header.profile') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i><span class="hide-menu">{{ __('login.header.logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endif
                    </ul>
                </nav>
            </div>

        </aside>

        <style>
            span {
                font-size: 14px;
            }
        </style>

        <script>
        function iconUpDown(type, check){
            if(check == false){
                var icon = 'fa fa-angle-up';
                var id = 'icon_updown_'+type;
                var change = document.getElementById(id);
                if(change.className == 'pull-right text-right fa fa-angle-down'){
                    change.className = 'pull-right text-right fa fa-angle-up';
                }else{
                    change.className = 'pull-right text-right fa fa-angle-down';
                }
            }
        }
        </script>