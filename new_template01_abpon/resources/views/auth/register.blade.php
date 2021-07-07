@extends('layouts.auth.index')

@section('center')

<main class="login-bg">
    <section>
        <div class='air air1'></div>
        <div class='air air2'></div>
        <div class='air air3'></div>
        <div class='air air4'></div>

        <!-- login Area Start -->
        <div class="register-form-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="register-form text-center">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <!-- Login Heading -->
                                <div class="register-heading">
                                    <span>{{ __('login.register.signUp') }}</span>
                                    <p>{{ __('login.register.signUpDetails') }}</p>
                                </div>

                                <div class="container col-12">
                                    @include('../alert')
                                </div>
                                <!-- Single Input Fields -->
                                <div class="input-box">
                                    <div class="single-input-fields">
                                        <label>* {{ __('login.register.fullName') }}</label>
                                        <input id="name" type="text" class="@error('name') is-invalid @enderror"
                                            name="name" 
                                            value="{{ old('name') }}"
                                            pattern=".{6,}"
                                            title="6 characters minimum"
                                            placeholder="" required
                                            autocomplete="name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="single-input-fields">
                                        <label>* {{ __('login.register.emailAddress') }}</label>
                                        <input id="email" type="email" class="@error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}"
                                            placeholder="" required
                                            autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-7 single-input-fields">
                                            <div class="input-group mb-3">
                                                <label>* {{ __('login.register.f_name') }}</label>
                                                <div class="input-group-prepend">
                                                    <select name="prefix" id="prefix" class="form-control nice-select-login" required>
                                                        <option value="mr">{{ __('login.page.user.display.mr') }}</option>
                                                        <option value="ms">{{ __('login.page.user.display.ms') }}</option>
                                                        <option value="mrs">{{ __('login.page.user.display.mrs') }}</option>
                                                    </select>
                                                    <input id="f_name" type="text" class="@error('f_name') is-invalid @enderror"
                                                        name="f_name" value="{{ old('f_name') }}"
                                                        placeholder="" required
                                                        autocomplete="f_name" autofocus>
                                                </div>
                                                @error('f_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-5 single-input-fields">
                                            <label>* {{ __('login.register.l_name') }}</label>
                                            <input id="l_name" type="text" class="@error('l_name') is-invalid @enderror"
                                                name="l_name" value="{{ old('l_name') }}"
                                                placeholder="" required
                                                autocomplete="l_name" autofocus>
                                            @error('l_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="single-input-fields">
                                        <label>* {{ __('login.register.tel') }}</label>
                                        <input id="tel" type="tel" class="@error('tel') is-invalid @enderror"
                                            name="tel" value="{{ old('tel') }}"
                                            placeholder="" 
                                            onkeyup="autoTab2(this,2)"
                                            required
                                            autocomplete="tel">
                                        @error('tel')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="single-input-fields">
                                        <label>* {{ __('login.register.password') }}</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password" 
                                            placeholder=""
                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                            required autocomplete="new-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="single-input-fields">
                                        <label>* {{ __('login.register.confirmPassword') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation"
                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                            placeholder="" required
                                            autocomplete="new-password">
                                    </div>
                                    <!-- <div class="single-input-fields" align="center">
                                        <div class="g-recaptcha " data-sitekey="6Le-tpAaAAAAAGsaF7AictdkHgZGyLzVzkLEGQDS"></div>
                                        @if($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" style="display:block">
                                                <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                                            </span>
                                        @endif
                                    </div> -->
                                </div>
                                <!-- form Footer -->
                                <div class="register-footer">
                                    <p> {{ __('login.register.haveAccount') }} <a href="/login">
                                            {{ __('login.register.login') }}</a> {{ __('login.register.here') }}</p>
                                    <button type="submit text/javascript"  
                                        class="submit-btn3">{{ __('login.register.signUp') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login Area End -->
    </section>
</main>

<!-- reCAPTCHA v3  -->
<!-- <script src='https://www.google.com/recaptcha/api.js'></script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>

<script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_CAPTCHA_PUBLIC_KEY') }}"></script> -->

<script type="text/javascript" src="{{ asset('assets/js/view/autoTab.js') }}"></script>

@endsection

<!-- // !แจ้งเตือน error -->
