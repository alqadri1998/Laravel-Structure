@extends('front.layouts.app') @section('content')
<main class="main">

    <!--Banner Section Start-->
    <section class="banner services-banner">
        <div class="services-icons">
            <div class="bg-border strate-border"></div>
            <div class="bg-border curve-border-01"></div>
            <div class="bg-border curve-border-02"></div>
            <div class="service-outer-block">                
                    <div class="our-services-block">
                        our <br> Services
                    </div>               
            </div>            
            <ul class="services-ul">
                <li class="list-item active tyre-store">
                    <a class="link" type="button" href="#" data-toggle="modal" data-target="#myModal">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/tyre-store.png')}}" alt="services-icon">
                        Tyre Store
                    </a>
                </li>
                <li class="list-item oil-filter">
                    <a class="link" href="{{ route('front.services.detail', ['slug' => config('settings.banner_oil_icon')]) }}">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/oil&filter.png')}}" alt="services-icon">
                        Oil & Filter
                    </a>
                </li>
                <li class="list-item battery">
                    <a class="link" href="{{ route('front.services.detail', ['slug' => config('settings.banner_battery_icon')]) }}">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/batteries.png')}}" alt="services-icon">
                        Batteries
                    </a>
                </li>
                <li class="list-item mechanic">
                    <a class="link" href="{{ route('front.services.index','maintenance') }}">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/mechanic.png')}}" alt="services-icon">
                        Mechanic
                    </a>
                </li>
                <li class="list-item tyre-services">
                    <a class="link" href="{{ route('front.services.index','tyre') }}">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/tyre-services.png')}}" alt="services-icon">
                        Tyre Services
                    </a>
                </li>
                <li class="list-item ac">
                    <a class="link" href="{{route('front.services.detail', ['slug' => config('settings.banner_ac_icon')]) }}">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/ac.png')}}" alt="services-icon">
                        A/C
                    </a>
                </li>
            </ul>
        </div>        
    </section>
    <!-- <section class="banner">
        <div class="services-icons">
            <ul class="services-ul">
                <li class="list-item active">
                    <a class="link" type="button" href="#" data-toggle="modal" data-target="#myModal">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/tyre-store.png')}}" alt="services-icon">
                    </a>
                </li>
                <li class="list-item">
                    <a class="link" href="{{ route('front.repairs.detail', ['slug' => config('settings.banner_oil_icon')]) }}">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/oil&filter.png')}}" alt="services-icon">
                    </a>
                </li>
                <li class="list-item">
                    <a class="link" href="{{ route('front.repairs.detail', ['slug' => config('settings.banner_battery_icon')]) }}">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/batteries.png')}}" alt="services-icon">
                    </a>
                </li>
                <li class="list-item">
                    <a class="link" href="{{ route('front.repairs.detail', ['slug' => config('settings.banner_break_icon')]) }}">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/mechanic.png')}}" alt="services-icon">
                    </a>
                </li>
                <li class="list-item">
                    <a class="link" href="{{route('front.services.index')}}">
                        <img class="services-icon img-fluid" src="{{asset('assets/front-tyre-shop/images/banner-icons/tyre-services.png')}}" alt="services-icon">
                    </a>
                </li>
            </ul>
        </div>

        <div class="container">
            <div class="banner-box">
                <h1 class="primary-headline">
                    We care your Car<br> You can Book Now<br> Available in Best prices
                </h1>
            </div>
        </div>
    </section> -->
    <!--Banner Section End-->
    <!-- Slider Section -->
    <Section class="slider">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @forelse($sliders as $slider)
                <div class="carousel-item @if($loop->first) active @endif">
                   <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                       <img class="img-fluid mx-auto" src="{{$slider->image}}" style="max-height: 600px"/>
                   </div>
                </div>
                @empty
                @endforelse
                </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </Section>
    <!-- Our Services Package Section Start -->
    <section class="our-services services-package spacing">
        <div class="container">
            <div class="text-center">
                <h2 class="secondary-headline secondary-headline-black">
                    Service Packages
                    <img class="left-border img-fluid" src="{{asset('assets/front-tyre-shop/images/left-border.png')}}" alt="left-border">
                    <img class="right-border img-fluid" src="{{asset('assets/front-tyre-shop/images/right-border.png')}}" alt="right-border">
                </h2>
            </div>
            <div class="row custom-row">
                @forelse($servicePackages as $servicePackage)
                    <div class="col-sm-6 col-lg-4 cols">
                        <div class="services-card">
                            <div class="services-card-title text-center">
                                <h4 class="title">{{$servicePackage->translation->title}}</h4>
                            </div>
                            <div class="services-card-content align-items-center justify-content-between">
                                {!! $servicePackage->translation->long_description !!}
                                <div class="bottom-block text-center">
                                    <h3 class="price">
                                        AED {{$servicePackage->price}}
                                    </h3>
                                    <p class="bottom-desc">
                                        {!! $servicePackage->translation->short_description !!}
                                    </p>
                                    <form action="{!! route('front.cart.add') !!}" method="post">
                                        @csrf
                                        <input type="hidden" id="product_quantity" name="quantity" class="count-output" value="1">
                                        <input type="hidden" name="product_id" value="{!! $servicePackage->id !!}">
                                        <button type="submit" class="btn btn--primary btn--animate">Buy Now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    <!-- Our Services Package Section End -->

    <!-- Our Brands Section Start -->
    @php
        $title = trim_text($whyChooseUs->translation->title);
        $title = explode('@',$title);
    @endphp
    <section class="our-brands spacing">
        <div class="container">
            <div class="text-center">
                <h2 class="secondary-headline">
                    Brands We Trusted
                    <img class="left-border img-fluid" src="{{asset('assets/front-tyre-shop/images/left-border.png')}}" alt="left-border">
                    <img class="right-border img-fluid" src="{{asset('assets/front-tyre-shop/images/right-border.png')}}" alt="right-border">
                </h2>
            </div>
            <div class="row brands-row">
                <div class="col-lg-6 cols d-none">
                    <div class="brands-desc">
                        <a href="#" class="site-logo">
                            <img src="{{imageUrl(asset('assets/front-tyre-shop/images/logo.png'),198,44,100,2)}}" alt="logo-black" class="logo-black">
                            {{-- <img src="{{imageUrl(url($whyChooseUs->image))}}" alt="logo-black" class="logo-black">--}}
                        </a>
                        <h4 class="title">
                            Brands We Trust
                        </h4>
                        <div class="text-desc text-justify">
                            {!! $whyChooseUs->translation->content !!}
                        </div>
                        <a href="{!!route('front.pages', ['slug' => config('settings.about_us')] )!!}" class="btn btn--black btn--animate">read more</a>
                    </div>

                </div>
                <div class="col-lg-12 cols">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="multi-items-slider">
                                @forelse($brands as $brand)
                                    <div class="brands-logo-grid">
                                        <div class="img-sec">
                                            <a href="javascript:void(0)">
                                                <img src="{{imageUrl($brand->image, 263,123,90,1)}}" title="{{$brand->translation->title}}" alt="{{$brand->translation->title}}" class="brand-logo img-fluid">
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Our Brands Section End -->
    <!-- Book an appointment Section Start-->
    @include('front.common.book-appointment')
    {{--<section class="book-an-appointment-section spacing">
        <div class="container">
            <div class="row appointment-row">
                <div class="col-sm-6 cols">
                    <h2 class="secondary-headline text-white text-capitalize">
                       Book service at your<br class="d-none d-md-inline-block"> nearest location!
                    </h2>
                    <div class="form-sec">
                        <form action="{{route('front.make.appointment.index.page')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group m-b-25 col-sm-6">
                                        <label for="first_name" class="required">Name</label>
                                        <input type="text" class="form-control rm-arrow" id="first_name" value="" placeholder="e.g John" name="name" required="">
                                </div>
                                <div class="form-group m-b-25 col-sm-6">
                                        <label for="first_name" class="required">Phone No</label>
                                        <input type="text" class="form-control rm-arrow" id="first_name" value="" placeholder="Enter no" name="phone" required="">
                                </div>
                            </div>                            
                            <div class="form-group date">
                                <label for="Date">Date</label>
                                <select class="form-control" id="Date" name="date" required>
                                    <option selected="true" value="" disabled="disabled">Select Date</option>
                                    @foreach($dates as $date)
                                        <option value="{{$date}}">{{$date}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group time">
                                <label for="Time">Time</label>
                                <select class="form-control" id="Time" name="time" required>
                                    <option selected="true" value="" disabled="disabled">Select Time</option>
                                    @foreach($times as $time)
                                        <option value="{{$time}}">{{$time}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group location">
                                <label for="Location">Location</label>
                                <select class="form-control" id="Location" name="location" required>
                                    <option selected="true" value="" disabled="disabled">Select Location</option>
                                    @forelse($branches as $branch)
                                        <option value="{{$branch->slug}}">{{$branch->translation->title}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group location">
                                <label for="Location">Book Your Services </label>
                                <select class="form-control" name="services" required>
                                    <option selected="true" value="" disabled="disabled">Select Services</option>
                                    <option value="Wheel Alignment">Wheel Alignment</option>
                                    <option value="Tire Balancing">Tire Balancing</option>
                                    <option value="Tire Rotation">Tire Rotation</option>
                                    <option value="Flat tire Repair">Flat tire Repair</option>
                                    <option value="Engine & Suspensions">Engine & Suspensions</option>
                                    <option value="Transmission & belt">Transmission & belt</option>
                                    <option value="Radiator">Radiator</option>
                                    <option value="Brake pads">Brake pads</option>
                                    <option value="Oil">Oil</option>
                                    <option value="Battery">Battery</option>
                                    <option value="Ac">Ac</option>
                                    <option value="other">other</option>
                                </select>
                            </div>
                            <div class="submit-btn">
                                <button type="submit" class="btn btn--primary btn--animate">{{__('Book an appointment')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6 cols">
                    <div class="img-block">
                        <img class="img-fluid right-car-img" src="{{asset('assets/front-tyre-shop/images/right-car.jpg')}}"
                             alt="right-car-img">
                    </div>
                </div>
            </div>
        </div>
    </section>--}}

    <!-- Our Services Section Start -->
    {{--<section class="our-services spacing">
        <div class="container">
            <div class="text-center">
                <h2 class="secondary-headline secondary-headline-white">
                    {{__('Our Services')}}
                    <img class="left-border img-fluid" src="{{asset('assets/front-tyre-shop/images/left-border-white.png')}}" alt="left-border">
                    <img class="right-border img-fluid" src="{{asset('assets/front-tyre-shop/images/right-border-white.png')}}" alt="right-border">
                </h2>
            </div>
            <div class="row custom-row">
                @forelse($services as $service)
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 cols">
                    <div class="services-card">
                        <div class="services-card-title text-center">
                            <h4 class="title">{{$service->translation->title}}</h4>
                        </div>
                        <a href="{!! route('front.services.detail',['slug' => $service->slug]) !!}">
                        <div class="services-card-content">
                            <img src="{{url($service->icon)}}" class="img-fluid flaticon">
                        </div>
                        </a>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>--}}
    <!-- Our Services Section End-->

    <!-- Buy Tyres Section Start-->
    @if(showPromotionSlider(config('settings.show_promotion_slider')))
    <Section class="slider buy-3-slider">
        <div id="carouselExampleControls-01" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @forelse($promotions as $promotion)
                    <div class="carousel-item @if($loop->first) active @endif">
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                            <img class="img-fluid mx-auto" src="{{$promotion->image}}" style="max-height: 600px"/>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls-01" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls-01" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </Section>
    @endif
{{--    <section class="buy-tyres-section spacing d-none">
        <div class="text-box text-center">
            <h2 class="secondary-headline text-white mb-35">
                BUY 3 GET 1 FREE!
            </h2>
            <p class="text  text-white mb-35">
                For A Limited Time on Selected Brands
            </p>
            <h5 class="sub-text  text-white mb-35">
                TYRES 2020
            </h5>
            <div class="">
                <a href="{{route('front.product.index')}}" class="btn btn--primary btn--animate">Buy Now</a>
            </div>
        </div>
        <div class="left-img">
            <img class="three-tyres img-fluid" src="{{asset('assets/front-tyre-shop/images/three-tyres.png')}}" alt="three-tyres">
        </div>
        <div class="right-img">
            <img class="single-tyre img-fluid" src="{{asset('assets/front-tyre-shop/images/single-tyre.png')}}" alt="single-tyre">
        </div>
    </section>--}}
    <!-- Buy Tyres Section End -->





    <section class="why-choose">
        <div class="container">
            <div class="social-icons d-flex justify-content-between d-md-none mb-5">
                <div class="title">
                    <h3 class="follow-us">Follow Us</h3>
                </div>
                <div class="icons">
                    <a href="{!! config('settings.facebook_url') !!}" class="font-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="{!! config('settings.instagram_url') !!}" class="font-icon"><i class="fab fa-instagram"></i></a>
                    <a href="{!! config('settings.twitter_url') !!}" class="font-icon"><i class="fab fa-twitter"></i></a>
                    {{-- <a href="https://wa.me/{!! __(config('settings.contact_number')) !!}/?text=contact us" class="font-icon"><img src="C:\xampp\htdocs\tyre-shops-laravel\public\assets\front-tyre-shop\images\whats-app.png" alt="" class="whats-app-icon"></a>--}}
                </div>
            </div>
            <div class="text-center">
                    <h2 class="secondary-headline secondary-headline-orange">
                        Why Choose
                        <img class="left-border img-fluid" src="{{asset('assets/front-tyre-shop/images/left-border-orange.png')}}" alt="left-border">
                        <img class="right-border img-fluid" src="{{asset('assets/front-tyre-shop/images/right-border-orange.png')}}" alt="right-border">
                    </h2>
            </div>
        </div>         
    </section>
    <!-- Book an appointment Section End-->    
</main>
@endsection
@push('script-page-level')
{{--<script src="{{asset('assets/front/js/main.js')}}"></script>--}}

@endpush