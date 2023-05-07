@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    @include('admin.common.upload-gallery-js-links')
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
{{--                            @if($category->id >0)--}}
{{--                                <li class="nav-item m-tabs__item">--}}
{{--                                    <a class="nav-link m-tabs__link " data-toggle="tab" href="#tab_ar" role="tab"--}}
{{--                                       id="test0">--}}
{{--                                        <i class="flaticon-share m--hide"></i>--}}
{{--                                        عربى--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
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
{{--                    @if($category->id > 0)--}}
{{--                        <div class="tab-pane " id="tab_ar">--}}
{{--                            @include('admin.categories.form', ['languageId' => $locales['ar']])--}}

{{--                        </div>--}}
{{--                    @endif--}}
                    <div class="tab-pane active" id="tab_en">
                        @include('admin.catalog.form', ['languageId' => $locales['en']])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
