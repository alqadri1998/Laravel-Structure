@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    {{--<script src="{{asset('assets/admin/js/adv_datatables/adminAttributes.js')}}" type="text/javascript"></script>--}}
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
                                .done(function(res){ toastr.success("Sub Attribute Deleted Successfully!"); location.reload(); })
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
                      Attributes
                        <small>
                            Here You Can Add, Edit or Delete Attribute
                        </small>
                    </h3>
                </div>
            </div>
            @if($userData['role_id']!=config('settings.supplier_role'))
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                                <a href="{!! route('admin.attributes.edit', 0) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Attribute
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
                    @forelse($attributes as $key => $attribute)
                        <li class="ng-tns-c8-2 ng-star-inserted"> {!! $attribute->translation->name !!}
                            <a class="btn btn-primary btn-sm ml-1 ng-tns-c8-2 ng-star-inserted" data-placement="top"
                               data-toggle="tooltip" title="Add sub-Attribute"
                               href="{!! route('admin.attributes.sub-attributes.edit', [$attribute->id,0]) !!}"><i
                                        class="fa fa-plus text-white" aria-hidden="true"></i></a><a
                                    class="btn btn-success btn-sm ml-1" data-placement="top" data-toggle="tooltip"
                                    title="Edit" href="{!! route('admin.attributes.edit', $attribute->id) !!}"><i
                                        class="fa fa-pencil text-white" aria-hidden="true"></i></a>
                            <ul class="ng-tns-c8-2 ng-star-inserted">
                                @forelse($attribute->subAttributes as $key2 => $subAttribute)
                                    <li class="ng-tns-c8-2 ng-star-inserted"> {!! $subAttribute->translation->name !!}
                                        <a class="btn btn-success btn-sm ml-1" data-placement="top" data-toggle="tooltip"
                                           title="Edit" href="{!! route('admin.attributes.sub-attributes.edit', [$attribute->id,$subAttribute->id]) !!}"><i
                                                    class="fa fa-pencil text-white" aria-hidden="true"></i></a>
                                        <a href="javascript:{}" data-url=" {!! route('admin.attributes.destroy', $subAttribute->id) !!} " class="btn btn-danger btn-sm ml-1 ng-tns-c8-2 ng-star-inserted delete-record-button"
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
            </div>
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
            <div class="manage-attributes" id="local_data"></div>
            <!--end: Datatable -->
        </div>
        <!--end: Datatable -->
    </div>


@endsection
