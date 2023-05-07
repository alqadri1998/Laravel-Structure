{{--@extends('front.layouts.app')--}}
{{--@section('content')--}}
{{--@include('front.common.breadcrumb')--}}
{{--    <!-- events-detail -->--}}
{{--    <section class="events-detail">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="event-box d-flex align-items-center">--}}
{{--                        <img src="{!! imageUrl(url($event->image),326,353,95,3) !!}" alt="" class="img-fluid d-block m-auto">--}}
{{--                    </div>--}}
{{--                    <div class="events-detail-text">--}}
{{--                        <h1 class="events-heading mb-3 res-head truncate">{!! $event->translation->title !!}</h1>--}}
{{--                        <div class="mb-3 truncate">--}}
{{--                            <i class="fa fa-map-marker chng-c" aria-hidden="true"></i>--}}
{{--                            <span class="events-span ">{!! $event->event_location !!}</span>--}}
{{--                        </div>--}}
{{--                        <div class="dates">--}}
{{--                            <p class="start-date">{!! __('Address') !!} :  {!! $event->date_start !!}<span class="date-span"></span>--}}
{{--                            </p>--}}
{{--                            <p class="end-date">{!! __('end date') !!} : {!! $event->date_end !!}<span class="date-span"></span>--}}
{{--                            </p>--}}
{{--                            --}}{{--<a  href="{!! route('front.events.direction',['slug' => $event->slug]) !!}" class="mt-btn-primary event-btn event-detail-btn">get direction</a>--}}
{{--                            <a target="_blank" href="https://www.google.com/maps/dir//{!! $event->latitude !!},{!! $event->longitude !!}/@ {!! $event->latitude !!},{!! $event->longitude !!},12z" class="mt-btn-primary event-btn event-detail-btn" >{!! __('get direction') !!}</a>--}}

{{--                        </div>--}}
{{--                        <!-- <div class="module text-multilining-truncate"> -->--}}
{{--                        <p class="events-para mb-3">--}}
{{--                            {!! $event->translation->description !!}--}}
{{--                        </p>--}}
{{--                        <!-- </div> -->--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <!-- /events-detail -->--}}
{{--    @endsection--}}
