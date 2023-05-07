@extends('admin.layouts.app')

@section('breadcrumb')
@include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
<script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
{{--<script src="{{asset('assets/admin/js/adv_datatables/orders-detail.js')}}" type="text/javascript"></script>--}}
{{--<script>--}}
{{--var id = {!!$orderID!!};--}}
{{--</script>--}}
<script>
    $(document).ready(function() {
        $('.status-record-button').click(function() {
            var id = $(this).data('id');
            var status = $(this).data('status');
            var url = window.Laravel.baseUrl + "order-detail/" + id + "/status/" + status;
            swal({
                    title: "Are You Sure?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                                type: 'get',
                                url: url,
                            })
                            .done(function(res) {
                                if (res == 'failed') {
                                    toastr.error("payment did not refund for product!");
                                    swal.close();
                                    location.reload();

                                }
                                if (res == 'canceled') {
                                    toastr.success("Order canceled successfully!");
                                    swal.close();
                                    location.reload();

                                }
                                if (res == 'completed') {
                                    toastr.success("Order completed successfully!");
                                    swal.close();
                                    location.reload();

                                }
                                if (res == 'status') {
                                    toastr.success("status change successfully!");
                                    swal.close()
                                    location.reload();
                                }
                                if (res == '') {
                                    toastr.success("status change successfully!");
                                    swal.close()
                                    location.reload();
                                }
                            })
                            .fail(function(res) {
                                toastr.success("item status changed successfully!");
                                t.reload();
                            });
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
                    Order
                    <small>
                        Here You Can ship and complete orders
                    </small>
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
    <!-- user profile-->
    <div class="user-profile-data d-flex">
       <div class="user-image-data d-flex justify-content-center align-items-center">
       <img src="{!! imageUrl(url($user->user_image)) !!}" class="img-fluid">
       </div>
       <div class="user-contact-detail">
       <h3>{!! $user->full_name !!}</h3>
       <p><i class="fas fa-envelope mr-2"></i> {!! $user->email !!}</p>
       <p><i class="fa fa-phone mr-1"></i> {!! $user->user_phone !!}</p>
       </div>
    </div>
    <!-- user profile-->

        <!--begin: Search Form -->
        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
            <div class="row align-items-center">
                <div class="col-xl-12 order-2 order-xl-1">
                    <div class="row">
                        @if($billing !== null)
                        <div class="col-6">
                            <h1>Billing Address</h1>
                            <p>First Name - {!! $billing->first_name !!}</p>
                            <p>Last Name - {!! $billing->last_name !!}</p>
                            <p>Email - {!! $billing->email !!}</p>
                            <p>Address - {!! $billing->address !!}</p>
                            @if(isset($billing->street_address))
                                <p>Street Address - {!! $billing->street_address !!}</p>
                            @else
                                <p>City - {!! $billing->city !!}</p>
                            @endif
                            <p>Postal code - {!! $billing->post_code !!}</p>
                        </div>
                        @endif
                        @if($shipping !== null)
                        <div class="col-6">
                            <h1>shipping Address</h1>
                            <p>First Name - {!! $shipping->first_name !!}</p>
                            <p>Last Name - {!! $shipping->last_name !!}</p>
                            <p>Email - {!! $shipping->email !!}</p>
                            <p>Address - {!! $shipping->address !!}</p>
                            @if(isset($shipping->street_address))
                                 <p>Street Address - {!! $shipping->street_address !!}</p>
                            @else
                                <p>City - {!! $shipping->city !!}</p>
                            @endif
                            <p>Postal code - {!! $shipping->post_code !!}</p>
                        </div>
                        @endif
                    </div>
                    <p>Order Notes - {!! ($orderNotes)?$orderNotes:"NULL" !!}</p>

                </div>


            </div>
            <!-- <div class="order-card-mt">
                    <div class="card-img-mt">
           <img src="">
                    </div>
                    <span>
                        <i>dss</i>
                        <i>ds</i>
                        <i>dss</i>
                    </span>
                    <div class="combinations-text-mt">
                            <ul class="nav">
                                <li class="nav-item pr-2 d-flex">
                                    <span>Date: &nbsp;</span>
                                    <span class="gothic-normel">11/11/1996</span>
                                </li>
                                <li class="nav-item pr-2 d-flex">
                                    <span>Quantity: &nbsp;</span>
                                    <span class="gothic-normel">2 </span>
                                </li>
                            </ul>
                        </div>

                        <div class="combinations-text-mt">
                            <ul class="nav">
                                <li class="nav-item pr-2 d-flex">
                                    <span>Status : &nbsp;</span>
                                    <span class="gothic-normel">ordered</span>
                                </li>
                            </ul>
                        </div>
                    </div> -->

        </div>


        @forelse($orderDetails as $key => $orderDetail)
        <div class="order-detail-area">
            <div class="order-text-mt mb-4 float-left w-100">
                <div class="card-img-mt mr-3">
{{--                    <img src="{!! imageUrl(url($orderDetail->image),161,177,95,3) !!}" class="img-fluid">--}}
                    <img src="{!! $orderDetail->image !!}" style="height: 161px;" class="img-fluid">
                </div>
                <div class="container-position container position-relative">
                    <span class="btn-container d-flex justify-content-center flex-column">
                        @if($orderDetail->item_status == 'pending')
                        <button type="button" class="text-center text-capitalize status-record-button" data-id="{!! $orderDetail->id !!}" data-status="shipping">Ship Order</button>
                        <button type="button" class="text-center text-capitalize status-record-button" data-id="{!! $orderDetail->id !!}" data-status="canceled">Cancel Order</button>
                        @endif
                        @if($orderDetail->item_status == 'shipping')
                        <button type="button" class="text-center text-capitalize status-record-button" data-id="{!! $orderDetail->id !!}" data-status="complete">Complete Order</button>
                        @endif
                        @if($orderDetail->item_status == 'complete' ||$orderDetail->item_status == 'canceled' )
                        @endif
                    </span>
                </div>
                <div class="container p-0">
                <h4 class="text-center text-md-left">{!! $orderDetail->product->translation->title !!}</h4>
                <ul class="d-flex list-unstyled justify-content-center justify-content-md-start">
                    <li>
                        <h4 class="gohtic-normel">Total Amount : &nbsp;</h4>
                    </li>
                    <li>
                        <h4 class="secondary-color gohtic-normel">{!! $orderDetail->product_price .' x '.$orderDetail->quantity.' = '. $orderDetail->total_price. ' AED' !!} </h4>
                    </li>
                </ul>
                <div class="combinations-text-mt">
                    <ul class="nav d-flex justify-content-center justify-content-md-start remove-space">
                        <?php
                        $dateFormat = (string) \Illuminate\Support\Facades\Config::get('settings.date-format');
                        $carbon = \Carbon\Carbon::createFromTimestamp($orderDetail->created_at)->format($dateFormat);
                        ?>
                        <li class="nav-item pr-2 d-flex">
                            <span class=" font-weight-bold">Date : &nbsp;</span>
                            <span class="gothic-normel ">{!! $carbon !!}</span>
                        </li>
                        <li class="nav-item pr-2 d-flex ad-k-space">
                            <span class="font-weight-bold">Quantity : &nbsp; </span>
                            <span class="gothic-normel">{!! $orderDetail->quantity !!}</span>
                        </li>
                    </ul>
                </div>
                <div class="combinations-text-mt">
                    <ul class="nav d-flex justify-content-center justify-content-md-start">
                        <li class="nav-item pr-2 d-flex">
                            <span class="font-weight-bold">Status :&nbsp; </span>
                            <span class="gothic-normel font-weight-light">{!! $orderDetail->item_status !!}</span><br>
                        </li>
                    </ul>
                    @if($orderDetail->list !='')
                    <ul class="nav d-flex justify-content-center justify-content-md-start flex-wrap attribute-ul max-width-set">
                        {!! $orderDetail->list !!}
                    </ul>
                    @endif


                    </div>
                </div>
            </div>
        </div>
        @empty

        @endforelse


        <!--end: Search Form -->

        <!--begin: Selected Rows Group Action Form -->

        <!--end: Datatable -->
    </div>

    <div class="m-portlet__body">
        <h2> Order Amount : {!! $order_amount.' AED'  !!}</h2>
        @if($coupon !== '')
            <h6>Coupon Applied</h6>
        @endif

        <!--begin: Search Form -->

        <!--end: Search Form -->
        <!--begin: Datatable -->
        {{--<div class="manage-orders" id="local_data"></div>--}}

        <!--end: Datatable -->
    </div>
</div>

@endsection
<script>
</script>