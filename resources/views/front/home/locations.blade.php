@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

<!-- Branch Locations html start -->
<section class="location-main-sec">
    <div class="container">
        <div class="row">
            @foreach($branches as $branch)
                @if(!$loop->last)
            <div class="col-md-6">
                <div class="main-location-us">
                    <div class="inner-location-us">
                        <h2 class="loc-h2">{{$branch->translation->title}}</h2>
                        <ul class="ul-loctaion-page">
                            <li>{{$branch->address}}</li>
                            <li>{{__('Timings:')}}</li>
                            <li>{!! $branch->timings !!}</li>
                            <li>{{__('Call:')}} <a class="loctaion-num" href="tel:800456445" >{{$branch->phone}}</a> </li>

                        </ul>
                        <div class="location-btn">
                            <a target="_blank" href="https://www.google.com/maps/dir//{!! $branch->latitude !!},{!! $branch->longitude !!}/@ {!! $branch->latitude !!},{!! $branch->longitude !!},12z" class="btn btn--primary btn--animate">{!! __('View on Map') !!}</a>
                        </div>

                    </div>

                </div>

            </div>
                @else
                    <div class="col-md-12 mt-5">
                        <div class="main-location-us">
                            <div class="inner-location-us">
                                <h2 class="loc-h2">{{$branch->translation->title}}</h2>
                                <ul class="ul-loctaion-page">
                                    <li>{{$branch->address}}</li>
                                    <li>{{__('Timings:')}}</li>
                                    <li>{!! $branch->timings !!}</li>
                                    <li>{{__('Call:')}} <a class="loctaion-num" href="tel:800456445">{{$branch->phone}}</a> </li>
                                </ul>
                                <div class="location-btn">
                                    <a target="_blank" href="https://www.google.com/maps/dir//{!! $branch->latitude !!},{!! $branch->longitude !!}/@ {!! $branch->latitude !!},{!! $branch->longitude !!},12z" class="btn btn--primary btn--animate">{!! __('View on Map') !!}</a>
                                </div>

                            </div>

                        </div>

                    </div>
                    @endif
            @endforeach
        </div>
    </div>
</section>
<!--/ Branch Locations html -->

@endsection
