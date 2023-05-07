<!-- Site Footer Start -->
<footer class="site-footer">
    <div class="footer-part-one">
        <div class="container">
            <div class="row footer-row">
                <div class="col-12 col-sm-6 col-lg-4 cols d-none d-md-block">
                    <div class="logo-desc-sec">
                        <p class="desc text-justify">{{__(config('settings.footer_short_description'))}}</p>
                        <div class="social-icons">
                            <div class="title">
                                <h3 class="follow-us">{!! __('Follow Us') !!}</h3>
                            </div>
                            <div class="icons">
                                <a href="{!! __(config('settings.facebook_url')) !!}" class="font-icon"><i class="fab fa-facebook-f"></i></a>
                                <a href="{!! __(config('settings.instagram_url')) !!}" class="font-icon"><i class="fab fa-instagram"></i></a>
                                <a href="{!! __(config('settings.twitter_url')) !!}" class="font-icon"><i class="fab fa-twitter"></i></a>
                                {{-- <a href="https://wa.me/{!! __(config('settings.contact_number')) !!}/?text=contact us" class="font-icon"><img src="C:\xampp\htdocs\tyre-shops-laravel\public\assets\front-tyre-shop\images\whats-app.png" alt="" class="whats-app-icon"></a>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 cols">
                    <div class="links">
                        <h4 class="footer-title">
                            {!! __('Quick Links') !!}
                        </h4>
                        <ul class="footer-menu">
                            <li class="menu-item"><i class="fas fa-caret-right"></i>
                                <a href="{{ route('front.index') }}" class="menu-link">
                                    {!! __(' Home') !!}</a>
                            </li>
                            <li class="menu-item"><i class="fas fa-caret-right"></i><a href="{{route('front.services.index')}}" class="menu-link">
                                    {{__('Our Services')}}</a>
                            </li>
                            <li class="menu-item"><i class="fas fa-caret-right"></i><a href="{{route('front.packages.index')}}" class="menu-link">
                                    Packages</a>
                            </li>
                            <li class="menu-item"><i class="fas fa-caret-right"></i><a href="{{route('front.brands.index')}}" class="menu-link">
                                    Brands</a>
                            </li>
                            <li class="menu-item"><i class="fas fa-caret-right"></i><a href="{{route('front.site.map')}}" class="menu-link">
                                    {{__('Site Map')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                {{--Repairs--}}
                <div class="col-12 col-sm-6 col-lg-3 cols">
                    <div class="links">
                        <h4 class="footer-title">
                            {!! __('Auto Repairs') !!}
                        </h4>
                        <ul class="footer-menu">
                            @forelse($indexRepairs as $repair)
                            <li class="menu-item"><i class="fas fa-caret-right"></i><a href="{!! route('front.services.detail',['slug' => $repair->slug]) !!}" class="menu-link">
                                    {{$repair->translation->title}}</a>
                            </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
                {{--Services--}}
                <div class="col-12 col-sm-6 col-lg-2 cols">
                    <div class="links">
                        <h4 class="footer-title">
                            {{__('Auto Service')}}
                        </h4>
                        <ul class="footer-menu">
                            @forelse($indexServices as $service)
                            <li class="menu-item"><i class="fas fa-caret-right"></i><a href="{!! route('front.services.detail',['slug' => $service->slug]) !!}" class="menu-link">
                                    {{$service->translation->title}}</a>
                            </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-part-two">
        <div class="container">
            <div class="text-center">
                <h2 class="secondary-headline secondary-headline-orange">
                    Branch Locater
                    <img class="left-border img-fluid" src="{{asset('assets/front-tyre-shop/images/left-border-orange.png')}}" alt="left-border">
                    <img class="right-border img-fluid" src="{{asset('assets/front-tyre-shop/images/right-border-orange.png')}}" alt="right-border">
                </h2>
            </div>
            <div class="row footer-row branches-row">
                <div class="col-12 col-sm-6 col-lg-4 cols d-none">
                    <div class="contact-info">
                        <h5 class="sub-title">
                            {!! __("Contact Info") !!}
                        </h5>
                        <div class="contact-menu">
                            <a href="tel:{{__(config('settings.contact_number'))}}" class="links">
                                <i class="flaticon flaticon-phone"></i> Call us: {{__(config('settings.contact_number'))}}
                            </a>
                            <a href="mailto:{{__(config('settings.email'))}}" class="links">
                                <i class="fas fa-envelope"></i> Email: {{__(config('settings.email'))}}
                            </a>
                            {{-- <a href="#" class="links">--}}
                            {{-- <i class="flaticon flaticon-globe"></i> Web: stop&gouae.com--}}
                            {{-- </a>--}}
                            <a class="links" target="_blank" href="https://www.google.com/maps/dir//{{__(config('settings.latitude'))}},{{__(config('settings.longitude'))}}/@ {{__(config('settings.latitude'))}},{{__(config('settings.longitude'))}},12z">
                                <i class="fas fa-map-marker-alt"></i> Address: {{__(config('settings.address'))}}

                            </a>
                        </div>
                    </div>
                </div>
                @foreach($branches as $branch)
                <div class="col-12 col-sm-6 col-lg-3 cols d-md-none">
                <div class="branches-card">
                                    <div class="img-block">
                                        <a href="javascript:void(0)">
                                            <img src="{{imageUrl($branch->image,262,160,90,1)}}" alt="branch-img" class="img-fluid">
                                        </a>
                                        <div class="branch-name">
                                            <h4 class="title">{{$branch->translation->title}}</h4>
                                        </div>
                                    </div>
                                    <div class="branch-desc">
                                        <div class="items">
                                            <i class="fas fa-map-marker-alt"></i> <a class="links" target="_blank" href="https://www.google.com/maps/dir//{!! $branch->latitude !!},{!! $branch->longitude !!}/@ {!! $branch->latitude !!},{!! $branch->longitude !!},12z">{{$branch->address}}</a>
                                        </div>
                                        <div class="items">
                                            <i class="fas fa-phone-alt"></i><a class="links" href="tel:{{$branch->phone}}">{{$branch->phone}}</a>
                                        </div>
                                        <div class="items">
                                            <img src="{{asset('assets\front-tyre-shop\images\whats-app.png')}}" alt="whats-app-icon" class="whats-app-icon img-fluid"> <a class="links" target="_blank" href="https://wa.me/{{$branch->whatsapp_phone}}">{{$branch->whatsapp_phone}}</a>
                                        </div>
                                        <div class="items">
                                            <i class="fas fa-envelope"></i> <a class="links" href="mailto:info@sdtyres.com">{{config('settings.email')}}</a>
                                        </div>
                                    </div>
                                </div>
                </div>
                @endforeach
                <div class="col-md-12 d-none d-md-block">
                        <div class="branches-slider">
                            @foreach($branches as $branch)
                            <div>
                                <div class="branches-card">
                                    <div class="img-block">
                                        <a href="javascript:void(0)">
                                            <img src="{{imageUrl($branch->image,262,160,90,1)}}" alt="branch-img" class="img-fluid">
                                        </a>
                                        <div class="branch-name">
                                            <h4 class="title">{{$branch->translation->title}}</h4>
                                        </div>
                                    </div>
                                    <div class="branch-desc">
                                        <div class="items">
                                            <i class="fas fa-map-marker-alt"></i> <a class="links" target="_blank" href="https://www.google.com/maps/dir//{!! $branch->latitude !!},{!! $branch->longitude !!}/@ {!! $branch->latitude !!},{!! $branch->longitude !!},12z">{{$branch->address}}</a>
                                        </div>
                                        <div class="items">
                                            <i class="fas fa-phone-alt"></i><a class="links" href="tel:{{$branch->phone}}">{{$branch->phone}}</a>
                                        </div>
                                        <div class="items">
                                            <img src="{{asset('assets\front-tyre-shop\images\whats-app.png')}}" alt="whats-app-icon" class="whats-app-icon img-fluid"> <a class="links" target="_blank" href="https://wa.me/{{$branch->whatsapp_phone}}">{{$branch->whatsapp_phone}}</a>
                                        </div>
                                        <div class="items">
                                            <i class="fas fa-envelope"></i> <a class="links" href="mailto:info@sdtyres.com">{{config('settings.email')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copy-right-sec d-flex align-items-center justify-content-center flex-column flex-md-row">
        <p class="text-center text">
            <a href="#" class="link">{{__(config('settings.company_name'))}}</a> - {{__("Copyrights 2020 - All Rights Reserved")}}
        </p>
        <p class="text-center text pt-2 pt-md-0">
            <span class="ml-5 mr-4 d-none d-md-inline-block">|</span><a href="{{ route('front.pages', ['slug' => config('settings.terms_and_conditions')]) }}" class="link">{{__('Terms & Conditions')}}</a></span><span class="mx-4">|</span><a href="{{ route('front.pages', ['slug' => config('settings.privacy_policy')]) }}" class="link">{{__('Privacy Policy')}}</a>
        </p>
    </div>
    <a href="https://wa.me/{{config('settings.company_whatsapp_number')}}" target="_blank" class="whats-app-btn"><img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/whats-app-icon.svg')}}" alt="whtas-app"></a>
</footer>
<!-- Site Footer End-->