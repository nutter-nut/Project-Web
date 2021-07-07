@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.header.setting') }}</h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('adminSetting') }}">{{ __('login.header.setting') }}</a></li>
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>

        <!-- Add product end -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('adminSettingUpdate') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <h6 class="heading-small text-muted mb-4">{{ __('login.page.setting.display.company') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label">{{ __('login.page.setting.display.name') }}</label>
                                            <input type="text" name="company_name" class="form-control" placeholder="" value="{{ $config[19]['value'] }}"> 
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" >{{ __('login.page.setting.display.email') }}</label>
                                            <input type="text" name="company_email" class="form-control" placeholder="" value="{{ $config[18]['value'] }}" required> 
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">{{ __('login.page.setting.display.telephone') }}</label>
                                            <input type="text" name="company_phone" class="form-control" placeholder="" value="{{ $config[17]['value'] }}" onkeyup="autoTab2(this,3)"> 
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">{{ __('login.page.setting.display.tax_no') }}</label>
                                            <input type="text" name="contact_tax_no" class="form-control" placeholder="" value="{{ $config[21]['value'] }}"> 
                                        </div>
                                    </div>
                                    <div class="col-lg"></div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <label class="form-control-label">{{ __('login.page.setting.display.about') }}</label>
                                            <textarea name="company_about" rows="4" class="form-control" placeholder="">{{ $config[15]['value'] }}</textarea> 
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">{{ __('login.page.setting.display.address') }}</label>
                                            <textarea name="company_address" rows="4" class="form-control" placeholder="">{{ $config[16]['value'] }}</textarea> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4" />
                            <div class="row">
                                <div class="col-6 mx-auto border border-dark" style="padding: 2%;">
                                    <h6 class="heading-small text-muted mb-4">{{ __('login.page.setting.display.payment_credit_card') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.payment_url') }}</label>
                                                    <input type="hidden" name="payment_payment_url"
                                                        value="{{ $config[3]['value'] }}">
                                                    <input type="text" class="form-control" placeholder=""
                                                        value="{{ $config[3]['value'] }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.web_url') }}</label>
                                                    <input type="text" name="payment_url_myweb" class="form-control"
                                                        placeholder="" value="{{ $config[4]['value'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.currency') }}</label>
                                                    <select name="payment_currencycode" class="form-control">
                                                        <option value="USD" @if($config[5]['value']=='USD' ) selected @endif>{{ __('login.page.setting.display.currency_dollar') }}</option>
                                                        <option value="THB" @if($config[5]['value']=='THB' ) selected @endif>{{ __('login.page.setting.display.currency_baht') }}</option>
                                                        <option value="CNY" @if($config[5]['value']=='CNY' ) selected @endif>{{ __('login.page.setting.display.currency_yuan') }}</option>
                                                        <option value="MYR" @if($config[5]['value']=='MYR' ) selected @endif>{{ __('login.page.setting.display.currency_ringgit') }}</option>
                                                        <option value="PHP" @if($config[5]['value']=='PHP' ) selected @endif>{{ __('login.page.setting.display.currency_peso') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.cust_ip') }}</label>
                                                    <input type="text" name="payment_custip" class="form-control" placeholder="" value="{{ $config[6]['value'] }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.cust_name') }}</label>
                                                    <input type="text" name="payment_custname" class="form-control" placeholder="" value="{{ $config[7]['value'] }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.cust_email') }}</label>
                                                    <input type="text" name="payment_custemail" class="form-control" placeholder="" value="{{ $config[8]['value'] }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.cust_phone') }}</label>
                                                    <input type="text" name="payment_custphone" class="form-control" placeholder="" value="{{ $config[9]['value'] }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.page_timeout') }}</label>
                                                    <input type="text" name="pagetimeout" class="form-control" placeholder="" value="{{ $config[10]['value'] }}">
                                                    <small class="text-muted">
                                                        {{ __('login.page.setting.display.page_timeout_sup') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mx-auto border border-dark" style="padding: 2%;">
                                    <h6 class="heading-small text-muted mb-4">{{ __('login.page.setting.display.payment_paypal') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.paypal_url') }}</label>
                                                    <input type="hidden" name="payment_paypal_url" value="{{ $config[11]['value'] }}">
                                                    <input type="text" class="form-control" value="{{ $config[11]['value'] }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.paypal_client_id') }}</label>
                                                    <input type="text" name="payment_paypal_client_id" class="form-control" placeholder="" value="{{ $config[12]['value'] }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.paypal_secret') }}</label>
                                                    <input type="text" name="payment_paypal_secret" class="form-control" placeholder="" value="{{ $config[13]['value'] }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ __('login.page.setting.display.paypal_env') }}</label>
                                                    <input type="text" name="payment_paypal_env" class="form-control" placeholder="" value="{{ $config[14]['value'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4" />
                            <!-- Description -->
                            <h6 class="heading-small text-muted mb-4">{{ __('login.page.setting.display.treasury_stock') }}</h6>
                            <div class="pl-lg-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <p>{{ __('login.page.setting.display.sell_​​products_at') }} <span>( {{ $treasury_select['name'] }} )</span></p>
                                                    <p style="color:darkgray;">{{ __('login.page.setting.display.sell_​​products_at_sup') }} <a href="{{ route('adminTreasury') }}">{{ __('login.page.setting.display.sell_​​products_at_sup_link') }}</a></p>
                                                </th>
                                                <td style="text-align: right;">
                                                    <select name="treasury" class="form-control" id="treasury">
                                                        @foreach ($get_treasury as $item)
                                                        <option value="{{ $item->whCode }},{{ $item->whTName }}" class="form-control" @if($item->whCode == $treasury_select['code'] ) selected @endif>{{ $item->whTName }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <hr class="my-4" />
                            <!-- Description -->
                            <h6 class="heading-small text-muted mb-4">{{ __('login.page.setting.display.chat') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">{{ __('login.page.setting.display.first_message') }}</label>
                                            <textarea name="first_messages" rows="4" class="form-control" placeholder="">{{ $config[2]['value'] }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label">{{ __('login.page.setting.display.limit_messages') }}</label>
                                            <select name="limit_messages" class="form-control">
                                                <option value="10" @if($config[1]['value']=='10' ) selected @endif>10</option>
                                                <option value="20" @if($config[1]['value']=='20' ) selected @endif>20</option>
                                                <option value="50" @if($config[1]['value']=='50' ) selected @endif>50</option>
                                            </select>
                                            <small class="text-muted">
                                                {{ __('login.page.setting.display.limit_messages_sub') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label">{{ __('login.page.setting.display.delete_old_messages') }}</label>
                                            <div class="input-group">
                                                <input type="text" name="delete_old_messages" class="form-control" placeholder="Date" value="{{ $config[0]['value'] }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">{{ __('login.page.setting.display.delete_old_messages_uom') }}</span>
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                {{ __('login.page.setting.display.delete_old_messages_sub') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="float-left">
                                <button type="submit" class="btn btn-outline-info">{{ __('login.page.setting.display.btn_update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/autoTab.js') }}"></script>

    @endsection
