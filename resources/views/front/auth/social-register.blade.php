@extends('front.layouts.app')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lw&libraries=places">
</script>
<script>
    function initialize() {
        var input = document.getElementById('searchId');
        new google.maps.places.Autocomplete(input);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

@section('content')
    @include('front.common.breadcrumb')


    <section class="create-an-account center-page spacing">
        <div class="container">
            <div class="box">
                <div class="form">
                    <div class="text-center">
                        <h2 class="secondary-headline secondary-headline-black">
                            {!! __('SOCIAL REGISTER NOW') !!}
                            <span class="left-border"></span>
                        </h2>
                    </div>
                    @foreach($errors->register as $error )
                        {{$error}}
                    @endforeach
                    <form id="register-form" action="{{route('front.auth.register')}}" method="post">
                        @csrf

                        <div class="row">
                            {{--First name input--}}
                            <div class="form-group m-b-25 col-sm-6">
                                <label  for ="first_name" class="required">{!! __('First Name') !!}</label>
                                <input type="text" class="form-control required" id="first_name" value="{{old('first_name')?old('first_name'):request()->first_name}}"
                                       placeholder="{!! __('e.g john') !!}" name="first_name" required>
                                @if($errors->register->has('first_name'))
                                    <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ __($errors->register->first('first_name')) }}</small>
                                    </span>
                                @endif
                            </div>
                            {{--Last name input--}}
                            <div class="form-group m-b-25 col-sm-6">
                                <label for="last_name" class="required">{!! __('Last Name') !!}</label>
                                <input type="text" class="form-control required" id="last_name" value="{{old('last_name')?old('last_name'):request()->last_name}}"
                                       placeholder="{!! __('e.g doe') !!}" name="last_name">
                                @if($errors->register->has('last_name'))
                                    <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ __($errors->register->first('last_name')) }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{--Email input--}}
                        <div class="form-group m-b-25">
                            <label class="required" for="email">{!! __('Email') !!}</label>
                            <input type="email" class="form-control required" id="email" placeholder="{!! __('e.g') !!} johndoe@example.com" value="{{old('email')?old('email'):request()->email}}"
                                   name="email" required>
                            @if ($errors->register->has('email'))
                                <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ __($errors->register->first('email')) }}</small>
                                    </span>
                            @endif

                        </div>
                        {{--Password input--}}
                        <div class="form-group m-b-25 pswd">
                            <label class="required" for="pwd">{!! __('Password') !!}</label>
                            <div class="pswd-field">
                                <input type="password" class="form-control " id="pwd" placeholder="********"
                                       name="password" required>
                                <i class="far fa-eye-slash"></i>
                                @if ($errors->register->has('password'))
                                    <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ __($errors->register->first('password')) }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{--Confirm password input--}}
                        <div class="form-group m-b-25 pswd">
                            <label class="required" for="pwd">{!! __('Confirm Password') !!}</label>
                            <div class="pswd-field">
                                <input type="password" class="form-control " id="pwd" placeholder="********"
                                       name="password_confirmation" required>
                                <i class="far fa-eye-slash"></i>
                            </div>
                        </div>

                        {{--terms and conditions--}}
                        <div class="form-group form-check m-b-25">
                            <label class="checkbox-container forget-paswd">{!! __('By Signing up, I agree to') !!} <a
                                        href="{{ route('front.pages', ['slug' => config('settings.terms_and_conditions')]) }}" target="_blank">{!! __('Terms & Conditions') !!}</a>
                                {!! __('and') !!}
                                <a href="{{ route('front.pages', ['slug' => config('settings.privacy_policy')]) }} " target="_blank">{!! __('Privacy Policy') !!}</a>

                                <input type="checkbox" checked="checked" name="terms&conditions">
                                <span class="checkmark"></span>
                            </label>
                            @if ($errors->register->has('conditions'))
                                <span class="help-block">
                                        <smal class="text-danger font-weight-bold gothic-normel">{{ __($errors->register->first('conditions')) }}</smal>
                                    </span>
                            @endif
                        </div>
                        <input type="hidden" name="{!! request()->platform.'_id' !!}" value="{!! request()->id !!}">

                        {{--Register button--}}
                        <div class="ful-btn form-group m-b-25">
                            <button type="submit" class="btn btn--primary btn-block" >{!! __('Register') !!}</button>
                        </div>
                        <div class="already-acc">
                            <p class="desc text-center">{!! __('Already have an account?') !!} <a href="{{route('front.auth.login')}}"
                                                                                                  class="semi-bold-weight black">{!! __('Login Now') !!}</a></p>
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