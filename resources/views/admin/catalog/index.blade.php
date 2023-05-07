@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    {{--<script src="{{asset('assets/admin/js/adv_datatables/categories.js?v=11222')}}" type="text/javascript"></script>--}}
    <script>
        $(document).ready(function () {
            $('.delete-record-button').on('click', function(e){
                var url = $(this).data('url');
                console.log(url);
                swal({
                        title: "Are You Sure You Want To Delete This?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        showLoaderOnConfirm: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                type: 'delete',
                                url: url,
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                                }
                            })
                                .done(function(res){ toastr.success("Catalog Deleted Successfully!");
                                    swal.close();
                                location.reload();
                                })
                                .fail(function(res){ toastr.success("You have deleted inquiry successfully!");   });
                        } else {
                            swal.close();
                        }
                    });
            });
        })
    </script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">

        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Catalogues
                        <small>
                            Here You Can Add, Edit or Delete Catalog
                        </small>
                    </h3>
                </div>
            </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                                <a href="{!! route('admin.catalogues.edit', 0) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Catalog
                                    </span>
                                </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
        </div>
        <div class="m-portlet__body padding-to-logo">
            <div class="container">
                <div class="row">
                    @forelse($catalogs as $key=>$catalog)
                        <div class="col-sm-3 card m-2 card-width-fixed">
                            <div class="w-100 cat-action-btn d-flex align-items-center justify-content-between">
                            <a class="mt-2 m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill  trash-left"
                               href="{!! route('admin.catalogues.edit', $catalog->id ) !!}"><i class="fa fa-pencil-square-o"></i></a>
                            <a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button trash-right"
                               href="javascript:{};" data-url="{!! route('admin.catalogues.destroy', $catalog->id ) !!}"><i class="fa fa-trash"></i></a>

                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{!! imageUrl(url($catalog->image), 165,74,95,3) !!}" alt="" class="img-fluid">
                            </div>
                        </div>
                    @empty
                        No Record Found
                    @endforelse
                </div>
            </div>
        </div>

        {{--        <div class="manage-category">--}}
{{--            <div class="card-body tree-category-list-mt">--}}
{{--                <ul class="tree ng-tns-c8-2 ng-star-inserted">--}}

{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="m-portlet__body">--}}
{{--            <!--end: Search Form -->--}}
{{--            <!--begin: Selected Rows Group Action Form -->--}}


{{--            <div class="manage-pages" id="local_data"></div>--}}
{{--            <!--end: Datatable -->--}}
{{--        </div>--}}
{{--        <div class="m-portlet__body">--}}
{{--            <!--begin: Search Form -->--}}

{{--            <!--end: Search Form -->--}}
{{--            <!--begin: Datatable -->--}}
{{--            <!--end: Datatable -->--}}
{{--        </div>--}}
    </div>

@endsection
