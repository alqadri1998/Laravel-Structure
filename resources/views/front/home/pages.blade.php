@extends('front.layouts.app')
@section('content')

    @include('front.common.breadcrumb')

    <!-- pormotions html start -->
    <section class="location-main-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3">
                    <div class="about-us-img-main d-flex align-items-center justify-content-center">
                        @if($page->image )
                            <img class="img-fluid" src="{{imageUrl(url($page->image))}}">
                        @else
                            <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/about-1.jpg')}}">
                        @endif

                    </div>

                </div>
                {!! $page->translation->content !!}
                <div class="col-md-5 col-lg-6 col-xl-3">
                    <div class="customer-support-about-main">
                        <h2 class="support-tittle">{!! __('24/7 Free Customer Support.') !!}</h2>
                        <p class="support-p">{{__(config('settings.footer_short_description'))}}</p>
                        <div class="icon-phone-support">
                            <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/about-us-phone.png')}}"> <span class="support-number">
                                {{__(config('settings.contact_number'))}}
                            </span>

                        </div>
                        <div class="social-icon-support">
                           <a class="social-p text-truncate" href="tel:{{__(config('settings.contact_number'))}}" >Mob:  {{__(config('settings.contact_number'))}}</a>
                            <a class="social-p text-truncate" href="mailto:{{__(config('settings.email'))}}" >Email: {{__(config('settings.email'))}}</a>
                            <div class="icons-p-t-i">
                                <a href="{!! __(config('settings.facebook_url')) !!}"> <i class="fab fa-facebook-f ml-0"></i></a>
                                <a href="{!! __(config('settings.twitter_url')) !!}"> <i class="fab fa-twitter"></i></a>
                                <a href="{!! __(config('settings.linkedIn_url')) !!}"> <i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end pormotion html -->

@endsection


