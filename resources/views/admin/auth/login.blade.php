@extends('admin.layouts.login')

@section('content')
    <div class="m-login__signin">
        <div class="m-login__head">
            <h3 class="m-login__title">
                {{config('settings.sign_in_text_login_page')}}
            </h3>
        </div>
        <form class="m-login__form m-form" action="{!! route('admin.auth.login.login') !!}" METHOD="post">
            {{ csrf_field() }}
            <div class="form-group m-form__group {{ $errors->has('email') ? ' has-error' : '' }}">
                <input class="form-control m-input"  value="{{old('email')}}"  type="text" placeholder="Email" name="email" autocomplete="off" required>
            </div>
            {{--@if ($errors->has('email'))--}}
                {{--<div class="form-control-feedback">{{ $errors->first('email') }}</div>--}}
            {{--@endif--}}
            <div class="form-group m-form__group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password" required>
            </div>
            {{--@if ($errors->has('password'))--}}
                {{--<div class="form-control-feedback">{{ $errors->first('password') }}</div>--}}
            {{--@endif--}}
            <div class="row m-login__form-sub">
                <div class="col m--align-left m-login__form-left">
                    <label class="m-checkbox  m-checkbox--light">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                        <span></span>
                    </label>
                </div>
                <div class="col m--align-right m-login__form-right">
                    <a href="{!! route('admin.auth.forgot-password.show-link-request-form') !!}" id="m_login_forget_password" class="m-link">
                        Forget Password ?
                    </a>
                </div>
            </div>
            <div class="m-login__form-action">
                <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                    Sign In
                </button>
            </div>
        </form>
    </div>
@endsection