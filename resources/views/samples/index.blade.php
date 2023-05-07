<?php
echo '
@extends(\'admin.layouts.app\')

@section(\'breadcrumb\')
@include(\'admin.common.breadcrumbs\')
@endsection

@push(\'stylesheet-page-level\')
@endpush

@push(\'script-page-level\')
    <script src="{{asset(\'assets/admin/js/adv_datatables/csrf_token.js\')}}" type="text/javascript"></script>
    <script src="{{asset(\'assets/admin/js/adv_datatables/'.$view.'.js\')}}" type="text/javascript"></script>
@endpush

@section(\'content\')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        '.ucwords(str_replace('-', ' ', $model)).'
                        <small>
                            Here You Can Add, Edit or Delete '.ucwords(str_replace('-', ' ', $model)).'
                        </small>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="{!! route(\'admin.'.$view.'.edit\', [\''.strtolower($model).'\' => 0]) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add '.ucwords(str_replace('-', ' ', $model)).'
                                    </span>
                                </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->

            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="manage-'.$view.'" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection

';