@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    @include('admin.common.upload-gallery-js-links')
    @include('admin.common.tinymce-script')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary"
                            role="tablist">
                            @if($service->id >0)
{{--                                <li class="nav-item m-tabs__item">--}}
{{--                                    <a class="nav-link m-tabs__link " data-toggle="tab" href="#tab_ar" role="tab"--}}
{{--                                       id="test0">--}}
{{--                                        <i class="flaticon-share m--hide"></i>--}}
{{--                                        عربى--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                            @endif
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#tab_en" role="tab"
                                   id="test1">
                                    <i class="flaticon-share m--hide"></i>
                                    English
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    @if($service->id > 0)
                        <div class="tab-pane " id="tab_ar">
                            @include('admin.services.form', ['languageId' => $locales['ar']])
                        </div>
                    @endif
                    <div class="tab-pane active" id="tab_en">
                        @include('admin.services.form', ['languageId' => $locales['en']])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-page-level')
    <script>
        $('.upload-icon').on('click', function () {
            $(this).next().click();
        });

        $('.upload_icon_input').on('change', function () {
            var fileData = $(this).prop("files")[0];
            var formData = new FormData();
            formData.append("image", fileData);
            var url = window.Laravel.baseUrl + 'upload-image';
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
                        foldersDir();
                        $('.public_select_icon').val(res.data);
                        $('.selected-icon').attr('src', imageUrl(window.Laravel.base + res.data, 120, 120, 100, 1));
                        if (res.success == false) {
                            toastr.error(res.message, 'Error');
                        } else {
                            $(".select_image").show();
                            toastr.success(res.message, 'Success');
                        }
                        $('button.close').click();
                    })
                    .fail(function (res) {
                        alert('Something went wrong, please try later.');
                    });
            }
        });
    </script>
@endpush
