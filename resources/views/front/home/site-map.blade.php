@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <!-- pormotions html start -->
    <section class="site-map-secs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="site-map-main">
                                <div class="inner-site-map">
                                    <h2 class="site-map-tittle">{{config('settings.company_name')}} Useful Links</h2>
                                    <ul class="site-map-ul">
                                        <a href="{{ route('front.pages', ['slug' => config('settings.about_us')]) }}"><li class="li-site-map">About {{config('settings.company_name')}}</li></a>
                                        <a href="{{route('front.packages.index')}}"><li class="li-site-map">Car Accessories</li></a>
                                        <a href="{{route('front.product.index')}}"><li class="li-site-map">Car Tyres</li></a>
                                        <a href="{{route('front.brands.index')}}"><li class="li-site-map">Car Tyres Brands</li></a>
                                        <a href="{{ route('front.pages', ['slug' => config('settings.chauffeur_drive')]) }}"><li class="li-site-map">Chauffeur Drive</li></a>
                                    </ul>

                                </div>

                            </div>

                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="site-map-main">
                                <div class="inner-site-map">
                                    <h2 class="site-map-tittle">Contact Information</h2>
                                    <ul class="site-map-ul">
                                        <a href="{{ route('front.contactUs') }}"><li class="li-site-map">Contact Us</li></a>
                                        <a href="{{route('front.appointment')}}"><li class="li-site-map">Make an Appointment</li></a>
                                        <a href="{{route('front.promotions.index')}}"><li class="li-site-map">Special Offers</li></a>
                                        <a href="{{route('front.auth.login')}}"><li class="li-site-map">Customer Login</li></a>
                                        <a href="{{route('front.branches.index')}}"><li class="li-site-map">Store Location</li></a>
                                    </ul>

                                </div>

                            </div>

                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="site-map-main">
                                <div class="inner-site-map">
                                    <h2 class="site-map-tittle">Terms & Conditions</h2>
                                    <ul class="site-map-ul">
                                        <a href="{{ route('front.pages', ['slug' => config('settings.terms_of_use')]) }}"><li class="li-site-map">Terms of Use</li></a>
                                        <a href="{{ route('front.pages', ['slug' => config('settings.terms_and_conditions')]) }}"><li class="li-site-map">Terms & Conditions</li></a>
                                        <a href="{{ route('front.pages', ['slug' => config('settings.privacy_policy')]) }}"><li class="li-site-map">Privacy Policy</li></a>
                                        <a href="{{ route('front.pages', ['slug' => config('settings.return_refund_policy')]) }}"><li class="li-site-map">Return & Refund Policy</li></a>
                                        <a href="{{ route('front.pages', ['slug' => config('settings.warranty_information')]) }}"><li class="li-site-map">Warranty Information</li></a>
                                    </ul>

                                </div>

                            </div>

                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="site-map-main">
                                <div class="inner-site-map">
                                    <h2 class="site-map-tittle">Preventive Maintenance</h2>
                                    <ul class="site-map-ul">
                                        @forelse($services as $service)
                                            @if($service->type == "maintenance")
                                                <a href="{!! route('front.services.detail',['slug' => $service->slug]) !!}"><li class="li-site-map">{{$service->translation->title}}</li></a>
                                            @endif
                                        @empty
                                        @endforelse
                                    </ul>

                                </div>

                            </div>

                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="site-map-main">
                                <div class="inner-site-map">
                                    <h2 class="site-map-tittle">Car Tyre Services</h2>
                                    <ul class="site-map-ul">
                                        @forelse($services as $service)
                                            @if($service->type == "tyre")
                                                <a href="{!! route('front.services.detail',['slug' => $service->slug]) !!}"><li class="li-site-map">{{$service->translation->title}}</li></a>
                                            @endif
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="site-map-main">
                                <div class="inner-site-map">
                                    <h2 class="site-map-tittle">Car Repair Services</h2>
                                    <ul class="site-map-ul">
                                        @forelse($services as $service)
                                            @if($service->type == "repair")
                                        <a href="{!! route('front.services.detail',['slug' => $service->slug]) !!}"><li class="li-site-map">{{$service->translation->title}}</li></a>
                                            @endif
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </section>
    <!-- end pormotion html -->

@endsection