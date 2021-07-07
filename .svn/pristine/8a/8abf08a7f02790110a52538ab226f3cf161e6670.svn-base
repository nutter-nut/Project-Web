@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.products.display.set_products') }}</h3>
            </div>
            <!-- <div class="col-md-7 align-self-center">
                <button type="button" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down" data-toggle="modal" data-target="#product_insert" >สร้าง</button>
            </div> -->
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item">{{ __('login.page.products.display.set_products') }}</li>
                <li class="breadcrumb-item"><a href="{{ route('adminProduct') }}">{{ __('login.page.products.display.product') }}</a></li>
                <li class="breadcrumb-item">{{ __('login.page.products.display.edit_product') }}</li>
                <li class="breadcrumb-item active">{{ $data_edit->prodCode }}</li>
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
                        <form action="{{ route('productUpdate', [ 'prodCode' => $data_edit->prodCode ]) }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                        {{csrf_field()}}                    
                            <input type="hidden" name="addImage" value="0" />
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
                                                        <input type="hidden" class="form-control" name="prodCode" id="prodCode" value="{{ $data_edit->prodCode }}">
                                                        <input type="text" class="form-control" name="prodCode" id="prodCode" value="{{ $data_edit->prodCode }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="prodTName" class="col-sm-2 col-form-label">* {{ __('login.page.products.display.product_name') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="prodTName" id="prodTName" placeholder="" value="{{ $data_edit->prodTName }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="prodDetail" class="col-sm-2 col-form-label">{{ __('login.page.products.display.detail') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="mytextarea" class="form-control" id="prodDetail" name="prodDetail" rows="3">{{ $data_edit->ProdDetail }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <center class=""> 
                                                    @if ($image['file_name'] != null)
                                                        <img id="blah" src="{{ $image['url'] }}" class="img-circle img-fluid" width="350" height="auto" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"/> 
                                                    @else
                                                        <img id="blah" src="{{ asset('storage') }}/product_images/product_default.png" class="img-circle img-fluid" width="180" height="180" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"/> 
                                                    @endif                                      
                                                </center>
                                                <!-- <br>
                                                <div class="col-sm-12">
                                                    <input id="image_file" name="image" type="file" class="form-control form-control-line file_name"
                                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                                                        accept="image/x-png,image/gif,image/jpeg" />
                                                    <small class="text-danger">
                                                        {{ __('login.index.form.image_pattern') }}
                                                    </small>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mx-auto border border-dark" style="padding: 4%;">
                                                <div class="form-group row">                       
                                                    <label for="" class="col-sm-2 col-form-label">* {{ __('login.page.products.display.tax') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="prodIsVat" id="prodIsVat1" value="I" @if($data_edit->prodIsVat == "I") checked="checked" @endif required>
                                                            <label class="form-check-label" for="prodIsVat1">{{ __('login.page.products.display.total_tax') }} (I)</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="prodIsVat" id="prodIsVat2" value="Y" @if($data_edit->prodIsVat == "Y") checked="checked" @endif required>
                                                            <label class="form-check-label" for="prodIsVat2">{{ __('login.page.products.display.taxable') }} (Y)</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="prodIsVat" id="prodIsVat3" value="N" @if($data_edit->prodIsVat == "N") checked="checked" @endif required>
                                                            <label class="form-check-label" for="prodIsVat3">{{ __('login.page.products.display.no_tax') }} (N)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">{{ __('login.page.products.display.more') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="ProdAllowMinus" id="ProdAllowMinus" value="Y" @if($data_edit->ProdAllowMinus == "Y") checked="checked" @endif>
                                                            <label class="form-check-label" for="ProdAllowMinus">{{ __('login.page.products.display.product_can_be_negative') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">{{ __('login.page.products.display.best_seller') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="best_seller" id="best_seller" value="1" @if($best_seller == 1) checked="checked" @endif>
                                                            <label class="form-check-label" for="best_seller"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">{{ __('login.page.products.display.stock') }}/<br>{{ __('login.page.products.display.service') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="PlaceOrder" id="PlaceOrder" value="Y" @if($data_edit->PlaceOrder == "Y") checked="checked" @endif>
                                                            <label class="form-check-label" for="PlaceOrder">{{ __('login.page.products.display.have_stock') }}</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="PlaceOrder" id="PlaceOrder" value="N" @if($data_edit->PlaceOrder == "N") checked="checked" @endif>
                                                            <label class="form-check-label" for="asdf">{{ __('login.page.products.display.service_type') }}</label>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group row">
                                                    <label for="prodGroupName" class="col-sm-3 col-form-label">* {{ __('login.page.products.display.product_group') }}</label>
                                                    <div class="col-sm-9">
                                                        <select name="prodGroupName" class="form-control" id="prodGroupName" required>
                                                            <option value="" class="form-control">--{{ __('login.page.products.display.product_group') }}--</option>
                                                            @foreach ($product_group as $item)
                                                                <option value="{{ $item->prodGroupCode }}" class="form-control" @if($get_detail_group['prodGroupCode'] == $item->prodGroupCode) selected @endif>{{ $item->prodGroupName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="ProdTypeCode" class="col-sm-3 col-form-label">{{ __('login.page.products.display.product_type') }}</label>
                                                    <div class="col-sm-9">
                                                        <select name="ProdTypeCode" class="form-control" id="ProdTypeCode">
                                                            <option value="" class="form-control">--{{ __('login.page.products.display.product_type') }}--</option>
                                                            @foreach ($get_type as $item)
                                                                <option value="{{ $item->ProdTypeCode }}" class="form-control" @if($get_detail_group['ProdTypeCode'] == $item->ProdTypeCode) selected @endif>{{ $item->ProdTypeName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="prodBrandCode" class="col-sm-3 col-form-label">{{ __('login.page.products.display.brand_p') }}</label>
                                                    <div class="col-sm-9">
                                                        <select name="prodBrandCode" class="form-control" id="prodBrandCode">
                                                            <option value="" class="form-control">--{{ __('login.page.products.display.brand_p') }}--</option>
                                                            @foreach ($get_brand as $item)
                                                                <option value="{{ $item->prodBrandCode }}" class="form-control" @if($get_detail_group['ProdBrandCode'] == $item->prodBrandCode) selected @endif>{{ $item->prodBrandName }}</option>
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
                                                                <option value="{{ $item->ProdModelCode }}" class="form-control" @if($get_detail_group['ProdModelCode'] == $item->ProdModelCode) selected @endif>{{ $item->ProdModelName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group row">
                                                    <label for="productCalcType" class="col-sm-3 col-form-label">{{ __('login.page.products.display.cost') }}</label>
                                                    <div class="col-sm-9">
                                                        <select name="productCalcType" class="form-control" id="productCalcType" required>
                                                            <option value="" class="form-control" @if($data_edit->productCalcType == '') selected @endif>{{ __('login.page.products.display.choose_cost') }}</option>
                                                            <option value="AVG" class="form-control" @if($data_edit->productCalcType == 'AVG') selected @endif>{{ __('login.page.products.display.avg_cost') }}</option>
                                                            <option value="FIFO" class="form-control" @if($data_edit->productCalcType == 'FIFO') selected @endif>{{ __('login.page.products.display.fifo_cost') }}</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>                                
                                        <hr>
                                        @foreach ($all_data_edit as $key => $items)
                                        <div id="dynamicField[{{ $key }}]">
                                            <div class="row pt-3">
                                                <div class="col">
                                                    @if($key == '0')
                                                        <label for="uomCode" class="col-form-label">{{ __('login.page.products.display.unit_count') }}</label>
                                                    @endif
                                                    <select name="uomCode[]" class="form-control" id="uomCode" required>
                                                        @foreach ($get_uom as $item)
                                                            <option value="{{ $item->uomCode }}" class="form-control" @if($items->uomCode == $item->uomCode) selected @endif>{{ $item->uomName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    @if($key == '0')
                                                        <label for="prodUnitRatio" class="col-form-label">* {{ __('login.page.products.display.number_of_pieces') }}</label>
                                                    @endif
                                                    <input type="number" class="form-control" name="prodUnitRatio[]" id="prodUnitRatio" placeholder="" min="1" max="999" value="{{ (int) $items->prodUnitRatio }}" required>
                                                </div>
                                                <div class="col">
                                                    @if($key == '0')
                                                        <label for="prodUnitPrice" class="col-form-label">* {{ __('login.page.products.display.price') }} ({{ __('login.page.products.display.baht') }})</label>
                                                    @endif
                                                    <input type="number" class="form-control" name="prodUnitPrice[]" id="prodUnitPrice" placeholder="" min="1" max="999999" value="{{ (int) $items->prodUnitPrice }}" required>
                                                </div>                                            
                                                <div class="col">
                                                    @if($key == '0')
                                                        <label class="col-form-label">{{ __('login.page.products.display.add_a_new_receiver') }}</label>
                                                    @endif
                                                    @if ($key == 0)
                                                    <button type="button" class="col-form-label form-control btn btn-outline-success" onClick="addInput('{{ \Session::get('locale') }}');" >{{ __('login.page.products.display.add') }}</button>
                                                    @else
                                                    <button type="button" class="col-form-label form-control btn btn-outline-danger" onClick="removeInputMain({{$key}});" >{{ __('login.page.products.display.remove') }}</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach                                    
                                        <div id="dynamicFieldEdit[0]"></div>
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
                                    @if($details != null) 
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered" id="dynamicTable">
                                                <thead>
                                                    <tr id="dynamicTable_h">
                                                    @php $heads = []; $i = 1; @endphp
                                                    @foreach ($details[0] as $key => $items)
                                                        @php array_push($heads, $key); @endphp
                                                        <th scope="col"><strong>{{ $key }}</strong><button type="button" id="{{ $i }}" class="btn btn-danger remove-th float-right">@if(\Session::get('locale') != 'th') Remove @else ลบ @endif</button></th>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                    <input type="hidden" id="head_edit" name="head_edit" value="{{ json_encode($heads) }}">
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php $body = []; @endphp
                                                @foreach ($details as $key => $items)
                                                    @php array_push($body, $items); @endphp
                                                    <tr id="body_{{ $key + 1 }}">
                                                    @foreach ($items as $index => $item)
                                                        <td id="addmore[{{ $key+1 }}][{{ $index }}]">                                               
                                                            <input type="text" class="form-control" name="addmore[{{$key+1}}][{{$index}}]" placeholder="@if(\Session::get('locale') != 'th') Enter @else กรอก @endif {{$index}}" value="{{$item}}">                                             
                                                        </td>
                                                    @endforeach 
                                                    </tr>
                                                @endforeach
                                                <input type="hidden" id="body_edit" name="body_edit" value="{{ json_encode($body) }}">
                                                <input type="hidden" id="num_row_edit" name="num_row_edit" value="{{ $key + 1 }}">
                                                <input type="hidden" id="data_table_type" name="data_table_type" value="0">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row" style="padding:20px">
                                        <div class="col-12">
                                            <table class="table table-bordered" id="dynamicTable">
                                                <thead>
                                                    <tr id="dynamicTable_h"></tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="float-left">
                                <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                                <button type="submit" class="btn btn-outline-info">{{ __('login.page.products.display.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/addmore.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    <!-- <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/editProduct.js') }}"></script> -->
    
    <script type="text/javascript">
    var counter = 1;
    var local = document.getElementById("local");

    var text_sure_en = 'Are you sure?';
    var text_del_en = 'remove';
    var text_no_data_en = 'No data found';

    var text_sure_th = 'คุณแน่ใจที่จะลบ';
    var text_del_th = 'ลบ';
    var text_no_data_th = 'ไม่พบข้อมูล';

    if(local.value != 'th'){
        var text_sure = text_sure_en;
        var text_del = text_del_en;
        var text_no_data = text_no_data_en;
    }else{
        var text_sure = text_sure_th;
        var text_del = text_del_th;
        var text_no_data = text_no_data_th;
    }

    function addInput(local) {
        var newdiv = document.createElement('div');

        newdiv.id = "dynamicInput["+counter+"]";

        newdiv.innerHTML = "<div id='dynamicField["+counter+"]'><div class='row pt-3'><div class='col'><select name='uomCode[]' class='form-control' id='uomCode' required>@foreach ($get_uom as $item)<option value='{{ $item->uomCode }}' class='form-control'>{{ $item->uomName }}</option>@endforeach</select></div><div class='col'><input type='number' class='form-control' name='prodUnitRatio[]' id='prodUnitRatio' placeholder='' required></div><div class='col'><input type='number' class='form-control' name='prodUnitPrice[]' id='prodUnitPrice' placeholder='' required></div><div class='col'><button type='button' class='form-control remove-th btn btn-outline-danger' onClick='removeInput("+counter+");'>"+ text_del +"</button></div></div></div>"
        document.getElementById('dynamicFieldEdit[0]').appendChild(newdiv);

        counter++;
    }

    function removeInputMain(id){
        var result = confirm(text_sure);
        if (result) {
            document.getElementById("dynamicField["+id+"]").remove();
        }
    } 

    function removeInput(id){
        var id = "dynamicInput["+id+"]";
        var elem = document.getElementById(id);
        return elem.parentNode.removeChild(elem);
    } 

    $('#prodGroupName').change(function () {
        var id = $(this).val();
        var url = window.location.origin;
        $.ajax({
            url: url + "/admin/product/get_product_type/" + id,
            dataType: "json",
            success: function (data) {
                $('#ProdTypeCode').empty();
                if(data.length > 0){
                    $.each(data, function (key, value) {
                        $('#ProdTypeCode').append('<option value="' + value.ProdTypeCode + '" class="form-control">' + value.ProdTypeName + '</option>');
                    });
                }else{
                    $('#ProdTypeCode').append('<option value="" class="form-control">'+ text_no_data +'</option>');
                }  
            }
        });
    });

    </script>

    @include('layouts.textarea')

    @endsection
