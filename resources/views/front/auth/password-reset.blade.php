@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <section class="reset-password center-page spacing">
        <div class="container">
            <div class="box">
                <div class="form">
                    <div class="text-center">
                        <h2 class="secondary-headline secondary-headline-black">
                            {!! __('Reset Password') !!}
                            <span class="left-border"></span>
                        </h2>
                    </div>
{{--                    {{$errors}}--}}

                    <form action="{{route('front.auth.password.reset.submit')}}" method="post" >
                        @csrf
                        <input type="hidden" name="token" value="{{$token}}">
                        <p class="desc m-b-25">
                            {!! __('Enter code sent at your email address and new password then confirm it to change your account password.') !!}
                        </p>
                        {{--Email input--}}
                        <div class="form-group m-b-25 pswd">
                            <label class="required" for="email">{!! __('Email') !!}</label>
                            <div class="pswd-field">
                                <input type="email" class="form-control " id="email" placeholder="{!! __('Enter your email') !!}"
                                       name="email" required>
                            </div>
                            @if($errors->has('email'))
                                <span class="help-block">
                                        <small class="gothic-normel font-weight-bold text-danger">{{ __($errors->first('email')) }}</small>
                                    </span>
                            @endif
                        </div>

                        {{--New Password input--}}
                        <div class="form-group m-b-25 pswd">
                            <label class="required" for="pwd">{!! __('New Password') !!}</label>
                            <div class="pswd-field">
                                <input type="password" class="form-control" id="pwd" placeholder="********"
                                       name="password" required>
                                <i class="far fa-eye-slash"></i>
                            </div>
                            @if($errors->has('password'))
                                <span class="help-block">
                                        <small class="gothic-normel font-weight-bold text-danger">{{ __($errors->first('password')) }}</small>
                                    </span>
                            @endif
                        </div>
                        {{--Confirm Password input--}}
                        <div class="form-group m-b-25 pswd">
                            <label class="required" for="pwd">{!! __('Confirm Password') !!}</label>
                            <div class="pswd-field">
                                <input type="password" class="form-control " id="pwd" placeholder="********"
                                       name="password_confirmation" required>
                                <i class="far fa-eye-slash"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="ful-btn">
{{--                                    <a href="#" class="btn btn--black btn--animate btn-block">{{__('Reset')}}</a>--}}
                                    <button type="reset" class="btn btn--black btn--animate btn-block" >{{__('Reset')}}</button>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="ful-btn form-group">
                                    <button class="btn btn-block btn--primary btn--animate" > {{__('Submit')}}</button>
                                </div>
                            </div>
                        </div>
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
