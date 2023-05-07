@extends('admin.layouts.app')

@section('breadcrumb')
@include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/adv_datatables/products.js')}}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Tyre
                        <small>
                            Here You Can Add, Edit or Delete Tyre
                        </small>
                    </h3>
                </div>
            </div>
            @if($userData['role_id']!=config('settings.supplier_role'))
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                 data-dropdown-toggle="hover" aria-expanded="true">
                                <form action="{{route('admin.importExcelData')}}" class="d-inline-block" method="POST" id="excel-form"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="m-portlet__head-caption d-inline-block mr-3">
                                        <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text" id="excel-file-heading" style="display: none">
                                        Uploaded File:
                                        <small id="excel-file-name">
                                            This is the new file
                                        </small>
                                    </h3>
                                        </div>
                                        </div>
                                    <label class="mb-0 btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                        <input type="file" name="excel_import" id="excel-file-input" class="hide product_upload_image_input d-none">
                                        <i class="fa fa-spinner fa-spin" style=" display: none"></i>
                                        Upload Excel
                                    </label>
                                    <button type="button" id="excel-form-button" class="mb-0 btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" disabled title="Upload file to enable this button">
                                        <i class="fa fa-spinner fa-spin" id="spinner" style=" display: none"></i>
                                        Submit Excel
                                    </button>
                                </form>
                                <a href="{!! route('admin.products.edit', ['product' => 0]) !!}"
                                   class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Tyre
                                    </span>
                                </span>
                                </a>

                            </div>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
        {{--<div class="m-portlet__body">--}}
            {{--<!--begin: Search Form -->--}}
            {{--<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">--}}
                {{--<div class="row align-items-center">--}}
                    {{--<div class="col-xl-12 order-2 order-xl-1">--}}
                        {{--<form class="form-group m-form__group row align-items-center" action="" id="manage-product-search">--}}
                            {{--<div class="col-md-12" style="margin-top: -22px;margin-bottom: 15px;">--}}
                                {{--<h3>Advance Search for Products</h3>--}}
                            {{--</div>--}}



                            {{--<div class="col-md-4 m--margin-bottom-10">--}}
                                {{--<div class="m-form__group m-form__group--inline">--}}
                                    {{--<div class="m-form__label">--}}
                                        {{--<label>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="m-form__control">--}}
                                        {{--<input type="text" class="form-control m-bootstrap-select" name="title" placeholder="Title">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-4">--}}
                                {{--<button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Submit</button>--}}
                                {{--<button id="page-reset" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Reset</button>--}}
                            {{--</div>--}}

                        {{--</form>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
            {{--<!--end: Search Form -->--}}
            {{--<!--begin: Selected Rows Group Action Form -->--}}
            {{--<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30 collapse" id="m_datatable_group_action_form_page">--}}
                {{--<div class="row align-items-center">--}}
                    {{--<div class="col-xl-12">--}}
                        {{--<div class="m-form__group m-form__group--inline">--}}
                            {{--<div class="m-form__label m-form__label-no-wrap">--}}
                                {{--<label class="m--font-bold m--font-danger-">--}}
                                    {{--Selected--}}
                                    {{--<span id="m_datatable_selected_page"></span>--}}
                                    {{--records:--}}
                                {{--</label>--}}
                            {{--</div>--}}
                            {{--<div class="m-form__control">--}}
                                {{--<div class="btn-toolbar">--}}

                                    {{--&nbsp;&nbsp;&nbsp;--}}
                                    {{--<button class="btn btn-sm btn-danger" type="button" id="m_datatable_check_all_pages">--}}
                                        {{--Delete--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}


            {{--<div class="manage-pages" id="local_data"></div>--}}
            {{--<!--end: Datatable -->--}}
        {{--</div>--}}
        <div class="m-portlet__body">
            <!--begin: Search Form -->

            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="manage-products" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection

@push('script-page-level')
    <script>
        $("#excel-form").change(function(){
            $('#excel-form-button').enable();
            $('#excel-file-name').html($('#excel-file-input').val().replace(/C:\\fakepath\\/i, ''));
            $('#excel-form-button').attr('title','Import uploaded excel file');
            $('#excel-file-heading').show();
        })
        $('#excel-form-button').on('click', function (){
            swal({
                    title: "Are You Sure You Want To Upload This File?",
                    text: $('#excel-file-input').val().replace(/C:\\fakepath\\/i, ''),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        swal.close()
                        $('#spinner').show()
                        $('#excel-form').submit()
                            // .done(function(res){ toastr.success("You have deleted inquiry successfully!"); location.reload(); })
                            // .fail(function(res){ toastr.success("You have deleted inquiry successfully!"); t.reload();  });
                    } else {
                        swal.close()
                    }
                });
        });
    </script>
@endpush

