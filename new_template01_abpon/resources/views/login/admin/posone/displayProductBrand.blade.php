@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.brand.display.set_products') }}</h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item">{{ __('login.page.brand.display.set_products') }}</li>
                <li class="breadcrumb-item active"><a href="{{ route('adminProductBrand') }}">{{ __('login.page.brand.display.brand_p') }}</a></li>
                @if($data_edit != null)
                <li class="breadcrumb-item active"><a href="{{ route('productBrandEdit', [ 'id' => $data_edit->prodBrandCode ]) }}">{{ $data_edit->prodBrandCode }}</a></li>
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
                        <table id="table_id" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('login.page.brand.display.brand_code') }}</th>
                                    <th scope="col">{{ __('login.page.brand.display.brand_name') }}</th>
                                    <th scope="col">{{ __('login.page.brand.display.remark') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product_brand as $key => $item)
                                <tr @if($data_edit != null && $data_edit->prodBrandCode == $item->prodBrandCode) style="background-color: cornsilk;" @endif>
                                    <td>{{ $item->prodBrandCode }}</td>
                                    <td>{{ $item->prodBrandName }}</td>
                                    <td>{{ $item->Remark }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a href="{{ route('productBrandEdit', [ 'id' => $item->prodBrandCode ]) }}" class="btn btn-sm btn-outline-warning"> <i class="fa fa-edit"></i> {{ __('login.page.brand.display.edit') }}</a>
                                            <a href="{{ route('productBrandDelete', [ 'id' => $item->prodBrandCode ]) }}" onclick="@if(\Session::get('locale') != 'th') return confirm('Are you sure?') @else return confirm('คุณแน่ใจที่จะลบ') @endif" class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> {{ __('login.page.brand.display.delete') }}</a>
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
                    @if($data_edit != null)
                        <form action="{{ route('productBrandUpdate') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                        {{csrf_field()}}
                            <input type="hidden" class="form-control" name="countRow" id="countRow" value="{{ $data_edit->countRow }}">
                            <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="{{ $data_edit->keyRow }}">
                            <div class="form-group">
                                <label for="prodBrandCode">* {{ __('login.page.brand.display.brand_code') }}</label>
                                <input type="hidden" name="prodBrandCode" value="{{ $data_edit->prodBrandCode }}" >
                                <input type="text" class="form-control" id="prodBrandCode" value="{{ $data_edit->prodBrandCode }}" disabled>
                            </div>                            
                            <div class="form-group">
                                <label for="prodBrandName">* {{ __('login.page.brand.display.brand_name') }}</label>
                                <input type="text" class="form-control" name="prodBrandName" id="prodBrandName" placeholder="" value="{{ $data_edit->prodBrandName }}" required>
                            </div>
                            <div class="form-group">
                                <label for="Remark">{{ __('login.page.brand.display.remark') }}</label>
                                <!-- <textarea id="remark" name="remark" rows="4" cols="50"></textarea> -->
                                <input type="text" class="form-control" name="Remark" id="Remark" placeholder="" value="{{ $data_edit->Remark }}" >
                            </div>
                            <hr>
                            <div class="float-left">
                                <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.brand.display.update') }}</button>
                                <a class="btn btn-outline-danger" href="{{ route('adminProductBrand') }}" role="button">{{ __('login.page.brand.display.cancel') }}</a>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('productBrandInsert') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                        {{csrf_field()}}
                            <input type="hidden" class="form-control" name="countRow" id="countRow" value="0">
                            <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="0">
                            <div class="form-group">
                                <label for="prodBrandCode">* {{ __('login.page.brand.display.brand_code') }}</label>
                                <input type="text" class="form-control" name="prodBrandCode" id="prodBrandCode" placeholder="" pattern="[a-zA-Z0-9-]+" required>
                                <small class="text-danger">
                                    {{ __('login.index.form.text_pattern') }}
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="prodBrandName">* {{ __('login.page.brand.display.brand_name') }}</label>
                                <input type="text" class="form-control" name="prodBrandName" id="prodBrandName" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="Remark">{{ __('login.page.brand.display.remark') }}</label>
                                <!-- <textarea id="remark" name="remark" rows="4" cols="50"></textarea> -->
                                <input type="text" class="form-control" name="Remark" id="Remark" placeholder="" >
                            </div>
                            <hr>
                            <div class="float-left">
                                <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.brand.display.save') }}</button>
                            </div>
                        </form>
                    @endif                    
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/displayProductBrand.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    

    @endsection
