@extends('layouts.auth.index')

@section('center')

<main class="login-bg">
    <section>
        <div class='air air1'></div>
        <div class='air air2'></div>
        <div class='air air3'></div>
        <div class='air air4'></div>

        <div class="register-form-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="register-form text-center">
                            <form method="POST" action="/reset_password_with_token">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="register-heading">
                                    <span>{{ __('login.index.reset_password.title') }}</span>
                                </div>

                                <div class="input-box">
                                    <div class="single-input-fields">
                                        <label>{{ __('login.index.reset_password.email') }}</label>                                       
                                        <input id="email" type="hidden" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email ?? old('email') }}" disabled autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror                                        
                                    </div>
                                    <div class="single-input-fields">
                                        <label>{{ __('login.index.reset_password.password') }}</label>                                        
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror                                       
                                    </div>
                                    <div class="single-input-fields">
                                        <label>{{ __('login.index.reset_password.confirm_password') }}</label>                                        
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">                                        
                                    </div>
                                </div>
                                
                                <div class="register-footer">
                                    <button type="submit" class="submit-btn3">{{ __('login.index.reset_password.btn_submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main>

@endsection
