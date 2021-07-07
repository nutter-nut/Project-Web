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
                <li class="breadcrumb-item">{{ __('login.page.promotion.display.promotion') }}</li>
                <li class="breadcrumb-item active"><a href="{{ route('adminPromotion') }}">{{ __('login.page.promotion.display.promotion_group') }}</a></li>
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>
        
        <div class="modal" id="product_insert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form action="{{ route('promotionGroupInsert') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                    
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('login.page.promotion.display.create_promotion_group') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <p aria-hidden="true">&times;</p>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div style="padding:20px">                            
                                <div class="form-group row">
                                    <label for="pgpCode" class="col-sm-2 col-form-label">* {{ __('login.page.promotion.display.code') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pgpCode" id="pgpCode" placeholder="" pattern="[a-zA-Z0-9-]+" required>
                                        <small class="text-danger">
                                            {{ __('login.index.form.text_pattern') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pgpName" class="col-sm-2 col-form-label">* {{ __('login.page.promotion.display.promotion_group_name') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pgpName" id="pgpName" placeholder="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pgpRemark" class="col-sm-2 col-form-label">{{ __('login.page.promotion.display.remark') }}</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="pgpRemark" name="pgpRemark" rows="3"></textarea>
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
                                                <select name="product[]" class="form-control" id="subSectorSelect" >
                                                    @if(count($get_product) > 0)
                                                        @foreach ($get_product as $item)
                                                            <option value="{{ $item->prodCode }}, {{ $item->prodUnit1UOMCode }}, {{ $item->prodTName}}" class="form-control">{{ $item->prodCode }}-{{ $item->prodTName }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="" class="form-control">@if(\Session::get('locale') != 'th') No data found @else ไม่พบข้อมูล @endif</option> 
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="float-right">
                                        @if(count($get_product) > 0)
                                            <button id="btn_product_add" type="button" class="btn btn-outline-success" onclick="addProductToArray('{{ \Session::get('locale') }}')">{{ __('login.page.promotion.display.btn_add') }}</button>
                                        @else
                                            <button id="btn_product_add" type="button" class="btn btn-outline-success" onclick="addProductToArray('{{ \Session::get('locale') }}')" style="display:none;">{{ __('login.page.promotion.display.btn_add') }}</button>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-6 mx-auto border border-dark" style="padding: 2%;">                                 
                                        <div id="dynamicField[0]">
                                            
                                        </div>                                                           
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
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
                                    <th scope="col">{{ __('login.page.promotion.display.code') }}</th>
                                    <th scope="col">{{ __('login.page.promotion.display.promotion_group_name') }}</th>
                                    <th scope="col">{{ __('login.page.promotion.display.products_list') }}</th>
                                    <th scope="col">{{ __('login.page.promotion.display.remark') }}</th>
                                    <th scope="col">{{ __('login.page.promotion.display.a_date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($promotion_group as $item)
                                <tr>
                                    <td>{{ $item['data']->PGPId }}</td>
                                    <td>{{ $item['data']->PGPCode }}</td>
                                    <td>{{ $item['data']->PGPName }}</td>
                                    <td>
                                        <ul>
                                        @foreach($item['products'] as $item_product)  
                                            <li>{{ $item_product }}</li>
                                        @endforeach 
                                        </ul>
                                    </td>
                                    <td>{{ $item['data']->PGPRemark }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['data']->CreateOn)->isoFormat('Do MMM YYYYTH:m:s')}}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a href="{{ route('promotionGroupEdit', [ 'id' => $item['data']->PGPId ]) }}" class="btn btn-sm btn-outline-warning"> <i class="fa fa-edit"></i> {{ __('login.page.products.display.edit') }}</a>
                                            <a href="{{ route('promotionGroupDelete', [ 'id' => $item['data']->PGPId ]) }}" onclick="@if(\Session::get('locale') != 'th') return confirm('Are you sure?') @else return confirm('คุณแน่ใจที่จะลบ') @endif" class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> {{ __('login.page.products.display.delete') }}</a>
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

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/displayPromotionGroup.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    @endsection
