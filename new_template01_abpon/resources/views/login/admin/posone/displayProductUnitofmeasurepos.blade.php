@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.unit_count.display.set_products') }}</h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item">{{ __('login.page.unit_count.display.set_products') }}</li>
                <li class="breadcrumb-item active"><a href="{{ route('adminProductUnitofmeasurepos') }}">{{ __('login.page.unit_count.display.unit_count') }}</a></li>
                @if ($data_edit != null)
                <li class="breadcrumb-item active"><a href="{{ route('productUomEdit', ['id' => $data_edit->uomCode ]) }}">{{ $data_edit->uomCode }}</a></li>
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
                                    <th scope="col">{{ __('login.page.unit_count.display.unit_code') }}</th>
                                    <th scope="col">{{ __('login.page.unit_count.display.unit_name') }}</th>
                                    <th scope="col">{{ __('login.page.unit_count.display.detail') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($product_unitofmeasurepos as $item)
                                <tr @if($data_edit != null && $data_edit->uomCode == $item->uomCode) style="background-color: cornsilk;" @endif>
                                    <td>{{ $item->uomCode }}</td>
                                    <td>{{ $item->uomName }}</td>
                                    <td>{{ $item->uomDescription }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a href="{{ route('productUomEdit', ['id' => $item->uomCode ]) }}" class="btn btn-sm btn-outline-warning"> <i class="fa fa-edit"></i> {{ __('login.page.unit_count.display.edit') }}</a>
                                            <a href="{{ route('productUomDelete', ['id' => $item->uomCode ]) }}" onclick="@if(\Session::get('locale') != 'th') return confirm('Are you sure?') @else return confirm('คุณแน่ใจที่จะลบ') @endif" class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> {{ __('login.page.unit_count.display.delete') }}</a>
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
                        <form action="{{ route('productUomUpdate') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" name="countRow" id="countRow" value="{{ $data_edit->countRow }}">
                            <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="{{ $data_edit->keyRow }}">
                            <div class="form-group">
                                <label for="uomCode">* {{ __('login.page.unit_count.display.unit_code') }}</label>
                                <input type="hidden" name="uomCode" value="{{ $data_edit->uomCode }}" >
                                <input type="text" class="form-control" id="uomCode" value="{{ $data_edit->uomCode }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="uomName">* {{ __('login.page.unit_count.display.unit_name') }}</label>
                                <input type="text" class="form-control" name="uomName" id="uomName" value="{{ $data_edit->uomName }}" required>
                            </div>
                            <div class="form-group">
                                <label for="uomDescription">{{ __('login.page.unit_count.display.detail') }}</label>
                                <input type="text" class="form-control" name="uomDescription" id="uomDescription" value="{{ $data_edit->uomDescription }}">
                            </div>
                            <hr>
                            <div class="float-left">
                                <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.unit_count.display.update') }}</button>
                                <a class="btn btn-outline-danger" href="{{ route('adminProductUnitofmeasurepos') }}" role="button">{{ __('login.page.unit_count.display.cancel') }}</a>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('productUomInsert') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" name="countRow" id="countRow" value="0">
                            <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="0">
                            <div class="form-group">
                                <label for="uomCode">* {{ __('login.page.unit_count.display.unit_code') }}</label>
                                <input type="text" class="form-control" name="uomCode" id="uomCode" placeholder="" pattern="[a-zA-Z0-9-]+" required>
                                <small class="text-danger">
                                    {{ __('login.index.form.text_pattern') }}
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="uomName">* {{ __('login.page.unit_count.display.unit_name') }}</label>
                                <input type="text" class="form-control" name="uomName" id="uomName" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="uomDescription">{{ __('login.page.unit_count.display.detail') }}</label>
                                <input type="text" class="form-control" name="uomDescription" id="uomDescription" placeholder="">
                            </div>
                            <hr>
                            <div class="float-left">
                                <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.unit_count.display.save') }}</button>
                            </div>
                        </form>
                    @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/displayProductUnitofmeasurepos.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    

    @endsection
