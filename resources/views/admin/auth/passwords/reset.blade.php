

@extends('admin.layouts.login')

@section('content')
    <div class="">
        <div class="m-login__head">
            <h3 class="m-login__title">
                {!! __('Reset Password') !!}
            </h3>
            <div class="m-login__desc">
                Enter your desired password
            </div>
        </div>
        <form class="m-login__form m-form" action="{!! route('admin.auth.forgot-password.reset') !!}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group m-form__group">
                <input class="form-control m-input" type="email" placeholder="Email" name="email" id="m_email" autocomplete="off" required value="{{ $email or old('email') }}">
            </div>
            @if ($errors->has('email'))
                <div class="form-control-feedback">{{ $errors->first('email') }}</div>
            @endif
            <div class="form-group m-form__group">
                <input class="form-control m-input" type="password" placeholder="Password" name="password" id="m_email" autocomplete="off" required>
            </div>
            @if ($errors->has('password'))
                <div class="form-control-feedback">{{ $errors->first('password') }}</div>
            @endif
            <div class="form-group m-form__group">
                <input class="form-control m-input" type="password" placeholder="Confirm Password" name="password_confirmation" id="m_email" autocomplete="off" required>
            </div>
            @if ($errors->has('password_confirmation'))
                <div class="form-control-feedback">{{ $errors->first('password_confirmation') }}</div>
            @endif
            <div class="m-login__form-action">
                <button type="submit" id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                    Request
                </button>
                &nbsp;&nbsp;
                <a href="{!! route('admin.auth.login.show-login-form') !!}" id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
