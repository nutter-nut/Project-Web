@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.model.display.set_products') }}</h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item">{{ __('login.page.model.display.set_products') }}</li>
                <li class="breadcrumb-item active"><a href="{{ route('adminProductModel') }}">{{ __('login.page.model.display.product_model') }}</a></li>
                @if($data_edit != null)
                <li class="breadcrumb-item active"><a href="{{ route('productModelEdit', [ 'id' => $data_edit->ProdModelCode ]) }}">{{ $data_edit->ProdModelCode }}</a></li>
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
                                    <th scope="col">{{ __('login.page.model.display.model_code') }}</th>
                                    <th scope="col">{{ __('login.page.model.display.model_name') }}</th>
                                    <th scope="col">{{ __('login.page.model.display.remark') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_model as $item)
                                <tr @if($data_edit != null && $data_edit->ProdModelCode == $item->ProdModelCode) style="background-color: cornsilk;" @endif>
                                    <td>{{ $item->ProdModelCode }}</td>
                                    <td>{{ $item->ProdModelName }}</td>
                                    <td>{{ $item->Remark }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a href="{{ route('productModelEdit', [ 'id' => $item->ProdModelCode ]) }}" class="btn btn-sm btn-outline-warning"> <i class="fa fa-edit"></i> {{ __('login.page.model.display.edit') }}</a>
                                            <a href="{{ route('productModelDelete', [ 'id' => $item->ProdModelCode ]) }}" onclick="@if(\Session::get('locale') != 'th') return confirm('Are you sure?') @else return confirm('คุณแน่ใจที่จะลบ') @endif" class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> {{ __('login.page.model.display.delete') }}</a>
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
                        <form action="{{ route('productModelUpdate') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" name="countRow" id="countRow" value="{{ $data_edit->countRow }}">
                            <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="{{ $data_edit->keyRow }}">
                            <div class="form-group">
                                <label for="ProdModelCode">* {{ __('login.page.model.display.model_code') }}</label>
                                <input type="hidden" name="ProdModelCode" value="{{ $data_edit->ProdModelCode }}" >
                                <input type="text" class="form-control" id="ProdModelCode" value="{{ $data_edit->ProdModelCode }}" disabled >
                            </div>
                            <div class="form-group">
                                <label for="ProdModelName">* {{ __('login.page.model.display.model_code') }}</label>
                                <input type="text" class="form-control" name="ProdModelName" id="ProdModelName" placeholder="" value="{{ $data_edit->ProdModelName }}" required>
                            </div>
                            <div class="form-group">
                                <label for="Remark">{{ __('login.page.model.display.remark') }}</label>
                                <input type="text" class="form-control" name="Remark" id="Remark" placeholder="" value="{{ $data_edit->Remark }}" >
                            </div>
                            <hr>
                            <div class="float-left">
                                <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.model.display.update') }}</button>
                                <a class="btn btn-outline-danger" href="{{ route('adminProductModel') }}" role="button">{{ __('login.page.model.display.cancel') }}</a>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('productModelInsert') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" name="countRow" id="countRow" value="0">
                            <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="0">
                            <div class="form-group">
                                <label for="ProdModelCode">* {{ __('login.page.model.display.model_code') }}</label>
                                <input type="text" class="form-control" name="ProdModelCode" id="ProdModelCode" placeholder="" pattern="[a-zA-Z0-9-]+" required>
                                <small class="text-danger">
                                    {{ __('login.index.form.text_pattern') }}
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="ProdModelName">* {{ __('login.page.model.display.model_name') }}</label>
                                <input type="text" class="form-control" name="ProdModelName" id="ProdModelName" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="Remark">{{ __('login.page.model.display.remark') }}</label>
                                <input type="text" class="form-control" name="Remark" id="Remark" placeholder="" >
                            </div>
                            <hr>
                            <div class="float-left">
                                <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.model.display.save') }}</button>
                            </div>
                        </form>
                    @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/displayProductModel.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>
    
    

    @endsection
