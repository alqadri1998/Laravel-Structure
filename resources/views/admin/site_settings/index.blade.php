@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
<script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/adv_datatables/site-settings.js')}}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Site Settings
                        <small>
                            Here You Can Edit Site Setting Values
                        </small>
                    </h3>
                </div>
            </div>
{{--            <div class="m-portlet__head-tools">--}}
{{--                <ul class="m-portlet__nav">--}}
{{--                    <li class="m-portlet__nav-item">--}}
{{--                        <div class="dropdown show">--}}
{{--                            <button class="btn btn-accent dropdown-toggle dropdown-menu-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                Action--}}
{{--                            </button>--}}
{{--                            <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton" x-placement="bottom-end" style="position: absolute; transform: translate3d(-9px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">--}}
{{--                                <a class="dropdown-item" href="{!! route('admin.site-settings.edit', 0) !!}">--}}
{{--                                    <i class="fa fa-plus"></i>--}}
{{--                                    Add value--}}
{{--                                </a>--}}
{{--                                <a class="dropdown-item clear-cache-button" href="javascript:{}" id="clear-route-button" data-url="{!! route('admin.site-settings.clear-route-cache',0) !!}">--}}
{{--                                    <i class="fa fa-eraser"></i>--}}
{{--                                    Clear Routes Cache--}}
{{--                                </a>--}}
{{--                                <a class="dropdown-item clear-cache-button" href="javascript:{}" id="clear-storage-button" data-url="{!! route('admin.site-settings.clear-storage-cache', 0) !!}">--}}
{{--                                    <i class="fa fa-eraser"></i>--}}
{{--                                    Clear Storage Cache--}}
{{--                                </a>--}}
{{--                                <a class="dropdown-item clear-cache-button" href="javascript:{}" id="clear-config-button" data-url="{!! route('admin.site-settings.clear-config-cache', 0) !!}">--}}
{{--                                    <i class="fa fa-eraser"></i>--}}
{{--                                    Clear Config Cache--}}
{{--                                </a>--}}
{{--                                <a class="dropdown-item clear-cache-button" href="javascript:{}" id="clear-view-button" data-url="{!! route('admin.site-settings.clear-view-cache', 0) !!}">--}}
{{--                                    <i class="fa fa-eraser"></i>--}}
{{--                                    Clear Views Cache--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}

        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    {{--<div class="col-xl-12 order-2 order-xl-1">--}}
                        {{--<form class="form-group m-form__group row align-items-center" action="" id="manage-setting-search">--}}
                            {{--<div class="col-md-3">--}}
                                {{--<div class="m-form__group m-form__group--inline">--}}
                                    {{--<div class="m-form__label">--}}
                                        {{--<label class="m-label m-label--single">--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="m-form__control">--}}
                                        {{--<input type="text" id="setting-key" name="key" class="form-control" placeholder="Key">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="d-md-none m--margin-bottom-10"></div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-3">--}}
                                {{--<button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Submit</button>--}}
                                {{--<button id="setting-reset" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Reset</button>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}

                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="manage-settings" id="local_data">
            </div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection




