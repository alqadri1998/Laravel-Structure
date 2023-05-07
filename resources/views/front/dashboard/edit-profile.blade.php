@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
<section class="custom-sec-inner-account">
    <div class="dashborad-ses">
        <div class="container">
            <div class="row">
        @include('front.dashboard.common.left-navbar')
                <div class="col-md-12 col-lg-9">
                    <form action="{{route('front.dashboard.update-profile')}}" method="post" class="row">
                        @csrf
                        <div class="col-md-12">
                            <h2 class="my-account-tittle">{{__('Account Information')}}</h2>
                        </div>
                        <!-- Inputs -->
                        <div class="col-md-6">
                            <div class="appoint-ment-main-fieldss">
                                <div class="form-group  m-b-25">
                                    <label class="label-appoint-field">{{__('first name')}}</label>
                                    <input type="text" class="form-control required " id="text-1"
                                           placeholder="Your first name" value="{{$user->first_name}}" name="first_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="appoint-ment-main-fieldss">
                                <div class="form-group  m-b-25">
                                    <label class="label-appoint-field">{{__('last name')}}</label>
                                    <input type="text" class="form-control required " id="text-1"
                                           placeholder="Your last name" value="{{$user->last_name}}" name="last_name" required>
                                </div>
                            </div>
                        </div>
                        <div id="emailInput" class="col-md-6">
                            <div class="appoint-ment-main-fieldss">
                                <div class="form-group  m-b-25">
                                    <label class="label-appoint-field">{{__('Email')}}</label>
                                    <input type="text" class="form-control required " id="text-1"
                                           placeholder="jhondoe@email.com" value="{{$user->email}}" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div id="newPasswordInput" class="col-md-6">
                            <div class="appoint-ment-main-fieldss">
                                <div class="form-group  m-b-25">
                                    <label class="label-appoint-field">{{__('New Password')}}</label>
                                    <input type="password" class="form-control required " id="text-1"
                                           placeholder="****" name="new_password">
                                </div>
                            </div>
                        </div>

                        <div id="currentPasswordInput" class="col-md-6">
                            <div class="appoint-ment-main-fieldss">
                                <div class="form-group  m-b-25">
                                    <label class="label-appoint-field">{{__('Current Password')}}</label>
                                    <input type="password" class="form-control required " id="text-1"
                                           placeholder="****" name="current_password">
                                </div>
                            </div>
                        </div>

                        {{--/ Inputs--}}
                        <div class="col-md-12">
                            <div class="inner-account-info-check">
                                <div class="form-check pl-0">
                                    <label class="container">{{__('Change Email')}}
                                        <input type="checkbox" name="change_email">
                                        <span class="checkmark"></span>
                                    </label>

                                </div>
                            </div>


                        </div>
                        <div class="col-md-12 mt-4 pt-4">
                            <div class="inner-account-info-check">
                                <div class="form-check pl-0">
                                    <label class="container">{{__('Change Password')}}
                                        <input type="checkbox" name="change_password" >
                                        <span class="checkmark"></span>
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-5">
                            <h2 class="my-account-tittle pb-1">{{__('Profile Image')}}</h2>
                        </div>
                        <div class="col-md-12">
                                <div class="row">
                                    <div class="">
                                        <div class="qust-filed form-group">
                                            <div class="upload-file form-control py-2 file-type rounded-0  d-flex align-items-center justify-content-center">
                                                <input type="file" name="file" id="file" class="input-file hide upload_image_input"  accept="image/*" >
                                                <input id="public_upload_image_input" class="d-none" type="text" value="{{$user->user_image}}" name="user_image" />
                                                <label for="file" class="btn-tertiary js-labelFile">
                                                    <span class="js-fileName">Add Image</span>
                                                    <i class="icon fa fa-plus-circle"></i>
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="qust-filed form-group">
                                            <div class="upload-file-2 form-control py-2 file-type rounded-0  d-flex align-items-center justify-content-center">
                                                <input type="file" name="file" id="file" class="input-file">
                                                <label for="file" class="btn-tertiary js-labelFile">
                                                    <!-- <span class="js-fileName">Add Image</span> -->
                                                    @if($user->user_image)
                                                        <img style="width: 162px; height: 120px;" src="{!! imageUrl(url($user->user_image), 162, 120, 100, 1) !!}" class="selected-image" id="image">
                                                    @else
                                                        <i class="fas fa-image"></i>
                                                    @endif

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-botm-custom">

                                    </div>

                                </div>
                        </div>
                        <div class="col-md-12">
                            <div class="location-btn-book-address mt-3">
                                <button type="submit" class="btn btn--primary btn--animate">{{__('Save')}}</button>
                            </div>

                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
@push('script-page-level')
    <script>
        $(document).ready(function () {

            $("#emailInput").hide()
            $("#newPasswordInput").hide()
            $("#currentPasswordInput").hide()

            $('.upload_image_input').on('change', function () {
                var fileData = $(this).prop("files")[0];
                var formData = new FormData();
                formData.append("image", fileData);
                var url = window.Laravel.baseUrl + 'user/upload-image';
                if (url.length > 0) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': window.Laravel.csrfToken
                        }
                    })
                        .done(function (res) {

                            $('#public_upload_image_input').val(res.data);
                            $('.selected-image').attr('src', window.Laravel.base + res.data);
                            toastr.success(res.message, 'Success');
                            // $(".delete-image").removeClass('d-none');
                            // $('button.close').click();
                        })
                        .fail(function (res) {
                            alert('Something went wrong, please try later.');
                        });
                }
            });

            $(document).on('click', '.delete-image', function () {
                var imagePath = $('#public_upload_image_input').val();
                let url = window.Laravel.baseUrl + 'user/delete-image';
                $.ajax({
                    url: url,
                    type: 'post',
                    data: 'image_path= ' + imagePath,
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                    }
                })
                    .done(function (res) {
                        $('#public_upload_image_input').val('');
                        $('.selected-image').attr('src', '');
                        toastr.success(res.message);
                        $(".delete-image").addClass('d-none');
                        $("#public_upload_image_input").val('images/default_profile.jpg')
                    })
                    .fail(function (res) {
                        toastr.error("Something went wrong, please refresh.");
                    });

            });
        })









        $('input:checkbox[name="change_email"]').change(function () {
                if ($(this).is(':checked')) {
                    $("#emailInput").show()
                    $("#currentPasswordInput").show()

                } else {
                    $("#emailInput").hide()
                    $("#currentPasswordInput").hide()
                    newPassword()
                }
            }
        );

        $('input:checkbox[name="change_password"]').change(function () {
                if ($(this).is(':checked')) {
                    $("#newPasswordInput").show()
                    $("#currentPasswordInput").show()

                } else {
                    $("#newPasswordInput").hide()
                    $("#currentPasswordInput").hide()
                    newEmail()
                }
            }
        );

        function newPassword() {
            if ($('input:checkbox[name="change_password"]').is(':checked')) {
                $("#newPasswordInput").show()
                $("#currentPasswordInput").show()
            }

        }

        function newEmail() {
            if ($('input:checkbox[name="change_email"]').is(':checked')) {
                $("#emailInput").show()
                $("#currentPasswordInput").show()
            }
        }


    </script>
@endpush