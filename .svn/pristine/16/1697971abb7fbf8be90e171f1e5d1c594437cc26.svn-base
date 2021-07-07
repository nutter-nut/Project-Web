@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.user.display.title') }}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <button type="button" class="btn waves-effect waves-light btn-info pull-right hidden-sm-down" data-toggle="modal" data-target="#user_insert" onclick="userInsert()" >{{ __('login.page.user.display.btn_create') }}</button>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('login.page.user.display.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('adminUsers') }}">{{ __('login.page.user.display.breadcrumb_user') }}</a></li>
                @if($text_search_user ?? '' != null)
                <li class="breadcrumb-item active">{{ __('login.page.user.display.breadcrumb_search') }}</li>
                @else
                <li class="breadcrumb-item active">{{ __('login.page.user.display.breadcrumb_view') }}</li>
                @endif
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>

        <div class="modal" id="user_insert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form id="insert_form" action="{{ route('userInsert') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                    
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('login.page.user.display.create_an_user_account') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <p aria-hidden="true">&times;</p>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div style="padding:20px">     
                                <div class="row">
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="username" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.username') }}</label>
                                            <div class="col-9">
                                                <input type="text" class="form-control" name="username" id="username" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="email" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.email') }}</label>
                                            <div class="col-9">
                                                <input type="text" class="form-control" name="email" id="email" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="row">                       
                                            <label for="prefix" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.full_name') }}</label>
                                            <div class="col-9">
                                                <div class="input-group">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <div class="input-group-prepend">
                                                                <select name="prefix" class="form-control" id="prefix" required>
                                                                    <option value="mr">{{ __('login.page.user.display.mr') }}</option>
                                                                    <option value="ms">{{ __('login.page.user.display.ms') }}</option>
                                                                    <option value="mrs">{{ __('login.page.user.display.mrs') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-5">
                                                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="{{ __('login.page.user.display.name') }}" required>
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="{{ __('login.page.user.display.surname') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="phone_number" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.phone_number') }}</label>
                                            <div class="col-9">
                                                <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="" onkeyup="autoTab2(this,2)" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="password" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.password') }}</label>
                                            <div class="col-9">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input 
                                                            type="password" 
                                                            class="form-control" 
                                                            name="password" 
                                                            id="password" 
                                                            placeholder="" 
                                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" 
                                                            required
                                                        >
                                                    </div>
                                                    <div class="col-6">
                                                        <input 
                                                            type="password" 
                                                            class="form-control" 
                                                            name="password_confirm" 
                                                            id="password_confirm" 
                                                            placeholder="{{ __('login.page.user.display.password_confirm') }}" 
                                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" 
                                                            required
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="insert_type" class="col-3 col-form-label text-right m-auto">{{ __('login.page.user.display.registration_form') }}</label>
                                            <div class="col-9">
                                                <select name="insert_type" class="form-control" id="insert_type" onchange="seleteInsertType(this.value)">
                                                    <option value="0">{{ __('login.page.user.display.registration_form_user') }}</option>
                                                    <option value="1">{{ __('login.page.user.display.registration_form_employee') }}</option>
                                                </select>
                                                <small class="text-muted" id="employee_select_sub" style="display:none;">{{ __('login.page.user.display.registration_form_employee_sub') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <center class=""> 
                                            <img id="blah" src="{{ asset('storage') }}/product_images/product_default.png" class="mt-3 img-circle img-fluid" width="180" height="180" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"/>                                      
                                        </center>
                                        <br>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <br>
                                                <center>
                                                    <input id="image_file" name="image" type="file" class="col-8 form-control form-control-line file_name"
                                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                                                        accept="image/x-png,image/gif,image/jpeg" />
                                                    <br>
                                                    <small class="text-danger">
                                                        {{ __('login.index.form.image_pattern') }}
                                                    </small>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 mx-auto border border-dark" style="padding: 4%;">
                                        <div class="row">
                                            <label for="" class="col-sm-3 col-form-label text-right m-auto">{{ __('login.page.user.display.system_administrator') }}</label>
                                            <div class="col-sm-9 m-auto">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" value="1">
                                                    <label class="form-check-label" for="is_admin">{{ __('login.page.user.display.grant_permission') }} <small class="text-muted">{{ __('login.page.user.display.grant_permission_sub') }}</small></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="" class="col-sm-3 col-form-label text-right m-auto">{{ __('login.page.user.display.information_service') }}</label>
                                            <div class="col-sm-9 m-auto">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="is_sale" id="is_sale" value="1">
                                                    <label class="form-check-label" for="is_sale">{{ __('login.page.user.display.grant_permission') }} <small class="text-muted">{{ __('login.page.user.display.grant_permission_sub2') }}</small></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="insert_to_posone" style="display:none;">
                                            <hr>
                                            <div class="row">
                                                <label for="nick_name" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.nickname') }}</label>
                                                <div class="col-9">
                                                    <div class="form-check">
                                                        <input type="text" class="form-control" name="nick_name" id="nick_name" placeholder="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="citizenid" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.citizen_id') }}</label>
                                                <div class="col-9">
                                                    <div class="form-check">
                                                        <input name="citizenid" type="text" id="citizenid" class="form-control" onkeyup="autoTab2(this,1)" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="empPOSTaxId" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.tax_no') }}</label>
                                                <div class="col-9">
                                                    <div class="form-check">
                                                        <input name="empPOSTaxId" type="text" id="empPOSTaxId" class="form-control" onkeyup="autoTab2(this,1)" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.status') }}</label>
                                                <div class="col-9">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status" id="status1" value="single" required>
                                                        <label class="form-check-label" for="status1">{{ __('login.page.user.display.single') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status" id="status2" value="married" required>
                                                        <label class="form-check-label" for="status2">{{ __('login.page.user.display.married') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status" id="status3" value="divorce" required>
                                                        <label class="form-check-label" for="status3">{{ __('login.page.user.display.divorce') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status" id="status4" value="notSpecify" required>
                                                        <label class="form-check-label" for="status4">{{ __('login.page.user.display.notSpecify') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="address" class="col-3 col-form-label text-right">{{ __('login.page.user.display.address') }}</label>
                                                <div class="col-9">
                                                    <textarea id="mytextarea" class="form-control" id="address" name="address" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">                       
                                                <label for="refer_prefix" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.refer') }}</label>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <div class="input-group-prepend">
                                                                    <select name="refer_prefix" class="form-control" id="refer_prefix">
                                                                        <option value="mr">{{ __('login.page.user.display.mr') }}</option>
                                                                        <option value="ms">{{ __('login.page.user.display.ms') }}</option>
                                                                        <option value="mrs">{{ __('login.page.user.display.mrs') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-5">
                                                                <input type="text" class="form-control" name="refer_first_name" id="refer_first_name" placeholder="{{ __('login.page.user.display.name') }}" required>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="text" class="form-control" name="refer_last_name" id="refer_last_name" placeholder="{{ __('login.page.user.display.surname') }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="refer_address" class="col-3 col-form-label text-right">{{ __('login.page.user.display.address') }}{{ __('login.page.user.display.refer') }}</label>
                                                <div class="col-9">
                                                    <textarea id="refer_address" class="form-control" id="refer_address" name="refer_address" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                            <button type="submit" onclick="formSubmit('insert_form')" class="btn btn-outline-info">{{ __('login.page.user.display.btn_save') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('login.page.products.display.close') }}</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="modal" id="user_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form id="edit_form" action="" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                    
                        <div class="modal-header">
                            <input type="hidden" name="user_id" id="user_id" >
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('login.page.user.display.edit_user_account') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><p aria-hidden="true">&times;</p></button>
                        </div>

                        <div class="modal-body">
                            <div style="padding:20px">     
                                <div class="row">
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="username" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.username') }}</label>
                                            <div class="col-9">
                                                <input type="hidden" class="form-control" name="username" id="username" >
                                                <input type="text" class="form-control" name="username" id="username" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="email" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.email') }}</label>
                                            <div class="col-9">
                                                <input type="text" class="form-control" name="email" id="email" disabled>
                                                <small class="text-muted" id="resetpassword_muted">
                                                    <a class="f-left" onclick="resetPassword(1)">{{ __('login.page.user.display.reset_password') }}</a>
                                                </small>
                                                <small class="text-muted" id="resetpassword_hide" style="display:none;">
                                                    <a class="f-left" onclick="resetPasswordHide()">{{ __('login.page.user.display.reset_password_close') }}</a>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row" id="resetpassword" style="display:none;">
                                            <input type="hidden" name="password_status" id="password_status" value="0">
                                            <label for="password" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.password') }}</label>
                                            <div class="col-9">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input type="password" class="form-control" name="password" id="password" placeholder="" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="{{ __('login.page.user.display.password_confirm') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                       
                                            <label for="prefix_edit" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.full_name') }}</label>
                                            <div class="col-9">
                                                <div class="input-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="input-group-prepend">
                                                                <select name="prefix_edit" class="form-control" id="prefix_edit" required>
                                                                    <option value="mr">{{ __('login.page.user.display.mr') }}</option>
                                                                    <option value="ms">{{ __('login.page.user.display.ms') }}</option>
                                                                    <option value="mrs">{{ __('login.page.user.display.mrs') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="first_name_edit" id="first_name_edit" placeholder="{{ __('login.page.user.display.name') }}" required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" name="last_name_edit" id="last_name_edit" placeholder="{{ __('login.page.user.display.surname') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="phone_number_edit" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.phone_number') }}</label>
                                            <div class="col-9">
                                                <input name="phone_number_edit" type="text" id="phone_number_edit" class="form-control" onkeyup="autoTab2(this,2)" required />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="edit_type" class="col-3 col-form-label text-right m-auto">{{ __('login.page.user.display.registration_form') }}</label>
                                            <div class="col-9">
                                                <select name="edit_type" class="form-control" id="edit_type" onchange="seleteEditType(this.value)">
                                                    <option value="0">{{ __('login.page.user.display.registration_form_user') }}</option>
                                                    <option value="1">{{ __('login.page.user.display.registration_form_employee') }}</option>
                                                </select>
                                                <small class="text-muted" id="employee_select_edit_sub" style="display:none;">{{ __('login.page.user.display.registration_form_employee_sub') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <center class=""> 
                                            <img id="blah_edit" src="{{ asset('storage') }}/product_images/product_default.png" class="mt-3 img-circle img-fluid" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);height:150px;width:auto;"/>                                      
                                        </center>
                                        <br>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <br>
                                                <center>
                                                    <input id="image_file" name="image" type="file" class="col-8 form-control form-control-line file_name"
                                                        onchange="document.getElementById('blah_edit').src = window.URL.createObjectURL(this.files[0])"
                                                        accept="image/x-png,image/gif,image/jpeg" />
                                                    <br>
                                                    <small class="text-danger">
                                                        {{ __('login.index.form.image_pattern') }}
                                                    </small>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 mx-auto border border-dark" style="padding: 4%;">
                                        <div class="row">
                                            <label for="" class="col-3 col-form-label text-right m-auto">{{ __('login.page.user.display.system_administrator') }}</label>
                                            <div class="col-9 m-auto">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="is_admin_edit" id="is_admin_edit" value="1">
                                                    <label class="form-check-label" for="is_admin_edit">{{ __('login.page.user.display.grant_permission') }} <small class="text-muted">{{ __('login.page.user.display.grant_permission_sub') }}</small></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="" class="col-3 col-form-label text-right m-auto">{{ __('login.page.user.display.information_service') }}</label>
                                            <div class="col-9 m-auto">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="is_sale_edit" id="is_sale_edit" value="1">
                                                    <label class="form-check-label" for="is_sale_edit">{{ __('login.page.user.display.grant_permission') }} <small class="text-muted">{{ __('login.page.user.display.grant_permission_sub2') }}</small></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row register_type" id="register_type" style="display:none;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="register_type" id="hire" value="1" onclick="registerType(this.value)" checked>
                                                <label class="form-check-label" for="hire">{{ __('login.page.user.display.hire') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="register_type" id="new_account" value="0" onclick="registerType(this.value)">
                                                <label class="form-check-label" for="new_account">{{ __('login.page.user.display.create_new_account') }}</label>
                                            </div>
                                        </div>

                                        <div id="edit_to_posone" style="display:none;">
                                            <hr>
                                            <div class="row">
                                                <label for="nick_name_edit" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.nickname') }}</label>
                                                <div class="col-9">
                                                    <div class="form-check">
                                                        <input type="text" class="form-control" name="nick_name_edit" id="nick_name_edit" placeholder="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="citizenid_edit" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.citizen_id') }}</label>
                                                <div class="col-9">
                                                    <div class="form-check">
                                                        <input name="citizenid_edit" type="text" id="citizenid_edit" class="form-control" onkeyup="autoTab2(this,1)" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="empPOSTaxId_edit" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.tax_no') }}</label>
                                                <div class="col-9">
                                                    <div class="form-check">
                                                        <input name="empPOSTaxId_edit" type="text" id="empPOSTaxId_edit" class="form-control" onkeyup="autoTab2(this,1)" required />
                                                    </div>
                                                </div>
                                            </div>                               
                                            <div class="row">
                                                <label for="status_edit" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.status') }}</label>
                                                <div class="col-9">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status_edit" id="status1_edit" value="single" required>
                                                        <label class="form-check-label" for="status1_edit">{{ __('login.page.user.display.single') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status_edit" id="status2_edit" value="married" required>
                                                        <label class="form-check-label" for="status2_edit">{{ __('login.page.user.display.married') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status_edit" id="status3_edit" value="divorce" required>
                                                        <label class="form-check-label" for="status3_edit">{{ __('login.page.user.display.divorce') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status_edit" id="status4_edit" value="notSpecify" required>
                                                        <label class="form-check-label" for="status4_edit">{{ __('login.page.user.display.notSpecify') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="address_edit" class="col-3 col-form-label text-right">{{ __('login.page.user.display.address') }}</label>
                                                <div class="col-9">
                                                    <textarea class="form-control" id="address_edit" name="address_edit" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">                       
                                                <label for="refer_prefix_edit" class="col-3 col-form-label text-right">* {{ __('login.page.user.display.refer') }}</label>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <div class="input-group-prepend">
                                                                    <select name="refer_prefix_edit" class="form-control" id="refer_prefix_edit">
                                                                        <option value="mr">{{ __('login.page.user.display.mr') }}</option>
                                                                        <option value="ms">{{ __('login.page.user.display.ms') }}</option>
                                                                        <option value="mrs">{{ __('login.page.user.display.mrs') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-5">
                                                                <input type="text" class="form-control" name="refer_first_name_edit" id="refer_first_name_edit" placeholder="{{ __('login.page.user.display.name') }}" required>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="text" class="form-control" name="refer_last_name_edit" id="refer_last_name_edit" placeholder="{{ __('login.page.user.display.surname') }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="refer_address_edit" class="col-3 col-form-label text-right">{{ __('login.page.user.display.address') }}{{ __('login.page.user.display.refer') }}</label>
                                                <div class="col-9">
                                                    <textarea class="form-control" id="refer_address_edit" name="refer_address_edit" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                            <button type="submit" onclick="formSubmit('edit_form')" class="btn btn-outline-info">{{ __('login.page.user.display.btn_update') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('login.page.products.display.close') }}</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="modal" id="modal_ban" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <form id="ban_form" action="" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                    
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('login.page.user.display.title_ban') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><p aria-hidden="true">&times;</p></button>
                        </div>

                        <div class="modal-body">
                            <div style="padding:20px">
                                <div class="row">
                                    <label for="date" class="col-3 col-form-label text-right m-auto">* {{ __('login.page.user.display.date_ban') }}</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="date_ban" id="date_ban">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                            <button type="submit" onclick="formSubmit('edit_form')" class="btn btn-outline-info">{{ __('login.page.user.display.btn_update') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('login.page.products.display.close') }}</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="modal" id="modal_chat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form id="" action="" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                    
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('login.page.user.display.chat_title') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><p aria-hidden="true">&times;</p></button>
                        </div>

                        <div class="modal-body">
                            <div style="padding:20px">
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="text-muted">{{ __('login.page.user.display.user_list') }}</h6>
                                        <div class="border" id="getUserAll" style="overflow-y:scroll;height:250px;"></div>
                                        <br>
                                        <h6 class="text-muted">{{ __('login.page.user.display.friend_list') }}</h6>
                                        <div class="border" id="getFriendList" style="overflow-y:scroll;height:250px;"></div>
                                    </div>
                                    <div class="col-6" style="background-color: aliceblue;">
                                        <!-- <div class="selected-user">
                                            <b class="name" id="selected_user">Not selected yet</b>
                                        </div> -->
                                        <div id="box_chat" class="chat-container" style="overflow-y:scroll;height:520px;padding: 20px 20px 0 0;" onscroll="handleScroll()">
                                            <ul id="chat_massge" class="chat-box chatContainerScroll" style="padding: 0 0 0 0;">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" id="local" value="{{ \Session::get('locale') }}">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('login.page.products.display.close') }}</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="row">
            <!-- Column -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Table</h4>
                        <h6 class="card-subtitle">Add class <code>.table</code></h6> -->
                        <div class="table-responsive">
                        <table id="table_id" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ __('login.page.user.display.image') }}</th>
                                    <th>{{ __('login.page.user.display.name') }}</th>
                                    <th>{{ __('login.page.user.display.admin') }}</th>
                                    <th>{{ __('login.page.user.display.sale') }}</th>
                                    <th>{{ __('login.page.user.display.employee') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $item)
                                <tr>
                                    <td>{{ $item['id'] }}</td>
                                    <td style="width:50px;">
                                        <div class="card__avatar">
                                            <svg role="none" style="height:50px; width:50px">
                                                <mask id="circle">
                                                    <circle cx="25" cy="25" fill="white" r="25"></circle>
                                                    @if($item['status'] != 'offline')<circle cx="42" cy="42" fill="black" r="7"></circle>@endif
                                                </mask>
                                                <g mask="url(#circle)">
                                                <image
                                                    x="0"
                                                    y="0"
                                                    height="100%"
                                                    preserveAspectRatio="xMidYMid slice"
                                                    width="100%"
                                                    xlink:href="{{ $user_image[$key]['url'] }}"
                                                    style="height: 50px; width: 50px"
                                                ></image>
                                                <circle class="border" cx="25" cy="25" r="25"></circle>
                                                </g>
                                            </svg>
                                            @if($item['status'] != 'offline')<div class="badge3"></div>@endif
                                        </div>
                                        <p style="display:none;">@if($item['status'] != 'offline') 1 @else 0 @endif</p>
                                    </td>
                                    <td>
                                        <h6>{{ $item['name'] }}</h6><small class="text-muted">{{ $item['email'] }}</small>
                                    </td>
                                    <td><i class="@if($item['admin']=='1') fa fa-check text-success @else fa fa-times text-danger @endif"></i><p style="display:none;">@if($item['admin']=='1') 1 @else 0 @endif</p></td>
                                    <td><i class="@if($item['sale']=='1') fa fa-check text-success @else fa fa-times text-danger @endif"></i><p style="display:none;">@if($item['sale']=='1') 1 @else 0 @endif</p></td>
                                    <td><i class="@if($item['employee']!='0') fa fa-check text-success @else fa fa-times text-danger @endif"></i><p style="display:none;">@if($item['employee']!='0') 1 @else 0 @endif</p></td>
                                    <td>
                                        @if($item['id'] != 1 || $userData->id == 1)
                                        <center>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                <a><button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modal_chat" onclick="userChat({{ $item['id'] }})"><i class="fa fa-comments-o"></i> {{ __('login.page.user.display.btn_chat') }}</button></a>
                                                <a><button class="btn btn-sm btn-outline-warning" onclick="userEdit({{ $item['id'] }})"><i class="fa fa-edit"></i> {{ __('login.page.user.display.btn_edit') }}</button></a>
                                                <a><button class="btn btn-sm @if($item['banned_until'] != '1' && \date('d-m-Y') < $item['banned_until']) btn-danger @else btn-outline-danger @endif" data-toggle="modal" data-target="#modal_ban" onclick="userBan({{ $item['id'] }})"><i class="fa fa-window-close-o"></i> {{ __('login.page.user.display.btn_ban') }}</button></a>
                                                <!-- <a><button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> {{ __('login.page.user.display.btn_delete') }}</button></a> -->
                                            </div>
                                        </center>
                                        @endif                                        
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
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/displayUsers.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/autoTab.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript" src="{{ asset('assets/js/view/login/admin/displayUsers_date.js') }}"></script>
    
@endsection
