@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
    <style>
        .mce-notification-warning{
            display: none;}
        .btn.btn-outline.dark {
            border-color: #2f353b;
            color: #2f353b;
            background: 0 0;
        }
    </style>
@endpush

@push('script-page-level')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 200,
            theme: 'modern',
            valid_elements : '*[*]',
            verify_html : false,
            plugins: 'print code preview powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
            toolbar1: 'code | formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            toolbar2: 'undo redo | styleselect | bold italic | link image | alignjustify | formatselect | fontselect | fontsizeselect | cut | copy | paste | outdent | indent | blockquote | alignleft | aligncenter | alignright | code | spellchecker | searchreplace | fullscreen | insertdatetime | media | table | ltr | rtl ',
            image_advtab: true,
            automatic_uploads: false,
            images_upload_credentials: true,
//        images_upload_base_path: '{!! url("admin") !!}',
            images_upload_url: "{!! route('admin.home.save-image') !!}",
//            templates: [
//                { title: 'Test template 1', content: 'Test 1' },
//                { title: 'Test template 2', content: 'Test 2' }
//            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        }).then(function(editors) {
            // console.log('it ran')
            $('#mceu_95').hide();
        });

    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#english" role="tab" id="test1">
                                    <i class="flaticon-share m--hide"></i>
                                    English
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link " data-toggle="tab" href="#arabic" role="tab" id="test" >
                                    <i class="flaticon-share m--hide"></i>
                                    عربى
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane " id="arabic">
                        @include('admin.faqs.form', ['languageId' => $locales['ar']])
                    </div>
                    <div class="tab-pane active" id="english">
                        @include('admin.faqs.form', ['languageId' => $locales['en']])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
