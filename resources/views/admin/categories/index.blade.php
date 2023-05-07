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
                                .done(function(res){ toastr.success("Vehicle Model Deleted Successfully!"); location.reload(); })
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
                        Vehicle
                        <small>
                            Here You Can Add, Edit or Delete Vehicle and Its Models
                        </small>
                    </h3>
                </div>
            </div>
            @if($userData['role_id']!=config('settings.supplier_role'))
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                                <a href="{!! route('admin.category.edit', 0) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Vehicle
                                    </span>
                                </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="manage-category">
            <div class="card-body tree-category-list-mt">
                <ul class="tree ng-tns-c8-2 ng-star-inserted">
                    @forelse($categories as $key => $category)
                        <li class="ng-tns-c8-2 ng-star-inserted"> {!! $category->translation->name !!}
                            <a class="btn btn-primary btn-sm ml-1 ng-tns-c8-2 ng-star-inserted" data-placement="top"
                               data-toggle="tooltip" title="Add sub-category"
                               href="{!! route('admin.categories.sub-categories.edit', [$category->id,0]) !!}"><i
                                        class="fa fa-plus text-white" aria-hidden="true"></i></a>
                            <a class="btn btn-success btn-sm ml-1 square-box" data-placement="top" data-toggle="tooltip"
                                    title="Edit" href="{!! route('admin.category.edit', $category->id) !!}"><i
                                        class="fa fa-pencil text-white" aria-hidden="true"></i></a>
                            <a data-url=" {!! route('admin.categories.destroy', $category->id) !!} " class="btn btn-danger btn-sm ml-1 ng-tns-c8-2 ng-star-inserted delete-record-button"
                               data-placement="top" data-toggle="tooltip"
                               style="background-color: #dc3545;border-color: #dc3545;" title="Delete"><i
                                        class="fa fa-trash text-white" aria-hidden="true"></i></a>
                            <ul class="ng-tns-c8-2 ng-star-inserted">
                                @forelse($category->subCategories as $key2 => $subCategory)
                                    <li class="ng-tns-c8-2 ng-star-inserted"> {!! $subCategory->translation->name !!}
                                        <a class="btn btn-primary btn-sm ml-1 ng-tns-c8-2 ng-star-inserted" data-placement="top"
                                           data-toggle="tooltip" title="Add sub-category"
                                           href="{!! route('admin.categories.sub-categories.edit', [$subCategory->id,0]) !!}"><i
                                                    class="fa fa-plus text-white" aria-hidden="true"></i></a>
                                        <a class="btn btn-success btn-sm ml-1" data-placement="top" data-toggle="tooltip"
                                           title="Edit" href="{!! route('admin.categories.sub-categories.edit', [$category->id,$subCategory->id]) !!}"><i
                                                    class="fa fa-pencil text-white" aria-hidden="true"></i></a>
                                        <a href="javascript:{}" data-url=" {!! route('admin.categories.destroy', $subCategory->id) !!} " class="btn btn-danger btn-sm ml-1 ng-tns-c8-2 ng-star-inserted delete-record-button"
                                                data-placement="top" data-toggle="tooltip"
                                                style="background-color: #dc3545;border-color: #dc3545;" title="Delete"><i
                                                    class="fa fa-trash text-white" aria-hidden="true"></i></a>
                                        <ul class="ng-tns-c8-2 ng-star-inserted">
                                        @forelse($subCategory->subCategories as $key3  =>  $value )
                                        <li class="ng-tns-c8-2 ng-star-inserted"> {!! $value->translation->name !!}
                                            <a class="btn btn-success btn-sm ml-1" data-placement="top" data-toggle="tooltip"
                                               title="Edit" href="{!! route('admin.categories.sub-categories.edit', [$subCategory->id,$value->id]) !!}"><i
                                                        class="fa fa-pencil text-white" aria-hidden="true"></i></a>
                                            <a href="javascript:{}" data-url=" {!! route('admin.categories.destroy', $value->id) !!} " class="btn btn-danger btn-sm ml-1 ng-tns-c8-2 ng-star-inserted delete-record-button"
                                               data-placement="top" data-toggle="tooltip"
                                               style="background-color: #dc3545;border-color: #dc3545;" title="Delete"><i
                                                        class="fa fa-trash text-white" aria-hidden="true"></i></a>
                                        </li>
                                            @empty
                                        @endforelse
                                        </ul>
                                    </li>
                                    @empty

                                @endforelse
                            </ul>
                        </li>
                        @empty
                    @endforelse

                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--end: Search Form -->
            <!--begin: Selected Rows Group Action Form -->


            <div class="manage-pages" id="local_data"></div>
            <!--end: Datatable -->
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->

            <!--end: Search Form -->
            <!--begin: Datatable -->
            <!--end: Datatable -->
        </div>
    </div>

@endsection
