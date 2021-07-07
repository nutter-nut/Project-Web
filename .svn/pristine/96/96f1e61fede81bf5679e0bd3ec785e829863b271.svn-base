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
                <li class="breadcrumb-item">{{ __('login.page.products.display.edit_product_image') }}</li>
                <li class="breadcrumb-item active">{{ $data_edit->prodCode }}</li>
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>

        <!-- Add product end -->
        <div class="row">
            <div class="col-lg-8" style="margin:auto;">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">                
                            <div class="float-right">
                                <a onclick="document.getElementById('image_file').click();" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down"> {{ __('login.page.product.edit_btn_add_image') }}</a>
                                <form name="addImage" id="addImage" action="{{ route('addProductImage', [ 'prodCode' => $data_edit->prodCode ]) }}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                    <input 
                                        name="image" 
                                        id="image_file" 
                                        type="file" 
                                        accept=".jpg, .jpeg, .png" 
                                        style="display:none;"
                                        onchange="this.form.submit()"
                                    />
                                    <input type="hidden" name="addImage" value="1" />
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('login.page.product.edit_image') }}</th>
                                            <th></th>
                                            <th>{{ __('login.page.product.edit_edit') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($get_image as $key => $item)
                                        <tr>
                                            <td style="width:50px;">
                                                <img class="products-image" id="blah[{{ $key }}]" src="{{ asset('storage') }}/product_images/{{ $data_edit->prodCode }}/{{ $item }}">
                                            </td>
                                            <td>
                                                <form action="{{ route('updateProductImageDefault', [ 'prodCode' => $data_edit->prodCode, 'image' => $item ]) }}" method="GET" enctype="multipart/form-data">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="image_default" id="image_default_{{ $key }}" value="{{ $key }}" @if($image_default['file_name'] == $item) checked @endif onchange="this.form.submit()">
                                                        <label class="form-check-label" for="image_default_{{ $key }}">{{ __('login.page.products.display.default') }}</label>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                            
                                                <form action="{{ route('updateProductImage', [ 'prodCode' => $data_edit->prodCode, 'image' => $item ]) }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                                                    {{csrf_field()}}
                                                    <div class="input-group mb-3">
                                                        <input 
                                                            type="file" 
                                                            class="form-control" 
                                                            name="image" 
                                                            id="image"
                                                            onchange="document.getElementById('blah[{{ $key }}]').src = window.URL.createObjectURL(this.files[0])"
                                                            placeholder="image" value="{{ $key }}"
                                                            accept=".png, .jpg, .jpeg" 
                                                            @if($image_default['file_name'] == $item) disabled @else required @endif
                                                        />
                                                        <div class="input-group-append">
                                                            <button type="submit" name="submit" class="btn btn-outline-secondary" type="button" @if($image_default['file_name'] == $item) disabled @endif>{{ __('login.page.product.edit_btn_save') }}</button>
                                                            <a href="{{ route('deleteProductImage',['prodCode' => $data_edit->prodCode, 'image' => $item ]) }}" class="button btn btn-danger"  @if($image_default['file_name'] == $item) onclick="return false;" @else onclick="return confirm('Are you sure?')" @endif>{{ __('login.page.product.edit_btn_delete') }}</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            
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
    </div>
    
    <!-- <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/addmore.js') }}"></script> -->

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    <!-- <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/editProduct.js') }}"></script> -->

    

    @endsection
