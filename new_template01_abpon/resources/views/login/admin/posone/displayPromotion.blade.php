@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.promotion.display.promotion') }}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <button type="button" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down" data-toggle="modal" data-target="#product_insert" >{{ __('login.page.products.display.create') }}</button>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('adminPromotion') }}">{{ __('login.page.promotion.display.promotion') }}</a></li>
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>

        <div class="modal" id="product_insert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form action="{{ route('promotionInsert') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                    
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('login.page.promotion.display.create_promotion') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <p aria-hidden="true">&times;</p>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div style="padding:20px">                        
                                <div class="form-group row">
                                    <label for="PMCode" class="col-sm-2 col-form-label">{{ __('login.page.promotion.display.code') }}</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" class="form-control" name="PMCode" id="PMCode" value="{{ $last_pmCode }}" >
                                        <input type="text" class="form-control" name="PMCode" id="PMCode" value="{{ $last_pmCode }}" disabled>
                                    </div>
                                </div>                          
                                <div class="form-group row">
                                    <label for="pmName" class="col-sm-2 col-form-label">* {{ __('login.page.promotion.display.promotion_name') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pmName" id="pmName" placeholder="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pmDetail" class="col-sm-2 col-form-label">{{ __('login.page.promotion.display.remark') }}</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="pmDetail" name="pmDetail" rows="3"></textarea>     
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mx-auto border border-dark" style="padding: 2%;">                                 
                                        <div class="form-group row">
                                            <label for="date_end" class="col-sm-2 col-form-label">* {{ __('login.page.promotion.display.extend_time') }}</label>
                                            <div class="col-sm-10">                                          
                                                <input type="text" class="form-control" id="demo" name="datefilter" value="" />
                                            </div>  
                                        </div>
                                        <div class="form-group row">                                                                   
                                            <label for="" class="col-sm-2 col-form-label">* {{ __('login.page.promotion.display.day') }}</label>
                                            <div class="col-sm-10">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_1" value="MON">
                                                    <label class="form-check-label" for="day_1">{{ __('login.page.promotion.display.mon') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_2" value="TUE">
                                                    <label class="form-check-label" for="day_2">{{ __('login.page.promotion.display.tue') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_3" value="WED">
                                                    <label class="form-check-label" for="day_3">{{ __('login.page.promotion.display.wed') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_4" value="THU">
                                                    <label class="form-check-label" for="day_4">{{ __('login.page.promotion.display.thu') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_5" value="FRI">
                                                    <label class="form-check-label" for="day_5">{{ __('login.page.promotion.display.fri') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_6" value="SAT">
                                                    <label class="form-check-label" for="day_6">{{ __('login.page.promotion.display.sat') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="promDay[]" id="day_7" value="SUN">
                                                    <label class="form-check-label" for="day_7">{{ __('login.page.promotion.display.sun') }}</label>
                                                </div>                                              
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="discount_per" class="col-sm-2 col-form-label">* {{ __('login.page.promotion.display.discount') }}</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input class="form-control" type="number" name="discount_per" id="discount_per" min="1" max="100" onchange="eventDiscountPer(this.value)" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input class="form-control" type="number" name="discount" id="discount" min="1" onchange="eventDiscount(this.value)">
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

                                                @foreach ($promotion_group as $item)
                                                <div class="form-check">
                                                    <input class="form-check-input" name="promotion_group[]" type="checkbox" value="{{ $item->PGPCode }}" id="promotion_group[{{ $item->PGPCode }}]">
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
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                            <button type="submit" class="btn btn-outline-info">{{ __('login.page.products.display.save') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('login.page.products.display.close') }}</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- Add product end -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="table_id" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col"> {{ __('login.page.promotion.display.code') }}</th>
                                    <th scope="col"> {{ __('login.page.promotion.display.promotion_name') }}</th>
                                    <th scope="col"> {{ __('login.page.promotion.display.start_date') }}</th>
                                    <th scope="col"> {{ __('login.page.promotion.display.end_date') }}</th>
                                    <th scope="col"> {{ __('login.page.promotion.display.time') }}</th>
                                    <th scope="col"> {{ __('login.page.promotion.display.day') }}</th>
                                    <th scope="col"> {{ __('login.page.promotion.display.discount') }}</th>
                                    <!-- <th scope="col"> {{ __('login.page.promotion.display.discount') }}</th> -->
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promotion as $item)
                                <tr>
                                    <td>{{ $item['data']->PMId }}</td>                                    
                                    <td>{{ $item['data']->PMCode }}</td>
                                    <td>{{ $item['data']->PMName }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['data']->PMStartDate)->isoFormat('Do MMM YYYY')}}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['data']->PMEndDate)->isoFormat('Do MMM YYYY')}}</td>
                                    <td>{{ $item['data']->StartTime }} - {{ $item['data']->EndTime }}</td>
                                    <td>{{ $item['data']->PromDay }}</td>
                                    <td>{{ number_format($item['discAllRate'], 2) }} %</td>
                                    <!-- <td>{{ number_format($item['discAllAmt'], 2) }} {{ __('login.page.promotion.display.baht') }}</td> -->
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a href="{{ route('promotionEdit', [ 'id' => $item['data']->PMId ]) }}" class="btn btn-sm btn-outline-warning"> <i class="fa fa-edit"></i> {{ __('login.page.products.display.edit') }}</a>
                                            <a href="{{ route('promotionDelete', [ 'id' => $item['data']->PMId ]) }}" onclick="@if(\Session::get('locale') != 'th') return confirm('Are you sure?') @else return confirm('คุณแน่ใจที่จะลบ') @endif" class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> {{ __('login.page.products.display.delete') }}</a>
                                        </div>
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
        // "endDate": "December 31, 2016 @ h:mm A",
        "opens": "center"
    });
    
    </script>

    @endsection
