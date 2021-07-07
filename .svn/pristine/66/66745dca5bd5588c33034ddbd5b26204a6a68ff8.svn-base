@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.treasury.display.treasury_and_purchasing') }}</h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.product.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item">{{ __('login.page.treasury.display.treasury_and_purchasing') }}</li>
                <li class="breadcrumb-item active"><a href="{{ route('adminTreasury') }}">{{ __('login.page.treasury.display.build_warehouse') }}</a></li>
                @if($data_edit != null)
                <li class="breadcrumb-item active"><a href="{{ route('treasuryEdit', [ 'id' => $data_edit->whCode ]) }}">{{ $data_edit->whCode }}</a></li>
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
                                    <th scope="col">ID</th>
                                    <th scope="col">{{ __('login.page.treasury.display.code') }}</th>
                                    <th scope="col">{{ __('login.page.treasury.display.library_name') }}</th>
                                    <th scope="col">{{ __('login.page.treasury.display.employees') }}</th>
                                    <th scope="col">{{ __('login.page.treasury.display.address') }}</th>
                                    <th scope="col">{{ __('login.page.treasury.display.phone') }}</th>
                                    <th scope="col">{{ __('login.page.treasury.display.fax') }}</th>
                                    <th scope="col">{{ __('login.page.treasury.display.remark') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($get_treasury as $item)
                                <tr @if($data_edit != null && $data_edit->whId == $item->whId) style="background-color: cornsilk;" @endif>
                                    <td>{{ $item->whId }}</td>
                                    <td>{{ $item->whCode }}</td>
                                    <td>{{ $item->whTName }}</td>
                                    <td>{{ $item->whContactName }}</td>
                                    <td>{{ $item->whAddress1 }}</td>
                                    <td>{{ $item->whTelNo }}</td>
                                    <td>{{ $item->whFaxNo }}</td>
                                    <td>{{ $item->whRemark }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a href="{{ route('treasuryEdit', [ 'id' => $item->whCode ]) }}" class="btn btn-sm btn-outline-warning"> <i class="fa fa-edit"></i> {{ __('login.page.treasury.display.edit') }}</a>
                                            <a href="{{ route('treasuryDelete', [ 'id' => $item->whCode ]) }}" onclick="@if(\Session::get('locale') != 'th') return confirm('Are you sure?') @else return confirm('คุณแน่ใจที่จะลบ') @endif" class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> {{ __('login.page.treasury.display.delete') }}</a>
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
                        <form action="{{ route('treasuryUpdate') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                        {{csrf_field()}}
                            <input type="hidden" class="form-control" name="countRow" id="countRow" value="{{ $data_edit->countRow }}">
                            <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="{{ $data_edit->keyRow }}">
                            <div class="form-group">
                                <label for="prodGroupCode">* {{ __('login.page.treasury.display.code') }}</label>
                                <input type="hidden" name="whCode" value="{{ $data_edit->whCode }}" >
                                <input type="text" class="form-control" id="whCode" value="{{ $data_edit->whCode }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="prodGroupCode">* {{ __('login.page.treasury.display.library_name') }}</label>
                                <input type="text" class="form-control" name="whTName" id="whTName" placeholder="" value="{{ $data_edit->whTName }}" required>
                            </div>
                            <div class="form-group">
                                <label for="whContactName">{{ __('login.page.treasury.display.employees') }}</label>
                                <select name="whContactName" class="form-control" id="whContactName">
                                    <option value="" class="form-control" >--{{ __('login.page.treasury.display.without') }}--</option>
                                    @foreach ($get_employees as $item)
                                        <option value="{{ $item->empPOSName }}" class="form-control" @if($item->empPOSName == $data_edit->whContactName) selected  @endif>{{ $item->empPOSName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="prodGroupName">* {{ __('login.page.treasury.display.address') }}</label>
                                <input type="text" class="form-control" name="whAddress1" id="whAddress1" placeholder="" value="{{ $data_edit->whAddress1 }}" required>
                            </div>
                            <div class="form-group">
                                <label for="prodGroupName">* {{ __('login.page.treasury.display.phone') }}</label>
                                <input type="text" class="form-control" name="whTelNo" id="whTelNo" value="{{ $data_edit->whTelNo }}" onkeyup="autoTab2(this,2)" required />
                            </div>
                            <div class="form-group">
                                <label for="prodGroupName">{{ __('login.page.treasury.display.fax') }}</label>
                                <input type="text" class="form-control" name="whFaxNo" id="whFaxNo" placeholder="" value="{{ $data_edit->whFaxNo }}">
                            </div>
                            <div class="form-group">
                                <label for="prodGroupName">{{ __('login.page.treasury.display.remark') }}</label>
                                <input type="text" class="form-control" name="whRemark" id="whRemark" placeholder="" value="{{ $data_edit->whRemark }}">
                            </div>
                            <hr>
                            <div class="float-left">
                                <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.treasury.display.update') }}</button>
                                <a class="btn btn-outline-danger" href="{{ route('adminTreasury') }}" role="button">{{ __('login.page.treasury.display.cancel') }}</a>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('treasuryInsert') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                        {{csrf_field()}}
                            <input type="hidden" class="form-control" name="countRow" id="countRow" value="0">
                            <input type="hidden" class="form-control" name="keyRow" id="keyRow" value="0">
                            <div class="form-group">
                                <label for="prodGroupCode">* {{ __('login.page.treasury.display.code') }}</label>
                                <input type="text" class="form-control" name="whCode" id="whCode" placeholder="" pattern="[a-zA-Z0-9-]+" required>
                                <small class="text-danger">
                                    {{ __('login.index.form.text_pattern') }}
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="prodGroupCode">* {{ __('login.page.treasury.display.library_name') }}</label>
                                <input type="text" class="form-control" name="whTName" id="whTName" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="whContactName">{{ __('login.page.treasury.display.employees') }}</label>
                                <select name="whContactName" class="form-control" id="whContactName">
                                    <option value="" class="form-control" >--{{ __('login.page.treasury.display.without') }}--</option>
                                    @foreach ($get_employees as $item)
                                        <option value="{{ $item->empPOSName }}" class="form-control">{{ $item->empPOSName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="prodGroupName">* {{ __('login.page.treasury.display.address') }}</label>
                                <input type="text" class="form-control" name="whAddress1" id="whAddress1" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="prodGroupName">* {{ __('login.page.treasury.display.phone') }}</label>
                                <input type="text" class="form-control" name="whTelNo" id="whTelNo" onkeyup="autoTab2(this,2)" required />
                            </div>
                            <div class="form-group">
                                <label for="prodGroupName">{{ __('login.page.treasury.display.fax') }}</label>
                                <input type="text" class="form-control" name="whFaxNo" id="whFaxNo" placeholder="" >
                            </div>
                            <div class="form-group">
                                <label for="prodGroupName">{{ __('login.page.treasury.display.remark') }}</label>
                                <input type="text" class="form-control" name="whRemark" id="whRemark" placeholder="" >
                            </div>
                            <hr>
                            <div class="float-left">
                                <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.treasury.display.save') }}</button>
                            </div>
                        </form>
                    @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/posone/displayTreasury.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/autoTab.js') }}"></script>

    

    @endsection
