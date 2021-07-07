@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.products.display.set_products') }}</h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item">{{ __('login.page.products.display.set_products') }}</li>
                <li class="breadcrumb-item"><a href="{{ route('adminProduct') }}">{{ __('login.page.products.display.product') }}</a></li>
                <li class="breadcrumb-item active">{{ __('login.page.products.display.create') }}</li>
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
                        <form action="{{ route('productInsert') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                        {{csrf_field()}}

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="product_data-tab" data-toggle="tab" href="#product_data" role="tab" aria-controls="product_data" aria-selected="true">{{ __('login.page.products.display.product_data') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="table_data-tab" data-toggle="tab" href="#table_data" role="tab" aria-controls="table_data" aria-selected="false">{{ __('login.page.products.display.table_data') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="product_data" role="tabpanel" aria-labelledby="product_data-tab">

                                    <div class="pt-4" style="padding:20px">     
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group row">
                                                    <label for="prodCode" class="col-sm-2 col-form-label">* {{ __('login.page.products.display.code') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="prodCode" id="prodCode" placeholder="" pattern="[a-zA-Z0-9-]+" required>
                                                        <small class="text-danger">
                                                            {{ __('login.index.form.text_pattern') }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="prodTName" class="col-sm-2 col-form-label">* {{ __('login.page.products.display.product_name') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="prodTName" id="prodTName" placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="prodDetail" class="col-sm-2 col-form-label">{{ __('login.page.products.display.detail') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="mytextarea" class="form-control" id="prodDetail" name="prodDetail" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row-image">
                                                    <div id="myImg" class="column-image"></div>
                                                </div> 
                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <input 
                                                            id="image_file" 
                                                            name="image[]" 
                                                            type="file"
                                                            multiple="multiple"
                                                            class="form-control form-control-line file_name"
                                                            onclick="checkFile()"
                                                            placeholder="image"
                                                            accept="image/x-png,image/gif,image/jpeg" 
                                                            required
                                                        />
                                                        <small class="text-danger">
                                                            {{ __('login.index.form.image_pattern') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mx-auto border border-dark" style="padding: 4%;">
                                                <div class="form-group row">                       
                                                    <label for="" class="col-sm-2 col-form-label">* {{ __('login.page.products.display.tax') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="prodIsVat" id="prodIsVat1" value="I" required>
                                                            <label class="form-check-label" for="prodIsVat1">{{ __('login.page.products.display.total_tax') }} (I)</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="prodIsVat" id="prodIsVat2" value="Y" required>
                                                            <label class="form-check-label" for="prodIsVat2">{{ __('login.page.products.display.taxable') }} (Y)</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="prodIsVat" id="prodIsVat3" value="N" required>
                                                            <label class="form-check-label" for="prodIsVat3">{{ __('login.page.products.display.no_tax') }} (N)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">{{ __('login.page.products.display.more') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="ProdAllowMinus" id="ProdAllowMinus" value="Y" checked>
                                                            <label class="form-check-label" for="ProdAllowMinus">{{ __('login.page.products.display.product_can_be_negative') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">{{ __('login.page.products.display.best_seller') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="best_seller" id="best_seller" value="1">
                                                            <label class="form-check-label" for="best_seller"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">{{ __('login.page.products.display.stock') }}/<br>{{ __('login.page.products.display.service') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="PlaceOrder" id="PlaceOrder" value="Y">
                                                            <label class="form-check-label" for="PlaceOrder">{{ __('login.page.products.display.have_stock') }}</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="PlaceOrder" id="PlaceOrder" value="N">
                                                            <label class="form-check-label" for="asdf">{{ __('login.page.products.display.service_type') }}</label>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group row">
                                                    <label for="prodGroupCode" class="col-sm-3 col-form-label">* {{ __('login.page.products.display.product_group') }}</label>
                                                    <div class="col-sm-9">
                                                        <select name="prodGroupCode" class="form-control" id="prodGroupCode" required>
                                                            <option value="" class="form-control">--{{ __('login.page.products.display.product_group') }}--</option>
                                                            @foreach ($product_group as $item)
                                                                <option value="{{ $item->prodGroupCode }}" class="form-control">{{ $item->prodGroupName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="ProdTypeCode" class="col-sm-3 col-form-label">{{ __('login.page.products.display.product_type') }}</label>
                                                    <div class="col-sm-9">
                                                        <select name="ProdTypeCode" class="form-control" id="ProdTypeCode">
                                                            <option value="" class="form-control">--{{ __('login.page.products.display.product_type') }}--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="prodBrandCode" class="col-sm-3 col-form-label">{{ __('login.page.products.display.brand_p') }}</label>
                                                    <div class="col-sm-9">
                                                        <select name="prodBrandCode" class="form-control" id="prodBrandCode">
                                                            <option value="" class="form-control">--{{ __('login.page.products.display.brand_p') }}--</option>
                                                            @foreach ($get_brand as $item)
                                                                <option value="{{ $item->prodBrandCode }}" class="form-control">{{ $item->prodBrandName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="ProdModelCode" class="col-sm-3 col-form-label">{{ __('login.page.products.display.product_model') }}</label>
                                                    <div class="col-sm-9">
                                                        <select name="ProdModelCode" class="form-control" id="ProdModelCode">
                                                            <option value="" class="form-control">--{{ __('login.page.products.display.product_no_model') }}--</option>
                                                            @foreach ($get_model as $item)
                                                                <option value="{{ $item->ProdModelCode }}" class="form-control">{{ $item->ProdModelName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group row">
                                                    <label for="productCalcType" class="col-sm-3 col-form-label">{{ __('login.page.products.display.cost') }}</label>
                                                    <div class="col-sm-9">
                                                        <select name="productCalcType" class="form-control" id="productCalcType" required>
                                                            <option value="" class="form-control">{{ __('login.page.products.display.choose_cost') }}</option>
                                                            <option value="AVG" class="form-control">{{ __('login.page.products.display.avg_cost') }}</option>
                                                            <option value="FIFO" class="form-control">{{ __('login.page.products.display.fifo_cost') }}</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>                                
                                        
                                        <hr>
                                        <div id="dynamicField[0]">
                                            <div class="row" >
                                                <div class="col">
                                                    <label for="uomCode" class="col-form-label">{{ __('login.page.products.display.unit_count') }}</label>
                                                    <select name="uomCode[]" class="form-control" id="uomCode" required>
                                                        @foreach ($get_uom as $item)
                                                            <option value="{{ $item->uomCode }}" class="form-control">{{ $item->uomName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="prodUnitRatio" class="col-form-label">* {{ __('login.page.products.display.number_of_pieces') }}</label>
                                                    <input type="number" class="form-control" name="prodUnitRatio[]" id="prodUnitRatio" min="1" max="999" placeholder="" required>
                                                </div>
                                                <div class="col">
                                                    <label for="prodUnitPrice" class="col-form-label">* {{ __('login.page.products.display.price') }} ({{ __('login.page.products.display.baht') }})</label>
                                                    <input type="number" class="form-control" name="prodUnitPrice[]" id="prodUnitPrice" min="1" max="999999" placeholder="" required>
                                                </div>                                        
                                                <div class="col">
                                                    <label class="col-form-label">{{ __('login.page.products.display.add_a_new_receiver') }}</label>
                                                    <button type="button" class="col-form-label form-control btn btn-outline-success" onClick="addInput('{{ \Session::get('locale') }}');" >{{ __('login.page.products.display.add') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="table_data" role="tabpanel" aria-labelledby="table_data-tab">

                                    <div class="row justify-content-md-center pt-4">
                                        <div class="form-group">
                                            <div class="input-group mb-1">
                                                <input id="add_header" type="text" class="form-control" placeholder="@if(\Session::get('locale') != 'th') Column (Do not have '.' ) @else คอลัมน์ห้ามใส่ '.' @endif" aria-label="Header" aria-describedby="button-addon2">
                                                <div class="input-group-append">
                                                    <button onclick="addHeader()" class="btn btn-outline-success" type="button">@if(\Session::get('locale') != 'th') add column @else เพิ่มคอลัมน์ @endif</button>
                                                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <button onclick="Add()" type="button" name="add" id="add" class="btn btn-outline-success">@if(\Session::get('locale') != 'th') add row @else เพิ่มแถว @endif</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding:20px">
                                        <div class="col-12">
                                            <table class="table table-bordered" id="dynamicTable">
                                                <thead>
                                                    <tr id="dynamicTable_h"></tr>
                                                </thead>
                                                <input type="hidden" id="data_table_type" name="data_table_type" value="1">
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <hr>
                            <div class="float-left">
                                <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                                <button type="submit" class="btn btn-outline-info">{{ __('login.page.products.display.save') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/addmore.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/createProduct.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    <script type="text/javascript">

    var counter = 1;
    var local = document.getElementById("local");

    function addInput(local) {
        var newdiv = document.createElement('div');

        if(local != 'th') var text = 'remove';
        else var text = 'ลบ';

        newdiv.id = "dynamicInput["+counter+"]";

        newdiv.innerHTML = "<div class='row pt-3'><div class='col'><select name='uomCode["+counter+"]' class='form-control' id='uomCode' required>@foreach ($get_uom as $item)<option value='{{ $item->uomCode }}' class='form-control'>{{ $item->uomName }}</option>@endforeach</select></div><div class='col'><input type='number' class='form-control' name='prodUnitRatio["+counter+"]' id='prodUnitRatio' placeholder='' min='1' max='999' required></div><div class='col'><input type='number' class='form-control' name='prodUnitPrice["+counter+"]' id='prodUnitPrice' placeholder='' min='1' max='999' required></div><div class='col'><button type='button' class='form-control remove-th btn btn-outline-danger' onClick='removeInput("+counter+");'>"+ text +"</button></div></div>"
        document.getElementById('dynamicField[0]').appendChild(newdiv);

        counter++;
    }

    </script>

    @include('layouts.textarea')

    @endsection
