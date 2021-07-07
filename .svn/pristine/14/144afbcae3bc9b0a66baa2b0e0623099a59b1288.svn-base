@extends('layouts.login.index')

@section('center')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><a href="/profile">{{ __('login.page.profile.reset_password.title') }}</a></h3>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">{{ __('login.page.profile.reset_password.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item"><a href="/profile">{{ __('login.page.profile.reset_password.breadcrumb_profile') }}</a></li>
                <li class="breadcrumb-item active">{{ __('login.page.profile.reset_password.breadcrumb_reset_password') }}</li>
            </ol>
        </nav>

        <!-- <div class="container col-12">
                @include('../alert')
        </div> -->
        <div class="row justify-content-md-center">
            <div class="col-lg-6">                
                <div class="card">
                    <div class="card-body">
                        <form action=" {{route('updatePassword', ['id'=>$user['id'] ]) }}" method="POST" autocomplete="on" class="needs-validation" novalidate>
                            {{csrf_field()}}
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('login.page.profile.reset_password.title_reset_password') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- <div class="form-group">
                                            <label for="name">Password</label>
                                            <input type="password" class="form-control" 
                                                name="password" id="password"
                                                placeholder="Password" value="" require>
                                            
                                        </div> -->
                                        
                                        <div class="form-group single-input-fields">
                                            <label for="newpassword">{{ __('login.page.profile.reset_password.new_password') }}</label>
                                            <input 
                                                id="newpassword" 
                                                type="password" 
                                                class="form-control @error('newpassword') is-invalid @enderror"  
                                                name="newpassword"  
                                                placeholder=""
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                                required 
                                                autocomplete="new-password"
                                            >
                                            @error('newpassword')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group single-input-fields">
                                            <label for="connewpassword">{{ __('login.page.profile.reset_password.confirm_new_password') }}</label>
                                            <input 
                                                type="password" 
                                                class="form-control" 
                                                name="connewpassword" 
                                                id="connewpassword" 
                                                placeholder="" 
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                                required 
                                                autocomplete="new-password"
                                            >
                                        </div>
                                        
                                    </div>                                                      
                                </div>
                            </div>
                                <hr class="my-4" /> 
                                <div class="float-left">
                                    <button type="submit" name="submit" class="btn btn-outline-info">{{ __('login.page.profile.reset_password.btn_reset') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/view/input_pattern.js') }}"></script>

    @endsection