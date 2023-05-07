@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
<script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/adv_datatables/translations.js')}}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Translations
                        <small>
                            Here You Can Add, Edit or Delete Translations
                        </small>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="{!! route('admin.translations.edit', ['new']) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Translations
                                    </span>
                                </span>
                            </a>
                        </div>
                    </li>
                    {{--<li class="m-portlet__nav-item">--}}

                        {{--<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">--}}

                            {{--<a href="{!! route('admin.translations.export-csv',  0 ) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">--}}

                                {{--<span>--}}

                                    {{--<i class="fa fa-file-excel-o"></i>--}}

                                    {{--<span>--}}

                                       {{--Export CSV Translations--}}

                                    {{--</span>--}}

                                {{--</span>--}}

                            {{--</a>--}}

                        {{--</div>--}}

                    {{--</li>--}}


                    {{--<li class="m-portlet__nav-item">--}}

                        {{--<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">--}}

                            {{--<a href="{!! route('admin.translations.import-csv', ['translations'=> 0 ]) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">--}}

                                {{--<span>--}}

                                    {{--<i class="fa fa-file-excel-o"></i>--}}

                                    {{--<span>--}}

                                       {{--Export CSV Translations--}}

                                    {{--</span>--}}

                                {{--</span>--}}

                            {{--</a>--}}

                        {{--</div>--}}

                    {{--</li>--}}
                    {{--<li class="m-portlet__nav-item">--}}
                        {{--<form style="margin: 0px;" action="{{ route('admin.translations.import-csv') }}" class="form-horizontal" method="post" enctype="multipart/form-data">--}}
                            {{--{{@csrf_field()}}--}}
                            {{--<div class="input-file-upload">--}}
                                {{--<label class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill"  style="max-width: 341px;padding: 7px 15px;margin-top: 6px;">--}}
                                     {{--<i class="fa fa-file-excel-o" aria-hidden="true"></i>--}}
                                    {{--<input type="file" name="import_file" />--}}
                                {{--</label>--}}
                            {{--</div>--}}
                        {{--<!-- </form> -->--}}
                    {{--</li>--}}

                    {{--<li class="m-portlet__nav-item">--}}
                        {{--<!-- <form style="margin: 0px;" action="{{ route('admin.translations.import-csv') }}" class="form-horizontal" method="post" enctype="multipart/form-data"> -->--}}
                            {{--{{@csrf_field()}}--}}
                            {{--<button class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Import File</button>--}}
                        {{--</form>--}}
                    {{--</li>--}}






                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <form class="form-group m-form__group row align-items-center" action="" id="manage-leads-search">
                            <div class="col-md-3">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label class="m-label m-label--single">
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text" id="key" name="key" class="form-control" placeholder="Key">
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <div class="col-md-3" style="margin-top: 0px">
                                <button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Submit</button>
                                <button id="reset" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Reset</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="manage-translations" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection




