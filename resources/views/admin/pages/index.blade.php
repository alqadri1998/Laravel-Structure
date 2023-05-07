@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
<script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/adv_datatables/pages.js')}}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Pages
                        <small>
                            Here You Can Add, Edit or Delete Pages
                        </small>
                    </h3>
                </div>
            </div>

         {{--   <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="{!! route('admin.pages.edit', $pages = 0) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Page
                                    </span>
                                </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>--}}

        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            {{--<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <form class="form-group m-form__group row align-items-center" action="" id="manage-page-search">
                            <div class="col-md-12" style="margin-top: -22px;margin-bottom: 15px;">
                                <h3>Advance Search for Pages</h3>
                            </div>
                            <div class="col-md-4 m--margin-bottom-10">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text" class="form-control m-bootstrap-select" name="slug" placeholder="Slug">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 m--margin-bottom-10">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text" class="form-control m-bootstrap-select" name="title" placeholder="Title">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 m--margin-bottom-10">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
                                            <input type="checkbox" name="trashedPages"  id="show-trashed-pages">
                                            Show Trashed Pages
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="page-deleted-at" style="display:none;" class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text"  class="form-control m-bootstrap-select mt-datetime-picker" name="deletedAt" placeholder="deleted At">
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <div id="page-created-at" class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text" class="form-control m-bootstrap-select mt-datetime-picker" name="createdAt" placeholder="Created At">
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <div id="page-updated-at" class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text" class="form-control m-bootstrap-select mt-datetime-picker" name="updatedAt" placeholder="Updated At">
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Submit</button>
                                <button id="page-reset" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>--}}
            <!--end: Search Form -->
            <!--begin: Selected Rows Group Action Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30 collapse" id="m_datatable_group_action_form_page">
                <div class="row align-items-center">
                    <div class="col-xl-12">
                        <div class="m-form__group m-form__group--inline">
                            <div class="m-form__label m-form__label-no-wrap">
                                <label class="m--font-bold m--font-danger-">
                                    Selected
                                    <span id="m_datatable_selected_page"></span>
                                    records:
                                </label>
                            </div>
                            <div class="m-form__control">
                                <div class="btn-toolbar">

                                    &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-sm btn-danger" type="button" id="m_datatable_check_all_pages">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Selected Rows Group Action Form -->
            <!--begin: Selected Rows Group Restore Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30 collapse" id="m_datatable_group_action_form_page_restore">
                <div class="row align-items-center">
                    <div class="col-xl-12">
                        <div class="m-form__group m-form__group--inline">
                            <div class="m-form__label m-form__label-no-wrap">
                                <label class="m--font-bold m--font-danger-">
                                    Selected
                                    <span id="m_datatable_selected_page_restore"></span>
                                    records:
                                </label>
                            </div>
                            <div class="m-form__control">
                                <div class="btn-toolbar">
                                    &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-sm btn-success" type="button" id="m_datatable_check_all_pages_restore">
                                        Restore
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Selected Rows Group Restore Form -->
            <!--begin: Datatable -->
            <div class="manage-pages" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection




