@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-10 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.dashboards.title') }}</h3>
            </div>
            <form action="{{ route('adminDashboardSelectYear') }}" method="GET" style="width:100%" class="col-md-2 text-right">
                <select name="year" class="form-control" onchange="this.form.submit()">
                    @foreach($all_year as $key => $item)
                    @php $year_for = "20".$key ; @endphp
                        <option value="{{ $year_for }}" @if($select_year == $year_for) selected @endif>{{ $year_for }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.order.display.title') }}</a></li>
                <li class="breadcrumb-item active">{{ __('login.page.order.display.breadcrumb_view') }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">{{ __('login.page.dashboards.total_amount') }}</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $total }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">{{ __('login.page.dashboards.all_orders') }}</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $all_orders }}</span>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div>
                                <h5 class="card-title m-b-0 align-self-center">{{ __('login.page.dashboards.monthly_income') }}</h5>
                            </div>
                        </div>
                        @php 
                            $value_total_month = json_encode($total_month['total_month']); 
                            $value_total_order_count = json_encode($total_month['total_order_count']); 
                        @endphp
                        <input type="hidden" id="value_total_month" name="value_total_month" value="{{ $value_total_month }}" />
                        <input type="hidden" id="value_total_order_count" name="value_total_order_count" value="{{ $value_total_order_count }}" />
                        <!-- <div class="" id="sales-chart" style="height: 355px;" ></div> -->
                        <div class="" id="myfirstchart" style="height: 355px;" ></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex m-b-30 no-block">
                            <h5 class="card-title m-b-0 align-self-center">{{ __('login.page.dashboards.top_product_group') }}</h5>
                        </div>
                        <input type="hidden" id="categorie_name" name="categorie_name" value="{{ json_encode($categorie_quantity[0] ?? null, JSON_UNESCAPED_UNICODE ) }}" />
                        <input type="hidden" id="categorie_quantity" name="categorie_quantity" value="{{ json_encode($categorie_quantity[1] ?? null, JSON_UNESCAPED_UNICODE ) }}" />
                        <div id="pie-chart" style="height:260px; width:100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title">{{ __('login.page.dashboards.top_user') }}</h5>
                            </div>
                        </div>
                        <div class="table-responsive m-t-20 no-wrap">
                            <table class="table vm no-th-brd pro-of-month">
                                <thead>
                                    <tr>
                                        <th colspan="2">{{ __('login.page.dashboards.user_name') }}</th>
                                        <th>{{ __('login.page.dashboards.price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($top_user as $item)
                                    <tr>
                                        <td><span class="round" style="background:no-repeat;"><img src="{{ $item['image']['url'] }}" width="50" height="50"></span></td>
                                        <td>
                                            <h6>{{ $item['user_name'] }}</h6><small class="text-muted">{{ $item['user_email'] }}</small>
                                        </td>
                                        <td><span class="h6 font-weight-bold mb-0">{{ number_format($item['orders_price'], 2) }}</span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title">{{ __('login.page.dashboards.best_selling_products') }}</h5>
                            </div>
                        </div>
                        <div class="table-responsive m-t-20 no-wrap">
                            <table class="table vm no-th-brd pro-of-month">
                                <thead>
                                    <tr>
                                        <th colspan="2">{{ __('login.page.dashboards.product_name') }}</th>
                                        <th>{{ __('login.page.dashboards.percent') }}</th>
                                        <th>{{ __('login.page.dashboards.quantity') }}</th>
                                        <th>{{ __('login.page.dashboards.price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($top_product != null)
                                @foreach($top_product as $item)
                                    <tr>
                                        <td><span class="round" style="background:no-repeat;"><img src="{{ $item['product_image']['url'] }}" width="50" height="50"></span></td>
                                        <td>
                                            <h6>{{ $item['product_name'] }}</h6><small class="text-muted">{{ $item['categorie_name'] }}</small>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="{{ $item['percen'] * 1 }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $item['percen'] }}%">
                                                    {{ $item['percen'] * 1 }} %
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item['product_quantity']) }}</td>
                                        <td><span class="h6 font-weight-bold mb-0">{{ number_format($item['product_total'], 2) }}</span></td>
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-body mailbox">
                    <h5 class="card-title">{{ __('login.page.dashboards.notification') }}</h5>
                    <div class="message-center ps ps--theme_default ps--active-y" data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd" style="height:auto;">
                        <div class="table-responsive">
                            <table id="table_id_dashboard" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ __('login.page.dashboards.title') }}</th>
                                    <th scope="col">{{ __('login.page.dashboards.time') }}</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach($logs as $item)
                                    <tr>
                                        <td>{{ $item['data']['id'] }}</td>
                                        <td>
                                            <a>
                                                <div class="btn btn-{{ $item['data']['type'] }} btn-circle"><i class="{{ $item['data']['icon'] }}"></i></div>
                                                <div class="mail-contnet">
                                                    @foreach($item['data']['description'] as $key => $item2)
                                                        @if($key == \Session::get('locale'))
                                                        <h5>{{ $item['data']['description'][$key] }}</h5>
                                                        @endif
                                                    @endforeach
                                                    <span class="mail-desc">{{ $item['user'] }}</span>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="time">{{ \Carbon\Carbon::parse($item['data']['created_at'])->isoFormat('Do MMM YYYY H:m:s')}}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Notification And Feeds -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet" />

<script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/displayDashboard.js') }}"></script>

<script>
var value_total_month = document.getElementById("value_total_month").value;
var value_total_month1 = value_total_month.substring(1);
var value_total_month2 = value_total_month1.slice(0, -1);
var value_total_month_new = value_total_month2.split(",");

var value_total_order_count = document.getElementById("value_total_order_count").value;
var value_total_order_count1 = value_total_order_count.substring(1);
var value_total_order_count2 = value_total_order_count1.slice(0, -1);
var value_total_order_count_new = value_total_order_count2.split(",");

var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

var result_lineData = [];
month.forEach((element, key) => {
    result_lineData.push({month : element, amount: value_total_month_new[key], orders : value_total_order_count_new[key]});
});

var morrisLine;
initMorris();
//getMorris(); 
getMorrisOffline();

function initMorris() {
   morrisLine = Morris.Bar({
    element: 'myfirstchart',
    xkey: 'month',
    ykeys: ['amount', 'orders'],
    labels: ['Amount', 'Orders'],
    xLabelAngle: 60,
    parseTime: false,
    resize: true,
    // lineColors: ['#32c5d2', '#c03e26'],
    barColors: ['#67038F','#67038F','#67038F','#67038F','#67038F','#67038F','#67038F','#67038F','#67038F','#67038F','#67038F','#67038F',]
  });
}

function setMorris(data) {
  morrisLine.setData(data);
}

function getMorris() {
  $.get('@Url.Action("GetData")', function (result) {
    setMorris(result);      
  });
}

function getMorrisOffline() {
 var lineData = result_lineData;
  setMorris(lineData);
}

var categorie_name = document.getElementById("categorie_name").value;
var categorie_name1 = categorie_name.substring(1);
var categorie_name2 = categorie_name1.slice(0, -1);
var categorie_name_new = categorie_name2.split(",");

var categorie_quantity = document.getElementById("categorie_quantity").value;
var categorie_quantity1 = categorie_quantity.substring(1);
var categorie_quantity2 = categorie_quantity1.slice(0, -1);
var categorie_quantity_new = categorie_quantity2.split(",");

var result_donut = [];
categorie_name_new.forEach((element, key) => {
    result_donut.push({label : element, value: categorie_quantity_new[key]});
});

Morris.Donut({
  element: 'pie-chart',
  data: result_donut,
  resize: true,
  redraw: true,
  colors: ['#67038F','#B20057', '#7BC700', '#CAD500','rgb(0, 188, 212)']
});

</script>

<style>
    .morris-hover.morris-default-style{
        background: #666;
    }
</style>

@endsection

