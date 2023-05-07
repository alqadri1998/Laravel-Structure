@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
<section class="my-orders spacing">
    <div class="container">
        <div class="row my-orders-row">
            @include('front.dashboard.common.left-navbar')
            <div class="col-md-12 col-lg-9 my-orders-right-col">
                <div class="btns-row">
                    <a href="{!! route('front.dashboard.order.index',['status'=>'confirmed']) !!}" class="btn btn--primary btn--animate {!! (route('front.dashboard.order.index',['status'=>'confirmed']) ==url()->current()  )?'active':'' !!}">{!! __('Confirmed') !!}</a>
                    <a href="{!! route('front.dashboard.order.index',['status'=>'In progress']) !!}" class="btn btn--primary btn--animate {!! ( route('front.dashboard.order.index',['status'=>'In progress'])==url()->current() )?'active':'' !!}">{!! __('In Progress') !!}</a>
                    <a href="{!! route('front.dashboard.order.index',['status'=>'completed']) !!}" class="btn btn--primary btn--animate {!! ( route('front.dashboard.order.index',['status'=>'completed'])==url()->current() )?'active':'' !!}">{!! __('Completed') !!}</a>
                    <a href="{!! route('front.dashboard.order.index',['status'=>'canceled']) !!}" class="btn btn--primary btn--animate {!! ( route('front.dashboard.order.index',['status'=>'canceled'])==url()->current() )?'active':'' !!}">{!! __('Canceled') !!}</a>
                </div>


                @forelse($orders as $key => $value)
{{--                    @foreach($value->orderDetails as $product)--}}
                <div class="my-order-row d-flex flex-wrap pt-5">
                    <div class="img-col">
                        <a href="{{route('front.dashboard.order.detail', $value->id)}}">
{{--                        <img src="{{imageUrl(url($value->image),138,151,100,1)}}" alt="my-order-tyre" class="img-fluid">--}}
                        <img src="{{$value->image}}" alt="my-order-tyre" class="img-fluid">
                        </a>
                    </div>
                    <div class="desc-col">
                        <div class="logo">
                            @if(!is_null($value->orderDetails->first()->brand_image))
                            <img src="{{imageUrl(url($value->orderDetails->first()->brand_image),136,40,100,1)}}" alt="tyre-logo" class="img-fluid">
                            @endif
                        </div>
                        <?php
                            $attributes = json_decode($value->orderDetails->first()->extras)
                        ?>

                        <div class="text-desc">
                            <h4 class="title">@if(isset($attributes))
                                    @forelse($attributes as $attribute)
                                        @if($attribute->name == 'Pattern')
                                            {{$attribute->value}}
                                        @endif
                                    @empty
                                    @endforelse
                                @else
                                    {{$value->orderDetails->first()->name}}
                                @endif</h4>
                            <h4 class="title total-price">Total Price: <strong
                                        class="primary">{{$currency.' '.getConvertedPrice(1,$value->total_amount)}}</strong>
                            </h4>
                        </div>
                        <?php
                        $dateFormat = (string)\Illuminate\Support\Facades\Config::get('settings.date-format');

                        $carbon = \Carbon\Carbon::createFromTimestamp($value->updated_at)->format($dateFormat);

                        $time = \Carbon\Carbon::createFromTimestamp($value->updated_at)->format('g:i A');
                        ?>
                        <div class="left-right-text d-flex justify-content-between flex-wrap">
                            <div class="date">
                                <p class="texts">
                                    <span class="dark-text">Date:</span>
                                    {{$carbon}}
                                </p>
                            </div>
                            <div class="time">
                                <p class="texts">
                                    <span class="dark-text"> Time:</span>
                                    {{$time}}
                                </p>
                            </div>
                        </div>
                        <p class="texts mb-0">
                            <span class="dark-text">Total Products : </span> {{count($value->orderDetails)}}
                        </p>
                    </div>
                    <a href="{{route('front.dashboard.order.detail', $value->id)}}" class="eye-icon"><i class="far fa-eye"></i></a>
                </div>
{{--                    @endforeach--}}
                @empty
                    <div class="col-md-6 col-xl-12 d-block m-auto pb-4">
                        <div class="d-block m-auto">
                            <div class="alert alert-danger">{!! __('You do not have any orders for the selected status.') !!}</div>
                        </div>

                    </div>
                    @endforelse
            </div>

        </div>
    </div>
</section>
@endsection