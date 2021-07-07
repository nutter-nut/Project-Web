@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.menu_group.display.set_products') }}</h3>
            </div>
        </div>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item">{{ __('login.page.menu_group.display.set_products') }}</li>
                <li class="breadcrumb-item active"><a href="{{ route('adminProductMenuGroup') }}">{{ __('login.page.menu_group.display.menu_group') }}</a></li>
                @if($data['get_data_edit'] != null)
                <li class="breadcrumb-item active"><a href="{{ route('productMenuGroupEdit', [ 'id' => $data['get_data_edit']->PMenuId ]) }}">{{ $data['get_data_edit']->PMenuGroupName }}</a></li>
                @endif
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>

        <!-- Add product end -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">รูป</th>
                                        <th scope="col">ชื่อ</th>
                                        <th scope="col">ประเภท</th>
                                        <th scope="col">ระดับชั้น</th>
                                        <th scope="col">จำนวนสินค้าที่มี</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['get_menugroup'] as $key => $item)
                                        <tr @if($data['get_data_edit'] != null && $data['get_data_edit']->PMenuId == $item->PMenuId) style="background-color: cornsilk;" @endif>
                                            <td>
                                                <img class="profileimg2" src="{{ $item->image['url'] }}" @if(in_array($item->count, [3, 4])) style="display: none;" @else style="width: 40px;height: auto;" @endif>
                                                <p style="display: none;">{{ $item->PMenuGroupCode }}</p>
                                            </td>
                                            <td>
                                                @php 
                                                $text_arr = "";
                                                if($item->count != 1) for($i=1; $i < $item->count; $i++) $text_arr .= "|___";
                                                @endphp 
                                                {{ $text_arr }}{{ $item->PMenuGroupName }}
                                            </td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->count }}</td>
                                            <td>@if($item->count_product != 0) {{ $item->count_product }} @endif</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                    <a href="{{ route('productMenuGroupEdit', [ 'id' => $item->PMenuId ]) }}" class="btn btn-sm btn-outline-warning"> <i class="fa fa-edit"></i> {{ __('login.page.menu_group.display.edit') }}</a>
                                                    <a href="{{ route('productMenuGroupDelete', [ 'pmId' => $item->PMenuId ]) }}" onclick="@if(\Session::get('locale') != 'th') return confirm('Are you sure?') @else return confirm('คุณแน่ใจที่จะลบ') @endif" class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> {{ __('login.page.menu_group.display.delete') }}</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        @if($data['get_data_edit'] != null)
                            <form action="{{ route('productMenuGroupUpdate', [ 'pmId' => $data['get_data_edit']->PMenuId, 'pmCode' => $data['get_data_edit']->PMenuGroupCode ]) }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" class="form-control" name="PMenuGroupPicThumnail" id="PMenuGroupPicThumnail" value="{{ $data['get_data_edit']->PMenuGroupPicThumnail }}">
                                <input type="hidden" class="form-control" name="PMenuGroupParent" id="PMenuGroupParent" value="{{ $data['get_data_edit']->PMenuGroupParent }}">
                                <input type="hidden" class="form-control" name="PMenuGroupCode" id="PMenuGroupCode" value="{{ $data['get_data_edit']->PMenuGroupCode }}">
                                <input type="hidden" class="form-control" name="type" id="type" value="edit">
                                <input type="hidden" class="form-control" name="countRow" id="countRow" value="{{ $data['get_data_edit']->countRow }}">
                                <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="{{ $data['get_data_edit']->keyRow }}">
                                <div class="form-group">
                                    <label for="prodMenuGroupName">* ชื่อเมนูขาย</label>
                                    <input type="text" class="form-control" name="prodMenuGroupName" id="prodMenuGroupName" placeholder="" value="{{ $data['get_data_edit']->PMenuGroupName }}" required>
                                </div>
                                @if($data['get_data_edit']->count != 4 && $data['get_data_edit']->hasSubMenu != 1)
                                <div class="form-group">
                                    <input type="checkbox" class="form-check-input" name="new_code_cate" id="new_code_cate" onclick="checkBoxReName()">
                                    <label class="form-check-label" for="new_code_cate">เพิ่มกลุ่มเมนูขายย่อย</label><br>
                                    <small class="text-danger">
                                        * เพิ่มเมนูย่อยใน {{ $data['get_data_edit']->PMenuGroupName }}
                                    </small>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="prodMenuGroupType">* ประเภทของเมนู</label>
                                    <select name="prodMenuGroupType" class="form-control" id="prodMenuGroupType" disabled>
                                        @foreach($data['get_filter'] as $item)
                                            <option value="{{ $item->PMenuGroupCode }}" class="form-control" @if($data['get_data_edit']->PMenuGroupCode == $item->PMenuGroupCode) selected @endif>{{ $item->PMenuGroupName }}</option>
                                            <!-- <option value="{{ $item->PMenuGroupCode }}" class="form-control" @if($data['get_data_edit']->PMenuGroupCode == $item->PMenuGroupCode) selected @endif>{{ $item->PMenuGroupCode }} [ {{ $item->PMenuGroupName }} ]</option> -->
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" @if(in_array($data['get_data_edit']->count, [3,4])) style="display: none;" @else style="display" @endif>
                                    <label for="prodMenuGroupImage">* รูป</label>
                                    <div class="pb-5">
                                        <center>
                                            <img id="blah" src="{{ $data['get_data_edit']->image['url'] }}" class="img-circle img-fluid" style="width:150px;height:150px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" />
                                        </center>
                                    </div>
                                    <input 
                                        id="image_file" 
                                        name="image" 
                                        type="file" 
                                        class="form-control form-control-line"
                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                                        accept="image/x-png,image/gif,image/jpeg" 
                                    />
                                    <small class="text-danger">
                                        {{ __('login.index.form.image_pattern') }}
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label for="prodMenuGroupDescription">รายละเอียด</label>
                                    <textarea class="form-control" name="prodMenuGroupDescription" id="prodMenuGroupDescription" rows="3"></textarea>
                                </div>
                                <hr>
                                <div class="float-left">
                                    <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.menu_group.display.save') }}</button>
                                    <a class="btn btn-outline-danger" href="{{ route('adminProductMenuGroup') }}" role="button">{{ __('login.page.menu_group.display.cancel') }}</a>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('productMenuGroupInsert') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" class="form-control" name="type" id="type" value="insert">
                                <input type="hidden" class="form-control" name="countRow" id="countRow" value="0">
                                <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="0">
                                <div id="form_menuname" class="form-group">
                                    <label for="prodMenuGroupName">* ชื่อเมนูขาย</label>
                                    <input type="text" class="form-control" name="prodMenuGroupName" id="prodMenuGroupName" placeholder="" required>                              
                                </div>
                                <div id="form_menuname_muti" style="display:none;">
                                    <div class="form-group">
                                        <label for="prodMenuGroupName">* ชื่อเมนูขาย</label>
                                        <input type="text" class="form-control" name="prodMenuGroupName1" id="prodMenuGroupName1" placeholder="ชั้นที่ 1" >
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="prodMenuGroupName2" id="prodMenuGroupName2" placeholder="ชั้นที่ 2" >
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="prodMenuGroupName3" id="prodMenuGroupName3" placeholder="ชั้นที่ 3" >
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="prodMenuGroupName4" id="prodMenuGroupName4" placeholder="ชั้นที่ 4" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" class="form-check-input" name="new_categorie" id="new_categorie" onclick="checkBox()">
                                    <label class="form-check-label" for="new_categorie">เพิ่มกลุ่มเมนูขายใหม่</label>
                                </div>
                                <div class="form-group">
                                    <label for="prodMenuGroupType">* ประเภทของเมนู</label>
                                    <select name="prodMenuGroupType" class="form-control" id="prodMenuGroupType" onchange="changeMenuGroup(this.value);">
                                        @foreach($data['get_filter'] as $item)
                                            @php 
                                            $text_arr = "";
                                            if($item->count != 1) for($i=1; $i < $item->count; $i++) $text_arr .= "|___";
                                            @endphp 
                                            <option value="{{ $item->PMenuGroupCode }}" class="form-control">{{ $text_arr }}{{ $item->PMenuGroupName }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">
                                        * เพิ่มกลุ่มเมนูขายต่อจากข้อมูลที่เลือก
                                    </small>
                                </div>
                                <div class="form-group" id="form_image">
                                    <label for="prodMenuGroupImage">* รูป</label>
                                    <div class="pb-5">
                                        <center>
                                            <img id="blah" src="{{ asset('storage') }}/product_images/product_default.png" class="img-circle img-fluid" style="width:150px;height:150px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" />
                                        </center>
                                    </div>
                                    <input 
                                        id="image_file" 
                                        name="image" 
                                        type="file" 
                                        class="form-control form-control-line"
                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                                        accept="image/x-png,image/gif,image/jpeg" 
                                    />
                                    <small class="text-danger">
                                        {{ __('login.index.form.image_pattern') }}
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label for="prodMenuGroupDescription">รายละเอียด</label>
                                    <textarea class="form-control" name="prodMenuGroupDescription" id="prodMenuGroupDescription" rows="3"></textarea>
                                </div>
                                <hr>
                                <div class="float-left">
                                    <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.menu_group.display.save') }}</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
                @if($data['get_data_edit'] != null && in_array($data['get_data_edit']->count, [1, 4]))
                <div class="card">
                     <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        เพิ่มสินค้าลงเมนูขาย
                        <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#product_insert_menugroup" onclick="addProduct('{{ $data['get_data_edit']->PMenuGroupCode }}')">เพิ่ม</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id2" class="table table-striped table-hover"></table>
                        </div>
                        <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                    </div>
                </div>
                @endif
            </div>
            
        </div>

        <div class="modal" id="product_insert_menugroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form id="insert_form" action="" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">เพิ่มสินค้าลงเมนูขาย</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <p aria-hidden="true">&times;</p>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="table_id3" class="table table-striped table-hover"></table>
                            </div>
                            <!-- <div class="row">
                                <div class="col-">
                                    <div class="table-responsive">
                                        <table id="table_id3" class="table table-striped table-hover"></table>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table id="table_id2" class="table table-striped table-hover"></table>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/displayProductMenuGroup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    <script>

    window.onload = getProducts;

    var local = document.getElementById("local");
    var url = window.location.origin;

    var text_th = '//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json';
    var prodCode_th = 'รหัสสินค้า';
    var prodName_th = 'ชื่อสินค้า';
    var prodPrice_th = 'ราคา';

    var text_en = '//cdn.datatables.net/plug-ins/1.10.24/i18n/English.json';
    var prodCode_en = 'Product Code';
    var prodName_en = 'Product Name';
    var prodPrice_en = 'Product Price';

    var dataSet = []
    var dataSet_products = []

    if(local.value != 'th'){
        var text = text_en;
        var prodCode = prodCode_en;
        var prodName = prodName_en;
        var prodPrice = prodPrice_en;
    }else{
        var text = text_th;
        var prodCode = prodCode_th;
        var prodName = prodName_th;
        var prodPrice = prodPrice_th;
    }

    function addProduct(pmCode){
        getProducts(pmCode);
        getProductsAll(pmCode);
    }

    function tableProducts(){
        jQuery.noConflict();
        var table = $('#table_id3').DataTable({
            bDestroy: true,
            data: dataSet_products,
            columns: [
                { title: prodCode },
                { title: prodName },
                { title: prodPrice },
                { 
                    title: 'action',
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            var value = [row[0], row[3]];
                            data = `<button type='button' class='btn btn-sm btn-outline-success' value='`+value+`' onClick='addProductToStore(\"`+value+`\")' >เพิ่ม</button>`;
                        }
                        return data;
                    },
                },
            ],
            "language": {
                "url": text,
            }
        });
    }

    function table(){
        jQuery.noConflict();
        var table = $('#table_id2').DataTable({
            bDestroy: true,
            data: dataSet,
            columns: [
                { title: prodCode },
                { title: prodName },
                { title: prodPrice },
                { 
                    title: 'action',
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            var value = [row[0], row[3]];
                            data = `<button type='button' class='btn btn-sm btn-outline-danger' value='`+value+`' onClick='DelProductToStore(\"`+value+`\")'>ลบ</button>`;
                        }
                        return data;
                    },
                },
            ],
            "language": {
                "url": text,
            }
        });
    }

    function addProductToStore(value){
        var arr_val = value.split(",");

        jQuery.ajax({
            url: url + "/admin/product/menu/group/insert_product/" + arr_val[1] + "/" + arr_val[0],
            dataType: "json",
            success: function (data) {
                if(data == 1){
                    dataSet_products.filter(function (products, index) { if(products[0] == arr_val[0] && products[3] == arr_val[1]) dataSet_products.splice(index, 1)});
                    tableProducts();
                    getProducts(arr_val[1]);
                }
            }
        });
    }

    function DelProductToStore(value){
        var arr_val = value.split(",");

        jQuery.ajax({
            url: url + "/admin/product/menu/group/delete_product/" + arr_val[1] + "/" + arr_val[0],
            dataType: "json",
            success: function (data) {
                if(data == 1){
                    dataSet.filter(function (products, index) { if(products[0] == arr_val[0] && products[3] == arr_val[1]) dataSet.splice(index, 1) });
                    getProducts(arr_val[1]);
                    tableProducts();
                }
            }
        });
    }

    function getProductsAll(pmCode){
        jQuery.ajax({
            url: url + "/admin/product/menu/group/getProducts/" + pmCode,
            dataType: "json",
            success: function (data) {
                if(data != 0){
                    dataSet_products = [];
                    data.forEach((element, index) => {
                        dataSet_products.push([
                            element.prodCode, 
                            element.prodTName, 
                            (parseInt(element.price)).format(2),
                            pmCode
                        ]);
                    });
                    tableProducts();
                }else tableProducts();
            }
        });
        
    }

    function getProducts(pmCode = null){
        var type = document.getElementById("type").value;
        var pmCode = document.getElementById("PMenuGroupCode").value;
        if(type == 'edit'){
            jQuery.ajax({
                url: url + "/admin/product/menu/group/getProduct/" + pmCode,
                dataType: "json",
                success: function (data) {
                    if(data != 0){
                        dataSet = [];
                        data.forEach((element, index) => {
                            dataSet.push([
                                element.prodCode, 
                                element.prodTName, 
                                (parseInt(element.price)).format(2),
                                pmCode
                            ]);
                        });
                        table();
                    }else table();
                }
            });
        }
    }

    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };

    </script>

    @endsection