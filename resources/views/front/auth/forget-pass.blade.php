@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

<!-- forget-password -->
<section class="forgot-password center-page spacing">
    <div class="container">
        <div class="box">
            <div class="form">
                <div class="text-center">
                    <h2 class="secondary-headline secondary-headline-black">
                        Forgot Password
                        <span class="left-border"></span>
                    </h2>
                </div>
                <form action="{{route('front.auth.forgot-password.submit')}}" method="post">
                    @csrf
                    <p class="desc m-b-25">
                        {!! __('Enter your email to recover password') !!}
                    </p>
                    {{--Input--}}
                    <div class="form-group m-b-25">
                        <input type="email" class="form-control required" id="email"
                               placeholder="{!! __('e.g johndoe@example.com') !!}" name="email" required>
                    </div>
                    @if($errors->has('email'))
                        <span class="help-block">
                                        <small class="gothic-normel font-weight-bold text-danger d-block my-1">{{ $errors->first('email') }}</small>
                                    </span>
                    @endif
                    {{--/ input--}}
                    <div class="row">
                        <div class="col-12">
                            <div class="ful-btn form-group m-b-25">
                                <button type="submit" class="btn btn-block btn--primary btn--animate">{!! __('Submit') !!}</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
<!-- forget-password -->

@endsection