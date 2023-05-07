@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <!-- pormotions html start -->
    <section class="location-main-sec">
        <div class="container">
            <div class="row">
                @forelse($branches as $branch)

                        <div @if(!$loop->last) class="col-xl-6 mt-5" @else class="col-md-12 mt-5" @endif>
                            <form action="{{route('front.checkout.index')}}" method="post" class="h-100">
                                @csrf
                            <div class="main-location-us h-100">
                                <div class="inner-location-us">
                                    <h2 class="loc-h2">{{$branch->translation->title}}</h2>
                                    <ul class="ul-loctaion-page">
                                        <li>{{$branch->address}}</li>
                                        <li>{{__('Timings:')}}</li>
                                        <li>{{$branch->timings}}</li>
                                        <li>{{__('Call:')}} <a class="loctaion-num" href="tel:800 7867 46">{{$branch->phone}}</a></li>
                                    </ul>
                                    <div class="location-btn justify-content-start">
                                        <a target="_blank"
                                           href="https://www.google.com/maps/dir//{!! $branch->latitude !!},{!! $branch->longitude !!}/@ {!! $branch->latitude !!},{!! $branch->longitude !!},12z"
                                           class="btn btn--black btn--animate">{!! __('Get Direction') !!}</a>
                                    </div>
                                    <p class="select-title">
                                        {{__('Select Your appointment date/time')}}
                                    </p>
                                    <div class="row btnz-row">
                                        <div class="col-md-4 cols">
                                            <select class="form-control select-field" name="booking_date" id="make" required>
                                                <option selected="true" disabled="disabled">{{__('Select Date')}}</option>
                                                @forelse($dates as $date)
                                                <option value="{{$date}}">{{$date}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('booking_date'))
                                                <div class="form-control-feedback">{{ $errors->first('booking_date') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-3 middle-col pl-0">
                                            <select class="form-control select-field" name="booking_time" id="make" required>
                                                <option selected="true" disabled="disabled" >{{__('Select Time')}}</option>
                                                <option value="Am">Am</option>
                                                <option value="Pm">Pm</option>
                                            </select>
                                            @if ($errors->has('booking_time'))
                                                <div class="form-control-feedback">{{ $errors->first('booking_time') }}</div>
                                            @endif
                                        </div>
                                        <input hidden name="location" value="{{$branch->slug}}">
                                        <div class="col-md-5 last-col">
                                            <div class="location-btn">
                                                <button type="submit" class="btn btn--primary btn--animate" >{{__('Continue Checkout')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    <!-- end pormotion html -->

@endsection