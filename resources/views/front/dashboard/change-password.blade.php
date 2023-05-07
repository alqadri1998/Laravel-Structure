@extends('front.layouts.app')
@section('content')
@include('front.common.breadcrumb')
<!-- change-password -->
<section class="change-pass padding-to-sec login-section ">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3">
                @include('front.dashboard.common.left-navbar')
            </div>
            <div class="col-12 col-md-8 col-lg-9">
                <div class="change-pass">
                    <form action="{!! route('front.dashboard.password.update') !!}" method="post">
                        @csrf
                        <h1 class="text-uppercase black c-f ">
                            {!! __('Current Password') !!}
                        </h1>
                        <p class="black pb">
                            {!! __('Current Password') !!}<span class="text-danger">*</span>
                        </p>
                        <div class="custom-build col-12 col-md-6 ppp">
                                <div class="form-group mb-4">
                                <div class="custm-build">
                                    <input type="password" name="current_password"
                                           class="form-control p-r f-input-cls pswd-pad" id="current_password"
                                           placeholder="******" required>
                                    <i class="fa fa-eye-slash ank" aria-hidden="true"></i>
                                    @if ($errors->has('current_password'))
                                        <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ __($errors->first('current_password')) }}</small>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                      
                        <!-- <input type="password" name="current_password" placeholder="******" class="f-input-cls mb-4 special-width" required> -->
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h1 class="text-uppercase  black c-f">
                                    {!! __('add New Password') !!}
                                </h1>
                                <p class="black pb">
                                    {!! __('New Password') !!}<span class="text-danger">*</span>
                                </p>
                                <div class="form-group mb-4">
                                <div class="custm-build">
                                    <input type="password" name="password"
                                           class="form-control p-r f-input-cls pswd-pad" id="password"
                                           placeholder="******" required>
                                    <i class="fa fa-eye-slash ank" aria-hidden="true"></i>
                                </div>

                            </div>

                            </div>
                            <div class="col-12 col-md-6">
                                <p class="black pb pt">
                                    {!! __('Confirm New Password') !!}<span class="text-danger">*</span>
                                </p>

                                <div class="form-group mb-4">
                                <!-- <label for="password" class="black text-capitalize gothic-normel">Password <span class="text-danger">*</span></label> -->
                                <div class="custm-build">
                                    <input type="password" name="password_confirmation"
                                           class="form-control p-r f-input-cls pswd-pad" id="password"
                                           placeholder="******" required>
                                    <i class="fa fa-eye-slash ank" aria-hidden="true"></i>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ __($errors->first('password')) }}</small>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            </div>
                        </div>
                        <button type="submit" class="mt-btn-primary change-pass-btn">{!! __('save') !!}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /change-password -->
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