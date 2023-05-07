@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if (session('status'))
        <div class="alert alert-success">{!! __(session('status')) !!}</div>
        @endif
        @if (session('err'))
        <div class="alert alert-danger">{!! __(session('err')) !!}</div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{!! __('Update Profile') !!}</div>
                <div class="panel-body">
                    {!! Form::model($userData, ['route' => 'home.update-profile', 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal']) !!}
                    <div class="form-group{!! $errors->has('first_name') ? ' has-error' : '' !!}">
                        <label for="first_name" class="col-md-4 control-label">{!! __('First Name') !!}</label>
                        <div class="col-md-6">
                            {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'required' => 'required', 'id' => 'first_name']) !!}
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{!! __($errors->first('first_name')) !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{!! $errors->has('last_name') ? ' has-error' : '' !!}">
                        <label for="name" class="col-md-4 control-label">{!! __('Last Name') !!}</label>
                        <div class="col-md-6">
                            {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'required' => 'required', 'id' => 'last_name']) !!}
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{!! __($errors->first('last_name')) !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{!! $errors->has('mobile') ? ' has-error' : '' !!}">
                        <label for="mobile" class="col-md-4 control-label">{!! __('Mobile') !!}</label>
                        <div class="col-md-6">
                            {!! Form::text('mobile', old('mobile'), ['class' => 'form-control', 'required' => 'required', 'id' => 'mobile']) !!}
                            @if ($errors->has('mobile'))
                                <span class="help-block">
                                    <strong>{!! __($errors->first('mobile')) !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">{!! __('Update') !!}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{!! __('Update Password') !!}</div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'home.update-password', 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal']) !!}
                    <div class="form-group{!! $errors->has('current_password') ? ' has-error' : '' !!}">
                        <label for="current_password" class="col-md-4 control-label">{!! __('Current Password') !!}</label>
                        <div class="col-md-6">
                            <input id="current_password" type="password" class="form-control" name="current_password" required>
                            @if ($errors->has('current_password'))
                                <span class="help-block">
                                    <strong>{!! __($errors->first('current_password')) !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{!! $errors->has('password') ? ' has-error' : '' !!}">
                        <label for="password" class="col-md-4 control-label">{!! __('Password') !!}</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{!! __($errors->first('password')) !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">{!! __('Confirm Password') !!}</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">{!! __('Update') !!}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection