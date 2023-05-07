{{--@extends('front.layouts.app')--}}
{{--@section('content')--}}
{{--    <!-- product-listing-->--}}
{{--    @include('front.common.breadcrumb')--}}
{{--    <section class="events">--}}
{{--        <div class="container">--}}
{{--            @forelse($events as $key => $event)--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-3 col-lg-2">--}}
{{--                    <div class="event-card d-flex justify-content-center align-items-center">--}}
{{--                        <img src="{{imageUrl(url($event->image),166,179,95,3)}}" alt="{{$event->translation->title}}" class="img-fluid">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6 col-lg-7">--}}
{{--                    <div class="events-text">--}}
{{--                        <h1 class="events-heading mb-3 truncate">{{$event->translation->title}}</h1>--}}
{{--                        <div class="mb-3 truncate">--}}
{{--                            <i class="fa fa-map-marker chng-c" aria-hidden="true"></i>--}}
{{--                            <span class="events-span" >{!! $event->event_location !!}</span>--}}
{{--                        </div>--}}
{{--                        <div class="module text-multilining-truncate">--}}
{{--                        <p class="events-para mb-3 module">--}}
{{--                            {!! substr($event->translation->description,0,100) !!} {!! (strlen($event->translation->description)>100)?'...':'' !!} <a href="{!! route('front.events.detail',['slug' => $event->slug]) !!}" class="events-link gothic-bold">{!! (strlen($event->translation->description) > 100 )? __('read more'):__('View Details') !!}</a>--}}
{{--                        </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3 text-md-right text-sm-left res-c">--}}
{{--                    <p class="start-date">{!! __('start date') !!} : <span class="date-span">{!! $event->date_start !!}</span>--}}
{{--                    </p>--}}
{{--                    <p class="end-date">{!! __('end date') !!} : <span class="date-span">{!! $event->date_end !!}</span>--}}
{{--                    </p>--}}
{{--                    --}}{{--<a href="{!! route('front.events.direction',['slug' => $event->slug]) !!}" class="mt-btn-primary event-btn">get direction</a>--}}
{{--                    <a target="_blank" href="https://www.google.com/maps/dir//{!! $event->latitude !!},{!! $event->longitude !!}/@ {!! $event->latitude !!},{!! $event->longitude !!},12z" class="mt-btn-primary event-btn">{!! __('get direction') !!}</a>--}}
{{--                </div>--}}
{{--                <div class="border-div last">--}}
{{--                </div>--}}

{{--            </div>--}}
{{--                @empty--}}
{{--            @endforelse--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    @endsection--}}
{{--    <!-- /evnts -->--}}

