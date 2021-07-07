@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ __('login.page.profile.display.title') }}</h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('login.page.profile.display.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('login.page.profile.display.breadcrumb_profile') }}</li>
            </ol>
        </nav>

        <div class="container col-12">
            @include('../alert')
        </div>

        <div class="rounded bg-white col-12">
            <div class="row">
                
                <div class="col-4 border-right">
                    <form action=" {{ route('editProfile', [ 'id' => $user['id'] ]) }} " method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                        <div class="p-3 py-5">
                            <center>
                                <img id="blah" src="{{ asset('storage') }}/user_images/{{ Auth::user()->image }}" class="img-circle img-fluid" style="width:150px;height:150px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" />
                            </center>
                            <br>
                            <!-- <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profile Settings</h4>
                            </div> -->
                            <div class="row">
                                <div class="col-6">
                                    <label class="labels">{{ __('login.page.profile.display.full_name') }}</label>
                                    <input name="name" id="name" type="hidden" value="{{ Auth::user()->name }}">
                                    <input name="name" id="name" type="text" class="form-control" placeholder="{{ __('login.page.profile.display.input_full_name') }}" value="{{ Auth::user()->name }}" disabled>
                                    <small class="text-muted">
                                        <a href="{{ route('resetPassword', [ 'id' => $user['id'] ]) }}" class="f-left">{{ __('login.page.profile.display.reset_password') }}</a>
                                    </small>
                                </div>
                                <div class="col-6">
                                    <label class="labels">{{ __('login.page.profile.display.email') }}</label>
                                    <input type="hidden" name="email" id="email" value="{{ Auth::user()->email }}" class="form-control form-control-line">
                                    <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label class="labels">* {{ __('login.page.profile.display.f_name') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="prefix" id="prefix" class="form-control" style="width: 80px;"  required>
                                                <option value="mr" @if(Auth::user()->prefix == 'mr') selected @endif>{{ __('login.page.user.display.mr') }}</option>
                                                <option value="ms" @if(Auth::user()->prefix == 'ms') selected @endif>{{ __('login.page.user.display.ms') }}</option>
                                                <option value="mrs" @if(Auth::user()->prefix == 'mrs') selected @endif>{{ __('login.page.user.display.mrs') }}</option>
                                            </select>
                                        </div>
                                        <input type="text" class="form-control" name="f_name" id="f_name" value="{{ Auth::user()->first_name }}" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="labels">* {{ __('login.page.profile.display.l_name') }}</label>
                                    <input type="text" class="form-control" name="l_name" id="l_name" value="{{ Auth::user()->last_name }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="labels">* {{ __('login.page.profile.display.tel') }}</label>
                                    <input type="text" class="form-control" name="tel" id="tel" value="{{ Auth::user()->tel }}" onkeyup="autoTab2(this,2)" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="labels">{{ __('login.page.profile.display.image') }}</label>
                                    <input id="image_file" name="image" type="file" class="form-control form-control-line"
                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                                        accept="image/x-png,image/gif,image/jpeg" />
                                    <small class="text-danger">
                                        {{ __('login.index.form.image_pattern') }}
                                    </small>
                                </div>
                            </div>

                            <hr>
                            <button class="btn btn-outline-info profile-button float-left" type="submit" name="submit">{{ __('login.page.profile.display.btn_update') }}</button>
                        </div>
                    </form>
                </div>
                
                <div class="col-8">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center experience">
                            <span>{{ __('login.page.profile.display.delivery_address') }}</span>
                            <span class="px-3 p-1 add-experience">
                                <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#address_insert"><i class="fa fa-plus"> {{ __('login.page.profile.display.btn_address_add') }}</i></button>
                            </span>
                        </div>
                        <br>
                        <div class="table-responsive">
                        <table id="table_id" class="table table-sm table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">{{ __('login.page.profile.display.place_name') }}</th>
                                    <th scope="col">{{ __('login.page.profile.display.first_name') }}</th>
                                    <th scope="col">{{ __('login.page.profile.display.last_name') }}</th>
                                    <th scope="col">{{ __('login.page.profile.display.phone_number') }}</th>
                                    <th scope="col">{{ __('login.page.profile.display.address') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($address as $key => $item)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $item['place_name'] }}</td>
                                    <td>{{ $item['first_name'] }}</td>
                                    <td>{{ $item['last_name'] }}</td>
                                    <td>{{ $item['phone'] }}</td>
                                    <td>{{ $item['address'] }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a class="btn btn-sm btn-outline-warning" onclick="addressEdit({{ $item['id'] }})"><i class="fa fa-edit"></i> {{ __('login.page.brand.display.edit') }}</a>
                                            <a href="{{ route('addressDelete', [ 'id' => $item['id'] ]) }}" onclick="@if(\Session::get('locale') != 'th') return confirm('Are you sure?') @else return confirm('คุณแน่ใจที่จะลบ') @endif" class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> {{ __('login.page.brand.display.delete') }}</a>
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
        </div>

        <div class="modal" id="address_insert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form action="{{ route('addressInset') }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('login.page.profile.display.address_title') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <p aria-hidden="true">&times;</p>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div style="padding:20px">             
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <label class="labels">* {{ __('login.page.profile.display.place_name') }}</label>
                                        <input name="place_name" id="place_name" type="text" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="labels">* {{ __('login.page.profile.display.first_name') }}</label>
                                        <input name="first_name" id="first_name" type="text" class="form-control" placeholder="" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labels">* {{ __('login.page.profile.display.last_name') }}</label>
                                        <input name="last_name" id="last_name" type="text" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label class="labels">* {{ __('login.page.profile.display.phone_number') }}</label>
                                        <input name="phone" id="phone" type="text" class="form-control" placeholder="" onkeyup="autoTab2(this,2)" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label class="labels">* {{ __('login.page.profile.display.address') }}</label>
                                        <textarea name="address" class="form-control" id="address" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-info">{{ __('login.page.stock.display.save') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('login.page.stock.display.cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="address_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form action="{{ route('addressUpdate', [ 'user_id' => Auth::user()->id ]) }}" method="POST" enctype="multipart/form-data" autocomplete="on" class="needs-validation" novalidate>
                    {{csrf_field()}}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('login.page.profile.display.address_title_edit') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <p aria-hidden="true">&times;</p>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div style="padding:20px">
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <label class="labels">* {{ __('login.page.profile.display.place_name') }}</label>
                                        <input name="place_name_edit" id="place_name_edit" type="text" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="labels">* {{ __('login.page.profile.display.first_name') }}</label>
                                        <input name="first_name_edit" id="first_name_edit" type="text" class="form-control" placeholder="" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labels">* {{ __('login.page.profile.display.last_name') }}</label>
                                        <input name="last_name_edit" id="last_name_edit" type="text" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label class="labels">* {{ __('login.page.profile.display.phone_number') }}</label>
                                        <input name="phone_edit" id="phone_edit" type="text" class="form-control" placeholder="" onkeyup="autoTab2(this,2)" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label class="labels">* {{ __('login.page.profile.display.address') }}</label>
                                        <!-- <textarea name="address_edit" id="address_edit" class="form-control" rows="3"></textarea> -->
                                        <input name="address_edit" id="address_edit" type="text" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="" name="id_edit">
                            <button type="submit" class="btn btn-outline-info">{{ __('login.page.profile.display.btn_update') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('login.page.stock.display.cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Row -->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->

    <script type="text/javascript" src="{{ asset('assets/js/view/login/profile.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/autoTab.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

@endsection
    