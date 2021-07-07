@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.promotion.display.promotion') }}</h3>
            </div>
            <!-- <div class="col-md-7 align-self-center">
                <button type="button" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down" data-toggle="modal" data-target="#product_insert" >สร้าง</button>
            </div> -->
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('adminPromotion') }}">{{ __('login.page.promotion.display.promotion') }}</a></li>
                <li class="breadcrumb-item active">{{ $promotion_edit->PMCode }}</li>
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
                                     
                        <form action="{{ route('promotionUpdate', [ 'id' => $promotion_edit->PMId ]) }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                        {{csrf_field()}}

                            <div style="padding:20px">                        
                                <div class="form-group row">
                                    <label for="PMCode" class="col-sm-2 col-form-label">{{ __('login.page.promotion.display.code') }}</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" class="form-control" name="PMCode" id="PMCode" value="{{ $promotion_edit->PMCode }}" >
                                        <input type="text" class="form-control" name="PMCode" id="PMCode" value="{{ $promotion_edit->PMCode }}" disabled>
                                    </div>
                                </div>                          
                                <div class="form-group row">
                                    <label for="pmName" class="col-sm-2 col-form-label">* {{ __('login.page.promotion.display.promotion_name') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pmName" id="pmName" value="{{ $promotion_edit->PMName }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pmDetail" class="col-sm-2 col-form-label">{{ __('login.page.promotion.display.remark') }}</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="pmDetail" name="pmDetail" value="" rows="3"></textarea>     
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mx-auto border border-dark" style="padding: 2%;">                                 
                                        <div class="form-group row">
                                            <label for="date_end" class="col-sm-3 col-form-label">* {{ __('login.page.promotion.display.extend_time') }}</label>
                                            <div class="col-sm-9">                                          
                                                <input type="text" class="form-control" id="demo" name="datefilter" value="" />
                                            </div>  
                                        </div>
                                        <div class="form-group row">                                                                   
                                            <label for="" class="col-sm-3 col-form-label">* {{ __('login.page.promotion.display.day') }}</label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_1" value="MON" @if (in_array("MON", $arr_promDay)) checked @endif>
                                                    <label class="form-check-label" for="day_1">{{ __('login.page.promotion.display.mon') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_2" value="TUE" @if (in_array("TUE", $arr_promDay)) checked @endif>
                                                    <label class="form-check-label" for="day_2">{{ __('login.page.promotion.display.tue') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_3" value="WED" @if (in_array("WED", $arr_promDay)) checked @endif>
                                                    <label class="form-check-label" for="day_3">{{ __('login.page.promotion.display.wed') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_4" value="THU" @if (in_array("THU", $arr_promDay)) checked @endif>
                                                    <label class="form-check-label" for="day_4">{{ __('login.page.promotion.display.thu') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_5" value="FRI" @if (in_array("FRI", $arr_promDay)) checked @endif>
                                                    <label class="form-check-label" for="day_5">{{ __('login.page.promotion.display.fri') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_6" value="SAT" @if (in_array("SAT", $arr_promDay)) checked @endif>
                                                    <label class="form-check-label" for="day_6">{{ __('login.page.promotion.display.sat') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_7" value="SUN" @if (in_array("SUN", $arr_promDay)) checked @endif>
                                                    <label class="form-check-label" for="day_7">{{ __('login.page.promotion.display.sun') }}</label>
                                                </div>                                              
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="discount_per" class="col-sm-3 col-form-label">* {{ __('login.page.promotion.display.discount') }}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                <!-- @if($promotion_dc['discAllRate']==0) disabled @endif -->
                                                    <input class="form-control" type="number" name="discount_per" id="discount_per" min="1" max="100" value="{{ number_format($promotion_dc['discAllRate'], 2) }}" onchange="eventDiscountPer(this.value)" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input class="form-control" type="number" name="discount" id="discount" min="1" value="{{ number_format($promotion_dc['discAllAmt'], 2) }}" onchange="eventDiscount(this.value)" @if($promotion_dc['discAllAmt']==0) disabled @endif>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">{{ __('login.page.promotion.display.baht') }}</span>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>                                        
                                    </div>

                                    <div class="col-6 mx-auto border border-dark" style="padding: 2%;">
                                        <div class="form-group row">                                                                   
                                            <label for="" class="col-sm-4 col-form-label">* {{ __('login.page.promotion.display.condition') }}</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" name="promotion_group_select" value="{{ $promotion_group_select }}">

                                                @foreach ($promotion_group as $item)
                                                <div class="form-check">
                                                    <input class="form-check-input" name="promotion_group[]" type="checkbox" value="{{ $item->PGPCode }}" id="promotion_group[{{ $item->PGPCode }}]" @foreach ($select_promotion_group as $items) @if($items->PromotionProdGroupCode == $item->PGPCode)) checked @endif @endforeach>
                                                    <label class="form-check-label" for="promotion_group[{{ $item->PGPCode }}]">
                                                        {{ $item->PGPName }}
                                                    </label>
                                                </div>
                                                @endforeach

                                                <div class="valid-feedback">
                                                {{ __('login.page.promotion.display.promotion_conditions_product_group_name') }}
                                                </div>
                                            </div> 
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="float-left">
                                <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                                <input type="hidden" id="datefilter_start_value" value="{{ $datefilter_value['start'] }}">
                                <input type="hidden" id="datefilter_end_value" value="{{ $datefilter_value['end'] }}">
                                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('login.page.products.display.close') }}</button> -->
                                <button type="submit" class="btn btn-outline-info">{{ __('login.page.promotion.display.update') }}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/displayPromotion.js') }}"></script>

    <!-- Include Required Prerequisites -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" /> -->
    
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    <script>
    var local = document.getElementById("local");
    var datefilter_start_value = document.getElementById("datefilter_start_value");
    var datefilter_end_value = document.getElementById("datefilter_end_value");

    var day_th = [
        ["จ.","อ.","พ.","พฤ","ศ.","ส.","อา."],
        ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"]
    ]
    var day_en = [
        ["Su","Mo","Tu","We","Th","Fr","Sa"],
        ["January","February","March","April","May","June","July","August","September","October","November","December"]
    ]
    var btn_apply_th = "ตกลง";
    var btn_apply_en = "Apply";

    var btn_cancel_th = "ยกเลิก";
    var btn_cancel_en = "Cancel";

    var btn_clear_th = "ล้าง";
    var btn_clear_en = "Clear";

    if(local.value != 'th'){
        var day = day_en;
        var btn_apply = btn_apply_en;
        var btn_cancel = btn_cancel_en;
        var btn_clear = btn_clear_en;
    }else{
        var day = day_th;
        var btn_apply = btn_apply_th;
        var btn_cancel = btn_cancel_th;
        var btn_clear = btn_clear_th;
    } 

    $('#demo').daterangepicker({
        "showISOWeekNumbers": true,
        "timePicker": true,
        "autoUpdateInput": true,
        "locale": {
            "cancelLabel": btn_clear,
            "format": "YYYY-MM-DDTh:mm A",
            "separator": " to ",
            "applyLabel": btn_apply,
            "cancelLabel": btn_cancel,
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": day[0],
            "monthNames": day[1],
            "firstDay": 1
        },
        "linkedCalendars": true,
        "showCustomRangeLabel": false,
        "startDate": 1,
        "startDate" : datefilter_start_value.value,
        "endDate": datefilter_end_value.value,
        "opens": "center"
    });
    </script>

    @endsection
