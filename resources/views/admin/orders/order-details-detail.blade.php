@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
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

        </div>

        <div class="m-portlet__body">
            <!--begin: Search Form -->

            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="orders-detail" id="local_data"></div>
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

