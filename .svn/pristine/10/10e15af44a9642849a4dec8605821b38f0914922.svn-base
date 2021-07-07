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
                <li class="breadcrumb-item">{{ __('login.page.promotion.display.promotion') }}</li>
                <li class="breadcrumb-item active"><a href="{{ route('adminPromotion') }}">{{ __('login.page.promotion.display.promotion_group') }}</a></li>
                <li class="breadcrumb-item active">{{ $promotion_group_edit->PGPCode }}</li>
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
                        <form action="{{ route('promotionGroupUpdate') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                        {{csrf_field()}}                    
                            <div style="padding:20px">                            
                                <div class="form-group row">
                                    <label for="PGPCode" class="col-sm-2 col-form-label">* {{ __('login.page.promotion.display.code') }}</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" class="form-control" name="PGPCode" value="{{ $promotion_group_edit->PGPCode }}">
                                        <input type="text" class="form-control" name="PGPCode" id="PGPCode" value="{{ $promotion_group_edit->PGPCode }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="PGPName" class="col-sm-2 col-form-label">* {{ __('login.page.promotion.display.promotion_group_name') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="PGPName" id="PGPName" placeholder="" value="{{ $promotion_group_edit->PGPName }}" required>
                                    </div>
                                </div>                                                              
                                <div class="form-group row">
                                    <label for="PGPRemark" class="col-sm-2 col-form-label">{{ __('login.page.promotion.display.remark') }}</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="PGPRemark" id="PGPRemark" rows="3">{{ $promotion_group_edit->PGPRemark }}</textarea>     
                                    </div>
                                </div>                                                              
                                <div class="row">
                                    <div class="col-6 mx-auto border border-dark" style="padding: 2%;">                                 
                                        <div class="form-group row">                                                                   
                                            <label for="" class="col-sm-3 col-form-label">{{ __('login.page.promotion.display.select_product_group') }}</label>
                                            <div class="col-sm-9">
                                                <select name="product_group" id="sectorSelect" class="form-control">
                                                    @foreach ($product_group as $item)
                                                        <option value="{{ $item->prodGroupCode }}" class="form-control">{{ $item->prodGroupCode }}-{{ $item->prodGroupName }}</option>
                                                    @endforeach
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="form-group row"> 
                                            <label for="subSectorSelect" class="col-sm-3 col-form-label">{{ __('login.page.promotion.display.select_product') }}</label>
                                            <div class="col-sm-9">
                                                <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                                                <select name="product[]" class="form-control" id="subSectorSelect">
                                                    @if(count($get_product) > 0)
                                                        @foreach ($get_product as $item)
                                                            <option value="{{ $item->prodCode }},{{ $item->prodUnit1UOMCode }},{{ $item->prodTName}}" class="form-control">{{ $item->prodCode }}-{{ $item->prodTName }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="" class="form-control">@if(\Session::get('locale') != 'th') No data found @else ไม่พบข้อมูล @endif</option> 
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="float-right">
                                            <button id="btn_product_add" type="button" class="btn btn-outline-success" onclick="addProductToArray('{{ \Session::get('locale') }}');">{{ __('login.page.promotion.display.btn_add') }}</button>
                                        </div>
                                    </div>
                                    <div class="col-6 mx-auto border border-dark" style="padding: 2%;">
                                        @foreach($get_uom as $key => $items)
                                        <div id="dynamicField[{{$key}}]">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="hidden" name="prodCode[]" id="prodCode" value="{{ $items['data']->ProductCode }}">                                                    
                                                    <input type="text" class="form-control" value="{{ $items['data']->prodTName }}" disabled>
                                                </div>
                                                <div class="col">
                                                    <select name="uomCode[]" class="form-control" id="uomCode" required>
                                                        @foreach ($items['uom'] as $item)
                                                            <option value="{{ $item->uomCode }}" class="form-control" @if($item->uomCode == $items['data']->ProductUnitCode) selected @endif>{{ $item->uomName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="form-control remove-th btn btn-outline-danger" onClick="removeInputMain({{$key}});">@if(\Session::get('locale') != 'th') remove @else ลบ @endif</button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div id="dynamicFieldEdit[0]">                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <hr>
                            
                            <div class="float-left">
                                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('login.page.products.display.close') }}</button> -->
                                <input type="hidden" name="del_prod" id="del_prod" value="">
                                <button type="submit" class="btn btn-outline-info">{{ __('login.page.promotion.display.update') }}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/editPromotionGroup.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    

    @endsection
