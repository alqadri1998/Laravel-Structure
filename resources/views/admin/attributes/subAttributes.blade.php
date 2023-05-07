@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script>
        var appId = {id :"{{$id}}"};
    </script>
    <script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/adv_datatables/subAttributes.js')}}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                   Sub Attributes
                    <small>
                        Here You Can Add, Edit or Delete sub Attribute
                    </small>
                </h3>
            </div>
        </div>
        @if($userData['role_id']!=config('settings.supplier_role'))
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="{!! route('admin.attributes.sub-attributes.edit',[$id,0]) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Sub Attribute
                                    </span>
                                </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        @endif
    </div>
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


    <div class="manage-pages" id="local_data"></div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->

            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="manage-subAttributes" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    <!--end: Datatable -->
    </div>


@endsection
