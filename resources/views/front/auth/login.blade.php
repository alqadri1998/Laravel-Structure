@extends('front.layouts.app')

@section('content')
    @include('front.common.breadcrumb')

    <section class="login-now center-page spacing">
        <div class="container">
            <div class="box">
                <div class="form">
                    <div class="text-center">
                        <h2 class="secondary-headline secondary-headline-black">
                            {!! __('Login') !!}
                            <span class="left-border"></span>
                        </h2>
                    </div>
                    <form id="login-form" action="{!! route('front.auth.login.submit') !!}"  method="post" >
                        @csrf

                        <div class="form-group m-b-25">
                            <label class="" for="email">{!! __('Email') !!}</label>
                            <input type="email" class="form-control required" id="email"
                                   placeholder="{!! __('e.g johndoe@example.com') !!}" value="{!! old('email') !!}" autocomplete="off" name="email" required>
                            @if($errors->has('email'))
                                <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ __($errors->first('email')) }}</small>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group m-b-25 pswd">
                            <label class="" for="pwd">{!! __('Password') !!}</label>
                            <div class="pswd-field">
                                <input type="password" class="form-control " id="pwd" placeholder="********"
                                       name="password" required>
                                <i class="far fa-eye-slash"></i>
                            </div>
                            @if($errors->has('password'))
                                <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ __($errors->first('password')) }}</small>
                                    </span>
                            @endif
                        </div>
                        <div class="ful-btn form-group m-b-25">
{{--                            <a href="#" class="btn btn-block btn--primary btn--animate" onclick="document.getElementById('login-form').submit();">{!! __('Login') !!}</a>--}}
                            <button class="btn btn-block btn--primary btn--animate" >{!! __('Login') !!}</button>
                        </div>
                        <div class="form-group form-check d-flex justify-content-between flex-wrap m-b-25">
                            <label class="checkbox-container">{!! __('Remember me') !!}
                                <input type="checkbox" checked="checked" name="example1">
                                <span class="checkmark"></span>
                            </label>
                            <a href="{{route('front.auth.forgot-password')}}" class="forget-paswd">{!! __('Forgot Password?') !!}</a>
                        </div>
                        <div class="ful-btn form-group m-b-25">
                            <a href="{{route('front.auth.register.form')}}" class="btn btn-block btn--primary btn--animate">Register</a>
                        </div>
                        <div class="ful-btn m-b-25">
                            <a href="{!! route('front.index') !!}" class="btn btn--black btn--animate btn-block">{!! __('Continue as guest') !!}</a>
                        </div>

                    {{--    <div class="login-title m-b-25">
                            <p class="login-via text-center">{!! __('Login Via Social Account') !!}</p>
                        </div>--}}
                        {{--<div class="icon-bars-footer-login">
                           --}}{{-- <div class="icon-footer-log-in-f">
                                <a class="icon-links-f" href="{!! route('front.auth.login.social','facebook') !!}" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </div>--}}{{--

                          --}}{{--  <div class="icon-footerlog-in-g">
                                <a class="icon-links-g" href="{!! route('front.auth.login.social','google') !!}" target="_blank">
                                    <i class="fab fa-google-plus-g"></i>
                                </a>
                            </div>
                            <div class="icon-footerlog-in-i margin-right-icon">
                                <a class="icon-links-i" href="{!! route('front.auth.login.social','instagram') !!}" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>--}}{{--
                        </div>--}}
                    </form>
                </div>
            </div>

        </div>
    </section>

@endsection

@push('script-page-level')
    <script>
        function togglePasswordInputType() {
            $('.fa-eye-slash').click(function () {
                if ($(this).hasClass('fa-eye')) {
                    $(this).removeClass('fa-eye');
                    $(this).addClass('fa-eye-slash');
                    $(this).prev().attr('type', 'password');
                } else {
                    $(this).removeClass('fa-eye-slash');
                    $(this).addClass('fa-eye');
                    $(this).prev().attr('type', 'text');
                }
            });
        }

        $(document).ready(function () {
            togglePasswordInputType();
        })
    </script>
@endpush
