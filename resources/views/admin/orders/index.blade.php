@extends('admin.layouts.app')

@section('breadcrumb')
@include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script>
        var status = "{!! $status !!}";

    </script>
    <script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/adv_datatables/orders.js')}}" type="text/javascript"></script>

@endpush

@section('content')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Order
                        <small>
                            Here You Can Add, Edit or Delete Order
                        </small>
                    </h3>
                </div>
            </div>
            {{--<div class="m-portlet__head-tools">--}}
                {{--<ul class="m-portlet__nav">--}}
                    {{--<li class="m-portlet__nav-item">--}}
                        {{--<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">--}}
                            {{--<a href="{!! route('admin.orders.edit', ['order' => 0]) !!}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">--}}
                                {{--<span>--}}
                                    {{--<i class="la la-plus"></i>--}}
                                    {{--<span>--}}
                                        {{--Add Order--}}
                                    {{--</span>--}}
                                {{--</span>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <form class="form-group m-form__group row align-items-center" action="" id="manage-product-search">
                            <div class="col-md-12" style="margin-top: -22px;margin-bottom: 15px;">
                                <h3>Advance Search for Orders</h3>
                            </div>

                            <div class="col-md-4 m--margin-bottom-10">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text" class="form-control m-bootstrap-select" name="order_number" placeholder="Order Number">
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
                                        <input type="text" class="form-control m-bootstrap-select" name="payment_method" placeholder="Payment Method">
                                    </div>
                                </div>
                            </div>


                            <div id="page-updated-at" class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <input type="text" class="form-control m-bootstrap-select mt-datetime-picker" name="updatedAt" placeholder="Order placement date At">
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>

                            {{--@if(config('settings.supplier_role')!=$userData['role_id'])--}}
                            {{--<div class="col-md-4 m--margin-bottom-10">--}}
                                {{--<div class="m-form__group m-form__group--inline">--}}
                                    {{--<div class="m-form__label">--}}
                                        {{--<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">--}}
                                            {{--<input type="checkbox" name="trashedPages"  id="show-trashed-pages">--}}
                                            {{--Show Trashed Pages--}}
                                            {{--<span></span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--@endif--}}
                            <div class="col-md-4" style="margin-top: 20px">
                                <button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Submit</button>
                                <button id="page-reset" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">Reset</button>
                            </div>

                        </form>
                    </div>

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
            <!--end: Datatable -->
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->

            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="manage-orders" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>

@endsection
<script>

    function submitAction()
    {
        orderStatus=$(this).val();
        if(orderStatus) {
            document.location.href =orderStatus;
        }
        console.log(orderStatus);
    }

</script>

