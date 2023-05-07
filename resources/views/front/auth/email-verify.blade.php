@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <section class="forgot-password center-page spacing email-verifcation">
    <div class="container">
        <div class="box">
            <div class="form">
                <div class="text-center">
                    <h2 class="secondary-headline secondary-headline-black">
                        {!! __('Email Verification') !!}
                        <span class="left-border"></span>
                    </h2>
                </div>

                <form action="{{route('front.verification.submit')}}" method="post">
                    @csrf
                    <p class="desc m-b-25">
                        {!! __('A verification code is sent to your email. Please check your email and enter code below.') !!}
                    </p>
                    <div class="form-group m-b-25">
                        <input type="text" class="form-control required" id="verification_code"
                               placeholder="e.g 1234" name="verification_code" required>
                        @if($errors->has('verification_code'))
                            <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel d-block my-1">{{ __($errors->first('verification_code')) }}</small>
                                    </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="ful-btn">
                                <a href="javascript:void(0)" class="btn btn--black btn--animate btn-block verify-btn-resend">{!! __('resend') !!}</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="ful-btn form-group">
                                <button type="submit" class="btn btn-block btn--primary btn--animate">{!! __('submit') !!}</button>
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
        $(document).ready(function () {
            $('.verify-btn-resend').on('click',function () {
                $.ajax({
                    url: window.Laravel.baseUrl+"verification-resend",
                    success: function (res) {
                        toastr.success('success',"{!! __('Verification code resent on your email address') !!}");
                    }
                })
            })
        })
    </script>


@endpush