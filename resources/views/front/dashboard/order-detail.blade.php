
@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
<!-- Order Detail Section -->
<section class="my-orders spacing order-detail">
    <div class="container">
        <div class="row my-orders-row">
            @include('front.dashboard.common.left-navbar')
            <div class="col-md-12 col-lg-9 my-orders-right-col">
                <div class="row order-row align-items-start">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="middle-column bb-space pt-0">
                            <div class="desc-header">
                                <h3 class="primary-title mb-4">Order # {{$order->order_number}}</h3>
                                <h3 class="primary-title mb-0">
                                    Total Amount: <strong class="red"> {{$currency.' '.getConvertedPrice(1,$order->total_amount)}}</strong>
                                </h3>
                                <?php
                                $dateFormat = (string)\Illuminate\Support\Facades\Config::get('settings.date-format');

                                $carbon = \Carbon\Carbon::createFromTimestamp($order->updated_at)->format($dateFormat);

                                $time = \Carbon\Carbon::createFromTimestamp($order->updated_at)->format('g:i A');
                                ?>
                                <div class="product-types">
                                    <span class="title-value">Date :<span class="dem-text"> {{$carbon}}</span></span>
                                    <span class="title-value pl-4">Total Products : <span
                                                class="dem-text"> {{count($order->orderDetails)}}</span>
                                                            </span><br>
                                    <span class="title-value pt-4">Time :<span class="dem-text">
                                                                      {{$time}}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row order-row">
                    <div class="col-12">
                        <div class="middle-column bb-space">
                            <div class="desc-header d-flex align-center">
                                <h3 class="primary-title mb-0">Order Status:</h3>
                                <p class="primary-text pl-2">
                                    {{$order->order_status}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row order-row pt-5">
                    <div class="col-md-7">
                        <div class="shiping-box value-box">
                            <h3 class="primary-title">Shipping/Billing Address</h3>
                            <p class="primary-text primary-lg text-black my-3">Full Name:<span class="value">{{$order->billing_address->first_name.' '. $order->billing_address->last_name}}</span></p>
                            <p class="primary-text primary-lg text-black my-3">Phone No:<span class="value">{{$order->billing_address->user_phone}}</span></p>
                            <p class="primary-text primary-lg text-black my-3">Email:<span class="value">{{$order->billing_address->email}}</span></p>
                            <p class="primary-text primary-lg text-black my-3">Postal Code:<span class="value">@if(isset($order->billing_address->post_code) && !empty($order->billing_address->post_code)){{$order->billing_address->post_code}} @else N/A@endif</span></p>
                            <p class="primary-text primary-lg text-black my-3">Address:<span class="value">@if(isset($order->billing_address->address) && !empty($order->billing_address->address)){{$order->billing_address->address}} @else N/A@endif</span></p>
                            <p class="primary-text primary-lg text-black my-3">How Did You Find:<span class="value">@if(isset($order->billing_address->find_us)){{$order->billing_address->find_us}} @else N/A@endif</span></p>
                            <p class="primary-text primary-lg text-black my-3">City:<span class="value">@if(isset($order->billing_address->city) && !empty($order->billing_address->city)){{$order->billing_address->city}} @else N/A@endif</span></p>
                            <p class="primary-text primary-lg text-black my-3">Country:<span class="value">@if(isset($order->billing_address->country)){{$order->billing_address->country}}@else N/A@endif</span></p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="vehicle-detail-box value-box">
                            <h3 class="primary-title">Vehicle Details</h3>
                            <p class="primary-text primary-lg text-black my-3">Vin Number:<span class="value">@if(isset($order->vehicle->vin_number)){{$order->vehicle->vin_number}}@else N/A@endif</span></p>
                            <p class="primary-text primary-lg text-black my-3">Vehicle Plate:<span class="value">@if(isset($order->vehicle->number_plate)){{$order->vehicle->number_plate}}@else N/A@endif</span></p>
                            <p class="primary-text primary-lg text-black my-3">Make:<span class="value">@if(isset($order->vehicle->vehicle)){{$order->vehicle->vehicle}}@else N/A@endif</span></p>
                            <p class="primary-text primary-lg text-black my-3">Model:<span class="value">@if(isset($order->vehicle->model)){{$order->vehicle->model}}@else N/A@endif</span></p>
                            <p class="primary-text primary-lg text-black my-3">Year:<span class="value">@if(isset($order->vehicle->year)){{$order->vehicle->year}}@else N/A@endif</span></p>
                        </div>
                    </div>
                </div>
                @if(!is_null($order->branch))
                <div class="row order-row">
                    <div class="col-md-12 ">
                        <div class="fitting-location bb-space">
                            <h3 class="primary-title mb-4">Fitting Location</h3>
                            <p class="motor-city">
                                {{$order->branch->name}}
                            </p>
                            <p class="primary-text">
                                Fitment Date/Time {{$order->branch->date}}  | {{$order->branch->time}}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row order-row">
                    <div class="col-12">
                        <div class="middle-column bb-space">
                            <div class="desc-header">
                                <h3 class="primary-title">Order Notes: </h3>
                                <p class="primary-text">
                                   {{$order->order_note}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row order-row">
                    <div class="col-12">
                        <div class="middle-column bb-space">
                            <div class="desc-header">
                                <h3 class="primary-title">Payment Method</h3>
                                <p class="primary-text primary-lg weight-regular">
                                    {{$order->payment_method}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!$order->coupon_code == "" && $order->coupon_percent > 0)
                <div class="row order-row">
                    <div class="col-12">
                        <div class="middle-column bb-space">
                            <div class="desc-header check-icon position-relative">
                                <h3 class="primary-title">Discount Code Applied</h3>
                                <div class="product-types">
                                                            <span class="primary-text weight-regular">{{$order->coupon_percent}}% Discount is
                                                                 applied</span>
                                </div>
                                <i class="fas fa-check position-absolute"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @foreach($order->orderDetails as $product)
                <div class="my-order-row d-flex flex-wrap flex-md-nowrap pt-5">
                    <div class="img-col">
{{--                        <img src="{{imageUrl(url($product->image),138,151,100,1)}}" alt="my-order-tyre"--}}
                        <img src="{{$product->image}}" alt="my-order-tyre" style="height: 138px;"
                             class="img-fluid">
                    </div>
                    <div class="desc-col">
                        @if(isset($product->brand_image))
                        <div class="logo">
                            <img src="{{imageUrl(url($product->brand_image),136,40,100,1)}}" alt="tyre-logo"
                                 class="img-fluid">
                        </div>
                        @endif
                        <div class="text-desc">
                            <h4 class="title">@if(isset($product->product)){{$product->product->translation->title}}@endif</h4>
                            <h4 class="title total-price">Total Price: <strong class="primary">{{$currency.' '.getConvertedPrice(1,$product->total_price)}}</strong></h4>
                        </div>
                        <?php
                        $date = \Carbon\Carbon::createFromTimestamp($order->updated_at)->format('d/m/y');

                        $time = \Carbon\Carbon::createFromTimestamp($order->updated_at)->format('g:i A');
                        ?>
                        <div class="left-right-text d-flex justify-content-between flex-wrap">
                            <div class="date">
                                <p class="texts">
                                    <span class="dark-text">Date:</span> {{$date}}
                                </p>
                            </div>
                            <div class="time">
                                <p class="texts">
                                    <span class="dark-text">Time:</span> {{$time}}
                                </p>
                            </div>
                        </div>
                        <p class="texts mb-0">
                            <span class="dark-text">Quantity:</span> {{$product->quantity}}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>

@endsection