@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.order.display.title') }}</h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.order.display.title') }}</a></li>
                <li class="breadcrumb-item active">{{ $order['id'] }}</li>
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice p-5">
                            <div class="container padding-bottom-3x mb-1">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
                                            <div class="@if($status[1]) step completed @else step @endif">
                                                <div class="step-icon-wrap">
                                                    <div class="step-icon"><i class="pe-7s-config"></i></div>
                                                </div>
                                                <h4 class="step-title">{{ __('login.page.receipt.display.processing_order') }}</h4>
                                            </div>
                                            <div class="@if($status[2]) step completed @else step @endif">
                                                <div class="step-icon-wrap">
                                                    <div class="step-icon"><i class="pe-7s-cart"></i></div>
                                                </div>
                                                <h4 class="step-title">{{ __('login.page.receipt.display.confirmed_order') }}</h4>
                                            </div>
                                            <div class="@if($status[3]) step completed @else step @endif">
                                                <div class="step-icon-wrap">
                                                    <div class="step-icon"><i class="pe-7s-medal"></i></div>
                                                </div>
                                                <h4 class="step-title">{{ __('login.page.receipt.display.quality_check') }}</h4>
                                            </div>
                                            <div class="@if($status[4]) step completed @else step @endif">
                                                <div class="step-icon-wrap">
                                                    <div class="step-icon"><i class="pe-7s-car"></i></div>
                                                </div>
                                                <h4 class="step-title">{{ __('login.page.receipt.display.product_dispatched') }}</h4>
                                            </div>
                                            <div class="@if($status[5]) step completed @else step @endif">
                                                <div class="step-icon-wrap">
                                                    <div class="step-icon"><i class="pe-7s-home"></i></div>
                                                </div>
                                                <h4 class="step-title">{{ __('login.page.receipt.display.product_delivered') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap flex-md-nowrap justify-content-center justify-content-sm-between align-items-center"></div>
                            </div> 
                            <!-- <h5>Your order Confirmed!</h5>  -->
                            <span class="font-weight-bold d-block mt-4">{{ __('login.page.receipt.display.hello') }}{{ $order['full_name'] }}</span> 
                            @if(($order['status_payment'] * 1) != 1)
                            <span>{{ __('login.page.receipt.display.hello_sup_2') }}</span>
                            @else
                            <span>{{ __('login.page.receipt.display.hello_sup') }}</span>
                            @endif
                            <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="py-2"> <span class="d-block text-muted">{{ __('login.page.receipt.display.order_date') }}</span> <span>{{ \Carbon\Carbon::parse($order['date'])->isoFormat('Do MMM YYYY')}}</span> </div>
                                            </td>
                                            <td>
                                                <div class="py-2"> <span class="d-block text-muted">{{ __('login.page.receipt.display.order_no') }}</span> <span>{{ $payment['payment_id'] ?? 'no' }}</span> </div>
                                            </td>
                                            <td>
                                                <div class="py-2"> <span class="d-block text-muted">{{ __('login.page.receipt.display.payment') }}</span> <span><img src="https://img.icons8.com/color/48/000000/mastercard.png" width="20" />{{ $payment['payment_type'] ?? 'no' }}</span> </div>
                                            </td>
                                            <td>
                                                <div class="py-2"> <span class="d-block text-muted">{{ __('login.page.receipt.display.shiping_address') }}</span> <span>{{ $order['address'] }}</span> </div>
                                            </td>
                                            <td>
                                                <div class="py-2"> <span class="d-block text-muted">{{ __('login.page.receipt.display.status') }}</span> <span>@if(\Session::get('locale') != 'th') {{ $status_text['status_en'] }} @else {{ $status_text['status_th'] }} @endif</span> </div>
                                            </td>
                                            @if(($order['status_payment'] * 1) != 1)
                                            <td>
                                                <div class="py-2">
                                                    <a class="btn btn-outline-success" href="{{ route('payAgain', [ 'id' => $order['id'] ]) }}" role="button">{{ __('login.page.receipt.display.pay_again') }}</a>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="product border-bottom table-hover table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th style="width:10%;">#</th>                
                                            <th style="width:30%;">{{ __('login.page.receipt.display.details') }}</th>
                                            <th style="width:13%;">{{ __('login.page.receipt.display.tax_type') }}</th>
                                            <th style="width:15%;">{{ __('login.page.receipt.display.promotion') }}</th>
                                            <th style="width:10%;">{{ __('login.page.receipt.display.amount') }}</th>
                                            <th style="width:10%;">{{ __('login.page.receipt.display.price_unit') }}</th>
                                            <th class="text-right" style="width:12%;">{{ __('login.page.receipt.display.total') }}</th>
                                        </tr>
                                        @php  
                                            $i = 1; 
                                            $sum_vat = 0;
                                            $disc = 0;
                                            $sum_price_vat = 0;
                                            $vat_i = 0;

                                            if(\Session::get('locale') != 'th'){
                                                $vat_included_text = 'Tax included';
                                                $vat_charge_text = 'Charge';
                                                $vat_no_text = 'No tax';
                                            }else{
                                                $vat_included_text = 'รวมภาษี';
                                                $vat_charge_text = 'คิดภาษี';
                                                $vat_no_text = 'ไม่คิดภาษี';
                                            }
                                        @endphp
                                        @foreach ($order['cart'][0] as $item)
                                            @php
                                                $sum_vat += ($item['data']['price_vat'] - $item['data']['prodUnitPrice']) * $item['quantity'];
                                                $disc += ($item['data']['promotion'] != 'no') ? ($item['data']['price_vat'] * ($item['data']['discount'] / 100)) * $item['quantity'] : 0;
                                                $price_vat = ($item['data']['prodIsVat'] == 'I') ? ($item['data']['prodUnitPrice'] * 93 ) / 100 : $item['data']['prodUnitPrice'];
                                                $vat_i += ($item['data']['prodIsVat'] == 'I') ? ($item['data']['prodUnitPrice'] - (($item['data']['prodUnitPrice'] * 93 ) / 100)) * $item['quantity'] : 0;
                                                $sum_price_vat += $price_vat * $item['quantity'];
                                            @endphp
                                            <tr>
                                                <td style="width:50px;"> 
                                                    @if ($item['image'] != 'no_picture')
                                                        <img class="profileimg2" src="{{ asset('posone_images') }}/SINGLE/MenuGroup/{{ $item['image'] }}">       
                                                    @else
                                                        <img  class="profileimg2"src="{{ asset('storage') }}/product_images/product_default.png">
                                                    @endif
                                                </td>
                                                <td>{{ $item['data']['prodTName'] }}</td>
                                                <td>@if($item['data']['prodIsVat'] == 'I') {{ $vat_included_text }} @elseif($item['data']['prodIsVat'] == 'Y') {{ $vat_charge_text }} @else {{ $vat_no_text }} @endif</td>
                                                <td>@if($item['data']['promotion'] != 'no') {{ $item['data']['promotion'] }} (-{{ $item['data']['discount'] }}%) @else ไม่มี @endif</td>
                                                <td>{{ $item['quantity'] }} {{ $item['data']['uomName'] }}</td>
                                                <td>{{ number_format($price_vat, 2) }}</td>
                                                <td>
                                                    <div class="text-right"> <span class="font-weight-bold">{{ number_format($price_vat * $item['quantity'], 2) }} {{ __('login.page.receipt.display.baht') }}</span> </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row d-flex justify-content-end">
                                <div class="col-md-5">
                                    <table class="table table-borderless">
                                        <tbody class="totals">
                                            <tr>
                                                <td>
                                                    <div class="text-left"> <span class="text-muted">{{ __('login.page.receipt.display.overall') }}</span></div>
                                                </td>
                                                <td>
                                                    <div class="text-right"> <span>{{ number_format($sum_price_vat, 2) }} {{ __('login.page.receipt.display.baht') }}</span></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="text-left"> <span class="text-muted">{{ __('login.page.receipt.display.discount') }}</span></div>
                                                </td>
                                                <td>
                                                    <div class="text-right"> <span>{{ number_format($disc, 2) }} {{ __('login.page.receipt.display.baht') }}</span></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="text-left"> <span class="text-muted">{{ __('login.page.receipt.display.price_after_discount') }}</span></div>
                                                </td>
                                                <td>
                                                    <div class="text-right"> <span>{{ number_format($sum_price_vat - $disc, 2) }} {{ __('login.page.receipt.display.baht') }}</span></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="text-left"> <span class="text-muted">{{ __('login.page.receipt.display.vat') }}</span></div>
                                                </td>
                                                <td>
                                                    <div class="text-right"> <span>{{ number_format($sum_vat + $vat_i, 2) }} {{ __('login.page.receipt.display.baht') }}</span></div>
                                                </td>
                                            </tr>
                                            <tr class="border-top border-bottom">
                                                <td>
                                                    <div class="text-left"> <span class="font-weight-bold">{{ __('login.page.receipt.display.total') }}</span> </div>
                                                </td>
                                                <td>
                                                    <div class="text-right"> <span class="font-weight-bold">{{ number_format($order['price'], 2) }} {{ __('login.page.receipt.display.baht') }}</span></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <p>{{ __('login.page.receipt.display.send_email') }}</p>
                            <p class="font-weight-bold mb-0">{{ __('login.page.receipt.display.thanks') }}</p>
                        </div>
                        <div class="d-flex justify-content-between footer p-3"> <span>{{ __('login.page.receipt.display.help') }}<a href="#">{{ __('login.page.receipt.display.help_link') }}</a></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('assets/css/receipt.css') }}">

@endsection
