<!-- header -->
<div class="collapseable-nav" style="display: none;">
    <ul class="navbar-nav ">
        <li class="nav-item {{url()->current() == route('front.index') ? :''}}">

        </li>
        <li class="nav-item {{url()->current() == route('front.index') ? :''}}">
            <div id="accordion">
                <!-- <div class="panel"> -->
                <a class="nav-link d-flex align-items-center collapse-btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" href="javascript:void(0)"><i class="fas fa-chevron-down pr-3"></i>Services</a>
                <ul class="collapse ml-5" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordion">
                    @forelse($indexServices as $service)
                    <li class="nav-item">
                        <a class="sub-item" href="{!! route('front.services.detail',['slug' => $service->slug]) !!}">{{$service->translation->title}}</a>
                    </li>
                    @empty
                    @endforelse
                </ul>
                <!-- </div> -->
                <!-- <div class="panel"> -->
                <a class="nav-link d-flex align-items-center collapse-btn" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo" href="javascript:void(0)"><i class="fas fa-chevron-down pr-3"></i>Repairs</a>
                <ul class="collapse ml-5" id="collapsetwo" aria-labelledby="headingOne" data-parent="#accordion">
                    @forelse($indexRepairs as $repair)
                    <li class="nav-item">
                        <a class="sub-item" href="{!! route('front.services.detail',['slug' => $repair->slug]) !!}">{{$repair->translation->title}}</a>
                    </li>
                    @empty
                    @endforelse
                </ul>
                <!-- </div> -->

            </div>
        </li>
        <li class="nav-item {{url()->current() == route('front.index') ? 'active':''}}">
            <a class="nav-link" href="{{route('front.index')}}">Home</a>
        </li>
        <li class="nav-item {{url()->current() == route('front.services.index') || str_contains(url()->current(),'service') ? 'active':'' }}">
            <a class="nav-link" href="{{route('front.services.index')}}">Services</a>
        </li>
        <li class="nav-item {{url()->current() == route('front.packages.index')? 'active':'' }}">
            <a class="nav-link" href="{{route('front.packages.index')}}">Packages</a>
        </li>
        <li class="nav-item {{url()->current() == route('front.brands.index')? 'active':'' }}">
            <a class="nav-link" href="{{route('front.brands.index')}}">Brands</a>
        </li>
        <li class="nav-item {{ url()->current() == route('front.pages', ['slug' => config('settings.about_us')] ) ? 'active':''}}">
            <a class="nav-link" href="{{ route('front.pages', ['slug' => config('settings.about_us')]) }}">about</a>
        </li>
        <li class="nav-item {{url()->current() == route('front.contactUs') ? 'active':''}}">
            <a class="nav-link" href="{{ route('front.contactUs') }}">contact</a>
        </li>
        @if(!auth()->user())
            <div class="icons d-md-none">
                {{-- <button type="button" class="search-btn"  data-toggle="modal" data-target="#myModal"><i class="fas fa-search"></i></button>--}}
                <a href="{{route('front.auth.login')}}" class="btn btn--black btn--animate login-btn-mt">login</a>
            </div>
        @else
        <div class="icons  d-md-none">
            <div class="dropdown">
                <a data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false" role="button" id="dropdownMenuLink" class="btn btn--black btn--animate  dropdown-toggle">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</a>
                <div class="dropdown-menu nav-left-mt-a" x-placement="top-start" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item nav-item {!! (url()->current() == route('front.dashboard.index')) ?'active':'' !!}">
                        <a href="{!! route('front.dashboard.index') !!}" class="nav-link"><i class="fas fa-caret-right"></i>My Account</a>
                    </li>
                    <li class="dropdown-item nav-item {!! (url()->current() == route('front.dashboard.order.index',['status'=>'confirmed'])  || str_contains(url()->current(),'order-detail') || str_contains(url()->current(),'orders')  ) ?'active':'' !!}">
                        <a href="{!! route('front.dashboard.order.index',['status'=>'confirmed']) !!}" class="nav-link"><i class="fas fa-caret-right"></i>my order</a>
                    </li>
                    <li class="dropdown-item nav-item">
                        <a href="{{route('front.dashboard.address.index')}}" class="nav-link"><i class="fas fa-caret-right"></i>Address Book</a>
                    </li>
                    <li class="dropdown-item nav-item {!! (url()->current() == route('front.dashboard.edit-profile')) ?'active':'' !!}">
                        <a href="{{route('front.dashboard.edit-profile')}}" class="nav-link"><i class="fas fa-caret-right"></i>Account Information</a>
                    </li>
                    <li class="dropdown-item nav-item {!! (url()->current() == route('front.dashboard.subscription')) ?'active':'' !!}">
                        <a href="{!! route('front.dashboard.subscription') !!}" class="nav-link"><i class="fas fa-caret-right"></i>Newsletter Subscriptions
                        </a>
                    </li>
                    <li class="dropdown-item nav-item">
                        <a href="{!! route('front.auth.logout') !!}" class="nav-link"><i class="fas fa-caret-right"></i>logout</a>
                    </li>
                </div>
            </div>
        </div>
            @endif
    </ul>
</div>
<section class="header">
    <!-- Site header/Navigation Bar Start-->
    <header class="site-header">
        <div class="menu">
            <div class="container">
                <nav class="navbar navbar-expand-xl d-flex justify-content-between align-items-center flex-wrap">
                    <div class="contact-info-sec">
                        <p class="desc">
                            We are Only one call Away
                        </p>
                        <i class="fas fa-arrow-right"></i>
                        <h4 class="no">
                            <a class="link" href="tel:{{config('settings.contact_number')}}">
                                 {{config('settings.contact_number')}}
                            </a>
                        </h4>
                    </div>
                    <div class="logo-sec">
                        <a class="logo" href="{{route('front.index')}}"><img src="{!! imageUrl(asset('assets/front-tyre-shop/images/logo.png'), 392, 56, 100, 2) !!}" alt="site-logo" class="site-logo">
                        </a>
                    </div>

                    <!-- <a class="logo" href="{{route('front.index')}}"><img src="{!! imageUrl(asset('assets/front-tyre-shop/images/logo.png'), 198, 44, 100, 1) !!}" alt="site-logo"
                 <a class="logo" href="{{route('front.index')}}"><img src="{!! imageUrl(asset('assets/front-tyre-shop/images/logo.png'), 198, 44, 100, 2) !!}" alt="site-logo"
                                                  class="site-logo"></a> -->
                    <div class="toggle-btn-menu">
                        <button class="navbar-toggler-btn" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                            <div class="hamburger hamburger--spin">
                                <div class="hamburger-box">
                                    <div class="hamburger-inner"></div>
                                </div>
                            </div>
                        </button>

                    </div>


                    @if(!auth()->user())
                    <div class="icons cart-icon">
                        {{-- <button type="button" class="search-btn"  data-toggle="modal" data-target="#myModal"><i class="fas fa-search"></i></button>--}}
                        <a href="{{route('front.cart.index')}}" class="icon-btn"><img src="{{asset('assets/front-tyre-shop/images/basket.png')}}" class="img-fluid shopping-basket" alt="shopping-basket"></a>
                    </div>
                        <div class="icons login-btn-lg">
                        {{-- <button type="button" class="search-btn"  data-toggle="modal" data-target="#myModal"><i class="fas fa-search"></i></button>--}}
                        <a href="{{route('front.cart.index')}}" class="icon-btn"><img src="{{asset('assets/front-tyre-shop/images/basket.png')}}" class="img-fluid shopping-basket" alt="shopping-basket"></a>
                        <a href="{{route('front.auth.login')}}" class="btn btn--primary btn--animate login-btn-mt">login</a>
                    </div>
                    @else
                    <div class="icons">
                        {{-- <button type="button" class="search-btn"  data-toggle="modal" data-target="#myModal"><i class="fas fa-search"></i></button>--}}
                        <a href="{{route('front.cart.index')}}" class="icon-btn">
                            <img src="{{asset('assets/front-tyre-shop/images/basket.png')}}" class="img-fluid shopping-basket" alt="shopping-basket">
                            <span id="cartCount" class="quantity">{!! session('cart') !!}</span>
                        </a>
                        <div class="dropdown d-none d-md-block">
                            <a data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false" role="button" id="dropdownMenuLink" class="btn btn--primary btn--animate  dropdown-toggle">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</a>
                            <div class="dropdown-menu nav-left-mt-a" x-placement="top-start" aria-labelledby="dropdownMenuLink">
                                <li class="dropdown-item nav-item {!! (url()->current() == route('front.dashboard.index')) ?'active':'' !!}">
                                    <a href="{!! route('front.dashboard.index') !!}" class="nav-link"><i class="fas fa-caret-right"></i>My Account</a>
                                </li>
                                <li class="dropdown-item nav-item {!! (url()->current() == route('front.dashboard.order.index',['status'=>'confirmed'])  || str_contains(url()->current(),'order-detail') || str_contains(url()->current(),'orders')  ) ?'active':'' !!}">
                                    <a href="{!! route('front.dashboard.order.index',['status'=>'confirmed']) !!}" class="nav-link"><i class="fas fa-caret-right"></i>my order</a>
                                </li>
                                <li class="dropdown-item nav-item">
                                    <a href="{{route('front.dashboard.address.index')}}" class="nav-link"><i class="fas fa-caret-right"></i>Address Book</a>
                                </li>
                                <li class="dropdown-item nav-item {!! (url()->current() == route('front.dashboard.edit-profile')) ?'active':'' !!}">
                                    <a href="{{route('front.dashboard.edit-profile')}}" class="nav-link"><i class="fas fa-caret-right"></i>Account Information</a>
                                </li>
                                <li class="dropdown-item nav-item {!! (url()->current() == route('front.dashboard.subscription')) ?'active':'' !!}">
                                    <a href="{!! route('front.dashboard.subscription') !!}" class="nav-link"><i class="fas fa-caret-right"></i>Newsletter Subscriptions
                                    </a>
                                </li>
                                <li class="dropdown-item nav-item">
                                    <a href="{!! route('front.auth.logout') !!}" class="nav-link"><i class="fas fa-caret-right"></i>logout</a>
                                </li>

                            </div>
                        </div>
                    </div>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Modal -->
    <div class="modal fade tyre-search-model" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="checkboxes-row d-flex justify-content-center align-items-center w-100 flex-wrap">
                        <div class="checkboxes first-checkbox">
                            <div class="form-group  m-b-25">
                                <label class="checkbox-container primary-title">Shop By Size
                                    <input type="checkbox" name="shop_by_size" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="checkboxes second-checkbox">
                            <div class="form-group  m-b-25">
                                <label class="checkbox-container primary-title">Shop By Vehicle
                                    <input type="checkbox" name="shop_by_vehicle">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right_tyre_sug mb-5 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="2.66457in" height="0.96000in" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 489.33 218.2" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs>
                            <style type="text/css">
                                .fil1 {
                                    fill: black
                                }

                                .fil0 {
                                    fill: black;
                                    fill-rule: nonzero
                                }
                            </style>
                        </defs>
                        <g id="Layer_x0020_1">
                            <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                            <path class="fil0" d="M11.11 212.1c-6.05,0 -9.07,-3.02 -9.07,-9.07 0,-6.05 3.02,-9.07 9.07,-9.07 6.07,0 9.11,3.02 9.11,9.07 0,6.05 -3.04,9.07 -9.11,9.07zm0 -3.38c1.84,0 3.14,-0.44 3.91,-1.32 0.77,-0.88 1.16,-2.34 1.16,-4.37 0,-2.01 -0.39,-3.45 -1.16,-4.33 -0.77,-0.88 -2.08,-1.32 -3.91,-1.32 -1.81,0 -3.1,0.44 -3.88,1.32 -0.77,0.88 -1.16,2.33 -1.16,4.33 0,2.03 0.39,3.49 1.16,4.37 0.77,0.88 2.06,1.32 3.88,1.32z"></path>
                            <path id="1" class="fil0" d="M24.11 194.32l3.67 0 0.18 1.84c0.83,-0.66 1.8,-1.19 2.9,-1.6 1.1,-0.4 2.28,-0.61 3.53,-0.61 2.25,0 3.89,0.53 4.92,1.58 1.03,1.05 1.54,2.69 1.54,4.92l0 11.28 -3.97 0 0 -11.09c0,-1.35 -0.28,-2.29 -0.84,-2.83 -0.56,-0.54 -1.59,-0.81 -3.09,-0.81 -0.91,0 -1.79,0.18 -2.66,0.55 -0.87,0.37 -1.6,0.84 -2.19,1.43l0 12.75 -4 0 0 -17.41z"></path>
                            <path id="2" class="fil0" d="M65.58 212.1c-1.84,0 -3.22,-0.48 -4.15,-1.45 -0.93,-0.97 -1.4,-2.33 -1.4,-4.1l0 -9.11 -2.57 0 0 -3.12 2.57 0 0 -4 3.97 -1.21 0 5.22 4.63 0 -0.26 3.12 -4.37 0 0 8.89c0,1 0.23,1.71 0.68,2.11 0.45,0.4 1.22,0.61 2.3,0.61 0.66,0 1.36,-0.12 2.09,-0.37l0 2.83c-0.96,0.39 -2.12,0.59 -3.49,0.59z"></path>
                            <path id="3" class="fil0" d="M72.26 186.98l4 0 0 9.04c0.78,-0.64 1.71,-1.14 2.77,-1.51 1.07,-0.37 2.23,-0.55 3.51,-0.55 2.2,0 3.83,0.53 4.89,1.58 1.05,1.05 1.58,2.69 1.58,4.92l0 11.28 -3.97 0 0 -11.09c0,-1.35 -0.29,-2.29 -0.86,-2.83 -0.58,-0.54 -1.57,-0.81 -2.99,-0.81 -0.88,0 -1.78,0.19 -2.68,0.57 -0.91,0.38 -1.65,0.88 -2.24,1.49l0 12.67 -4 0 0 -24.76z"></path>
                            <path id="4" class="fil0" d="M102.31 212.1c-3.09,0 -5.45,-0.76 -7.09,-2.28 -1.64,-1.52 -2.46,-3.8 -2.46,-6.83 0,-2.87 0.72,-5.09 2.17,-6.67 1.44,-1.58 3.59,-2.37 6.43,-2.37 2.57,0 4.54,0.67 5.91,2.02 1.37,1.35 2.06,3.15 2.06,5.4l0 3.23 -12.75 0c0.2,1.67 0.8,2.82 1.8,3.47 1,0.65 2.58,0.97 4.74,0.97 0.88,0 1.78,-0.09 2.7,-0.26 0.92,-0.17 1.73,-0.39 2.44,-0.66l0 2.94c-1.54,0.69 -3.53,1.03 -5.95,1.03zm3.49 -10.1l0 -1.21c0,-1.25 -0.34,-2.2 -1.03,-2.85 -0.69,-0.65 -1.79,-0.97 -3.31,-0.97 -1.81,0 -3.08,0.39 -3.8,1.17 -0.72,0.78 -1.08,2.07 -1.08,3.86l9.22 0z"></path>
                            <path id="5" class="fil0" d="M132.61 212.1c-1.18,0 -2.31,-0.08 -3.42,-0.24 -1.1,-0.16 -2.01,-0.37 -2.72,-0.64l0 -3.38c0.81,0.32 1.71,0.56 2.7,0.73 0.99,0.17 1.97,0.26 2.92,0.26 1.42,0 2.41,-0.12 2.97,-0.37 0.56,-0.24 0.84,-0.72 0.84,-1.43 0,-0.64 -0.26,-1.11 -0.77,-1.41 -0.51,-0.31 -1.48,-0.68 -2.9,-1.12l-1.1 -0.37c-1.76,-0.59 -3.05,-1.24 -3.86,-1.97 -0.81,-0.72 -1.21,-1.79 -1.21,-3.21 0,-1.64 0.59,-2.88 1.76,-3.73 1.18,-0.84 3.01,-1.27 5.51,-1.27 0.96,0 1.89,0.07 2.81,0.22 0.92,0.15 1.71,0.33 2.37,0.55l0 3.34c-0.66,-0.27 -1.4,-0.48 -2.22,-0.62 -0.82,-0.15 -1.6,-0.22 -2.33,-0.22 -1.35,0 -2.33,0.12 -2.94,0.35 -0.61,0.23 -0.92,0.67 -0.92,1.3 0,0.56 0.23,0.99 0.7,1.27 0.47,0.28 1.38,0.64 2.76,1.08l0.81 0.26c1.42,0.44 2.52,0.89 3.31,1.34 0.78,0.45 1.35,1 1.71,1.65 0.35,0.65 0.53,1.49 0.53,2.52 0,3.4 -2.44,5.11 -7.31,5.11z"></path>
                            <path id="6" class="fil0" d="M146.17 187.38l4.37 0 0 3.31 -4.37 0 0 -3.31zm0.33 9.99l-2.64 0 0.37 -3.05 6.28 0 0 17.41 -4 0 0 -14.36z"></path>
                            <path id="7" class="fil0" d="M162.36 212.1c-2.52,0 -4.47,-0.67 -5.86,-2 -1.38,-1.33 -2.08,-3.51 -2.08,-6.52 0,-2.03 0.36,-3.77 1.07,-5.22 0.71,-1.44 1.69,-2.54 2.94,-3.29 1.25,-0.75 2.68,-1.12 4.3,-1.12 1.03,0 1.96,0.12 2.79,0.37 0.83,0.24 1.63,0.62 2.39,1.14l0 -8.48 4 0 0 24.76 -3.42 0 -0.26 -1.73c-0.81,0.73 -1.68,1.27 -2.61,1.6 -0.93,0.33 -2.02,0.5 -3.27,0.5zm1.07 -3.01c1.79,0 3.28,-0.61 4.48,-1.84l0 -8.71c-1.15,-1.03 -2.6,-1.54 -4.33,-1.54 -1.69,0 -2.96,0.56 -3.82,1.69 -0.86,1.13 -1.29,2.77 -1.29,4.92 0,2.03 0.39,3.45 1.16,4.26 0.77,0.81 2.04,1.21 3.8,1.21z"></path>
                            <path id="8" class="fil0" d="M185.36 212.1c-3.09,0 -5.45,-0.76 -7.09,-2.28 -1.64,-1.52 -2.46,-3.8 -2.46,-6.83 0,-2.87 0.72,-5.09 2.17,-6.67 1.44,-1.58 3.59,-2.37 6.43,-2.37 2.57,0 4.54,0.67 5.91,2.02 1.37,1.35 2.06,3.15 2.06,5.4l0 3.23 -12.75 0c0.2,1.67 0.8,2.82 1.8,3.47 1,0.65 2.58,0.97 4.74,0.97 0.88,0 1.78,-0.09 2.7,-0.26 0.92,-0.17 1.73,-0.39 2.44,-0.66l0 2.94c-1.54,0.69 -3.53,1.03 -5.95,1.03zm3.49 -10.1l0 -1.21c0,-1.25 -0.34,-2.2 -1.03,-2.85 -0.69,-0.65 -1.79,-0.97 -3.31,-0.97 -1.81,0 -3.08,0.39 -3.8,1.17 -0.72,0.78 -1.08,2.07 -1.08,3.86l9.22 0z"></path>
                            <polygon id="9" class="fil0" points="209.12,194.32 213.13,194.32 216.14,206.99 219.55,196.45 219.55,194.32 222.6,194.32 226.39,206.99 229.4,194.32 233.37,194.32 228.81,211.73 225.03,211.73 221.32,200.35 217.53,211.73 213.71,211.73 "></polygon>
                            <path id="10" class="fil0" d="M241.04 212.1c-1.76,0 -3.23,-0.46 -4.41,-1.38 -1.18,-0.92 -1.76,-2.23 -1.76,-3.95 0,-1.71 0.58,-3.07 1.74,-4.06 1.16,-0.99 2.91,-1.49 5.23,-1.49l5.58 0 0 -0.77c0,-0.86 -0.13,-1.52 -0.39,-2 -0.26,-0.48 -0.73,-0.83 -1.41,-1.05 -0.69,-0.22 -1.66,-0.33 -2.94,-0.33 -2.06,0 -3.98,0.31 -5.77,0.92l0 -2.97c0.83,-0.32 1.81,-0.58 2.94,-0.77 1.13,-0.2 2.31,-0.29 3.56,-0.29 2.6,0 4.55,0.53 5.86,1.58 1.31,1.05 1.97,2.72 1.97,5l0 11.2 -3.42 0 -0.26 -1.76c-0.73,0.71 -1.63,1.24 -2.68,1.6 -1.05,0.35 -2.34,0.53 -3.86,0.53zm1.07 -2.87c1.15,0 2.18,-0.2 3.09,-0.59 0.91,-0.39 1.65,-0.94 2.24,-1.65l0 -3.05 -5.51 0c-1.18,0 -2.03,0.22 -2.55,0.66 -0.53,0.44 -0.79,1.14 -0.79,2.09 0,0.88 0.29,1.52 0.88,1.93 0.59,0.4 1.47,0.61 2.64,0.61z"></path>
                            <path id="11" class="fil0" d="M260.03 212.1c-1.47,0 -2.56,-0.36 -3.27,-1.07 -0.71,-0.71 -1.07,-1.86 -1.07,-3.45l0 -20.61 4 0 0 20.24c0,0.66 0.12,1.12 0.35,1.38 0.23,0.26 0.61,0.39 1.12,0.39 0.59,0 1.15,-0.07 1.69,-0.22l0 2.9c-0.81,0.29 -1.75,0.44 -2.83,0.44z"></path>
                            <path id="12" class="fil0" d="M269.4 212.1c-1.47,0 -2.56,-0.36 -3.27,-1.07 -0.71,-0.71 -1.07,-1.86 -1.07,-3.45l0 -20.61 4 0 0 20.24c0,0.66 0.12,1.12 0.35,1.38 0.23,0.26 0.61,0.39 1.12,0.39 0.59,0 1.15,-0.07 1.69,-0.22l0 2.9c-0.81,0.29 -1.75,0.44 -2.83,0.44z"></path>
                            <path id="13" class="fil0" d="M297.28 212.1c-6.05,0 -9.07,-3.02 -9.07,-9.07 0,-6.05 3.02,-9.07 9.07,-9.07 6.07,0 9.11,3.02 9.11,9.07 0,6.05 -3.04,9.07 -9.11,9.07zm0 -3.38c1.84,0 3.14,-0.44 3.91,-1.32 0.77,-0.88 1.16,-2.34 1.16,-4.37 0,-2.01 -0.39,-3.45 -1.16,-4.33 -0.77,-0.88 -2.08,-1.32 -3.91,-1.32 -1.81,0 -3.1,0.44 -3.88,1.32 -0.77,0.88 -1.16,2.33 -1.16,4.33 0,2.03 0.39,3.49 1.16,4.37 0.77,0.88 2.06,1.32 3.88,1.32z"></path>
                            <path id="14" class="fil0" d="M310.06 197.44l-2.53 0 0 -3.12 2.53 0 0 -2.13c0,-1.76 0.5,-3.17 1.49,-4.22 0.99,-1.05 2.42,-1.58 4.28,-1.58 1.25,0 2.44,0.21 3.56,0.62l0 2.87c-0.76,-0.27 -1.53,-0.4 -2.31,-0.4 -1.15,0 -1.95,0.2 -2.39,0.61 -0.44,0.4 -0.66,1.12 -0.66,2.15l0 2.09 4.55 0 -0.18 3.12 -4.37 0 0 14.29 -3.97 0 0 -14.29z"></path>
                            <path id="15" class="fil0" d="M339.37 218.2c-1.32,0 -2.45,-0.17 -3.38,-0.51l0 -2.98c0.69,0.24 1.43,0.37 2.24,0.37 0.73,0 1.33,-0.12 1.8,-0.35 0.47,-0.23 0.87,-0.59 1.21,-1.08 0.34,-0.49 0.75,-1.2 1.21,-2.13l-7.75 -17.19 4.15 0 5.58 12.93 5.66 -12.93 4.11 0 -7.09 16.42c-1.05,2.5 -2.15,4.36 -3.29,5.6 -1.14,1.24 -2.63,1.85 -4.46,1.85z"></path>
                            <path id="16" class="fil0" d="M364.09 212.1c-6.05,0 -9.07,-3.02 -9.07,-9.07 0,-6.05 3.02,-9.07 9.07,-9.07 6.07,0 9.11,3.02 9.11,9.07 0,6.05 -3.04,9.07 -9.11,9.07zm0 -3.38c1.84,0 3.14,-0.44 3.91,-1.32 0.77,-0.88 1.16,-2.34 1.16,-4.37 0,-2.01 -0.39,-3.45 -1.16,-4.33 -0.77,-0.88 -2.08,-1.32 -3.91,-1.32 -1.81,0 -3.1,0.44 -3.88,1.32 -0.77,0.88 -1.16,2.33 -1.16,4.33 0,2.03 0.39,3.49 1.16,4.37 0.77,0.88 2.06,1.32 3.88,1.32z"></path>
                            <path id="17" class="fil0" d="M383.37 212.1c-2.08,0 -3.68,-0.58 -4.79,-1.74 -1.11,-1.16 -1.67,-2.85 -1.67,-5.05l0 -10.98 4 0 0 10.98c0,1.3 0.32,2.25 0.96,2.87 0.64,0.61 1.62,0.92 2.94,0.92 0.96,0 1.85,-0.18 2.68,-0.53 0.83,-0.35 1.57,-0.85 2.2,-1.49l0 -12.75 3.97 0 0 17.41 -3.64 0 -0.18 -1.8c-1.84,1.45 -3.99,2.17 -6.46,2.17z"></path>
                            <path id="18" class="fil0" d="M398.32 194.32l3.67 0 0.22 2.02c0.83,-0.54 1.82,-1.03 2.97,-1.47 1.15,-0.44 2.29,-0.75 3.42,-0.92l0 3.05c-1.05,0.2 -2.19,0.5 -3.42,0.9 -1.22,0.4 -2.18,0.83 -2.87,1.27l0 12.56 -4 0 0 -17.41z"></path>
                            <path id="19" class="fil0" d="M432.04 212.1c-1.84,0 -3.22,-0.48 -4.15,-1.45 -0.93,-0.97 -1.4,-2.33 -1.4,-4.1l0 -9.11 -2.57 0 0 -3.12 2.57 0 0 -4 3.97 -1.21 0 5.22 4.63 0 -0.26 3.12 -4.37 0 0 8.89c0,1 0.23,1.71 0.68,2.11 0.45,0.4 1.22,0.61 2.3,0.61 0.66,0 1.36,-0.12 2.09,-0.37l0 2.83c-0.96,0.39 -2.12,0.59 -3.49,0.59z"></path>
                            <path id="20" class="fil0" d="M441.01 218.2c-1.32,0 -2.45,-0.17 -3.38,-0.51l0 -2.98c0.69,0.24 1.43,0.37 2.24,0.37 0.73,0 1.33,-0.12 1.8,-0.35 0.47,-0.23 0.87,-0.59 1.21,-1.08 0.34,-0.49 0.75,-1.2 1.21,-2.13l-7.75 -17.19 4.15 0 5.58 12.93 5.66 -12.93 4.11 0 -7.09 16.42c-1.05,2.5 -2.15,4.36 -3.29,5.6 -1.14,1.24 -2.63,1.85 -4.46,1.85z"></path>
                            <path id="21" class="fil0" d="M459.04 194.32l3.67 0 0.22 2.02c0.83,-0.54 1.82,-1.03 2.97,-1.47 1.15,-0.44 2.29,-0.75 3.42,-0.92l0 3.05c-1.05,0.2 -2.19,0.5 -3.42,0.9 -1.22,0.4 -2.18,0.83 -2.87,1.27l0 12.56 -4 0 0 -17.41z"></path>
                            <path id="22" class="fil0" d="M480.23 212.1c-3.09,0 -5.45,-0.76 -7.09,-2.28 -1.64,-1.52 -2.46,-3.8 -2.46,-6.83 0,-2.87 0.72,-5.09 2.17,-6.67 1.44,-1.58 3.59,-2.37 6.43,-2.37 2.57,0 4.54,0.67 5.91,2.02 1.37,1.35 2.06,3.15 2.06,5.4l0 3.23 -12.75 0c0.2,1.67 0.8,2.82 1.8,3.47 1,0.65 2.58,0.97 4.74,0.97 0.88,0 1.78,-0.09 2.7,-0.26 0.92,-0.17 1.73,-0.39 2.44,-0.66l0 2.94c-1.54,0.69 -3.53,1.03 -5.95,1.03zm3.49 -10.1l0 -1.21c0,-1.25 -0.34,-2.2 -1.03,-2.85 -0.69,-0.65 -1.79,-0.97 -3.31,-0.97 -1.81,0 -3.08,0.39 -3.8,1.17 -0.72,0.78 -1.08,2.07 -1.08,3.86l9.22 0z"></path>
                            <path id="23" class="fil1" d="M244.67 142.09c12.37,0 22.54,9.43 23.71,21.49l21.17 0c14.25,-12.06 31.61,-19.73 50.13,-22.1 -4.25,-16.59 -12.73,-31.47 -24.23,-43.45 -12.47,16.65 -29.94,28.81 -49.98,34.74l-0.69 0.21 -0.17 -0.7c-4.9,-20.4 -3.02,-41.95 5.3,-61.14 -8.05,-2.14 -16.51,-3.29 -25.24,-3.29 -8.73,0 -17.19,1.14 -25.24,3.29 8.33,19.2 10.21,40.74 5.31,61.14l-0.17 0.7 -0.69 -0.21c-20.04,-5.93 -37.51,-18.08 -49.98,-34.74 -11.49,11.98 -19.98,26.87 -24.23,43.45 18.52,2.38 35.88,10.04 50.13,22.1l21.17 0c1.17,-12.06 11.34,-21.49 23.71,-21.49zm15.32 21.49c-1.13,-7.45 -7.56,-13.17 -15.32,-13.17 -7.77,0 -14.2,5.71 -15.33,13.17l30.65 0zm-73.17 0c-11.61,-7.8 -24.87,-12.74 -38.8,-14.43 -0.81,4.7 -1.29,9.52 -1.4,14.43l40.21 0zm154.49 -14.43c-13.93,1.69 -27.19,6.63 -38.8,14.43l40.2 0c-0.12,-4.91 -0.59,-9.73 -1.4,-14.43zm9.22 14.43l51.52 0c-1.25,-85.86 -71.23,-155.07 -157.38,-155.07 -86.15,0 -156.13,69.22 -157.38,155.07l51.52 0c1.24,-57.4 48.16,-103.56 105.86,-103.56 57.7,0 104.62,46.15 105.86,103.56zm60.03 0l78.78 0 0 6.66 -489.33 0 0 -6.66 78.78 0c1.25,-90.56 75.04,-163.58 165.89,-163.58 90.85,0 164.64,73.03 165.89,163.58zm-139.85 -40.89c15.64,-6.17 29.14,-16.58 39.06,-30.12 -9.36,-8.31 -20.31,-14.85 -32.34,-19.12 -6.87,15.42 -9.2,32.53 -6.72,49.24zm-52.08 0c2.48,-16.71 0.16,-33.82 -6.71,-49.24 -12.03,4.26 -22.99,10.81 -32.34,19.12 9.92,13.54 23.42,23.95 39.06,30.12z"></path>
                            <path id="24" class="fil0 tyre-205" d="M174.8 65.11c-0.04,-1.22 0.07,-2.43 0.33,-3.63 0.26,-1.21 0.68,-2.69 1.26,-4.45l0.29 -0.88c0.56,-1.7 0.89,-2.91 0.99,-3.64 0.1,-0.73 -0.05,-1.44 -0.45,-2.14 -0.4,-0.69 -0.93,-1.09 -1.61,-1.18 -0.67,-0.09 -1.46,0.13 -2.38,0.65 -1.51,0.87 -2.9,2.13 -4.17,3.78l-2.73 -4.77c0.63,-0.79 1.45,-1.59 2.44,-2.41 1,-0.82 2.04,-1.54 3.13,-2.17 2.33,-1.33 4.41,-1.79 6.25,-1.38 1.83,0.42 3.31,1.59 4.41,3.52 0.74,1.29 1.12,2.47 1.13,3.53 0.01,1.07 -0.25,2.4 -0.79,3.99l-0.25 0.74c-0.35,0.96 -0.62,1.79 -0.81,2.46 -0.2,0.68 -0.32,1.3 -0.37,1.85l6.42 -3.67 2.46 4.29 -14.08 8.07 -1.47 -2.57z"></path>
                            <path id="1" class="fil0 tyre-205" d="M201.54 55.03c-3.47,1.33 -6.32,1.4 -8.57,0.21 -2.25,-1.18 -4.05,-3.54 -5.4,-7.07 -1.36,-3.53 -1.6,-6.49 -0.72,-8.88 0.87,-2.39 3.05,-4.25 6.51,-5.58 3.46,-1.33 6.32,-1.4 8.57,-0.21 2.25,1.18 4.05,3.54 5.41,7.08 1.35,3.53 1.6,6.49 0.72,8.88 -0.88,2.38 -3.05,4.25 -6.51,5.58zm-1.97 -5.14c1.35,-0.52 2.13,-1.33 2.35,-2.45 0.22,-1.12 -0.03,-2.61 -0.75,-4.49 -0.72,-1.89 -1.54,-3.17 -2.45,-3.85 -0.91,-0.68 -2.04,-0.76 -3.39,-0.25 -1.35,0.52 -2.13,1.33 -2.36,2.43 -0.23,1.1 0.03,2.61 0.76,4.52 0.72,1.88 1.54,3.16 2.46,3.85 0.91,0.68 2.04,0.76 3.39,0.24z"></path>
                            <path id="2" class="fil0 tyre-205" d="M220.13 49.49c-1.11,0.2 -2.33,0.32 -3.69,0.37 -1.36,0.05 -2.48,-0.05 -3.39,-0.28l-0.92 -5.11c0.81,0.23 1.82,0.35 3.02,0.35 1.2,0 2.22,-0.07 3.05,-0.22 1.24,-0.22 2.11,-0.58 2.62,-1.07 0.5,-0.49 0.68,-1.15 0.53,-1.99 -0.14,-0.78 -0.46,-1.32 -0.95,-1.59 -0.49,-0.27 -1.28,-0.31 -2.36,-0.11l-6.63 1.19 -0.52 -2.91 -1.14 -9.61 14.11 -2.55 0.44 4.95 -8.22 1.49 0.36 3.15 2.47 -0.45c5.16,-0.93 8.16,0.91 8.99,5.51 0.41,2.24 -0.05,4.14 -1.36,5.71 -1.32,1.57 -3.45,2.63 -6.4,3.16z"></path>
                            <path id="3" class="fil0 tyre-55" d="M249.56 47.04c-1.12,-0.04 -2.35,-0.18 -3.68,-0.42 -1.33,-0.24 -2.42,-0.57 -3.25,-0.99l0.17 -5.19c0.74,0.4 1.7,0.72 2.88,0.97 1.17,0.26 2.18,0.4 3.03,0.43 1.26,0.04 2.19,-0.12 2.78,-0.49 0.6,-0.37 0.91,-0.98 0.94,-1.83 0.03,-0.8 -0.17,-1.38 -0.59,-1.75 -0.42,-0.37 -1.18,-0.58 -2.28,-0.61l-6.73 -0.23 0.1 -2.96 0.91 -9.64 14.33 0.49 -0.62 4.93 -8.35 -0.28 -0.31 3.15 2.51 0.09c5.24,0.18 7.79,2.6 7.62,7.27 -0.08,2.27 -0.92,4.03 -2.54,5.3 -1.61,1.26 -3.92,1.84 -6.92,1.74z"></path>
                            <path id="4" class="fil0 tyre-55" d="M267.41 49.22c-1.11,-0.2 -2.3,-0.52 -3.59,-0.95 -1.28,-0.43 -2.31,-0.92 -3.07,-1.45l0.93 -5.11c0.68,0.49 1.58,0.96 2.7,1.38 1.12,0.43 2.1,0.72 2.93,0.87 1.24,0.23 2.18,0.2 2.83,-0.08 0.65,-0.27 1.05,-0.83 1.2,-1.67 0.15,-0.79 0.03,-1.4 -0.33,-1.83 -0.37,-0.43 -1.09,-0.74 -2.17,-0.93l-6.63 -1.21 0.53 -2.91 2.31 -9.4 14.1 2.56 -1.33 4.8 -8.22 -1.5 -0.77 3.07 2.47 0.45c5.16,0.94 7.32,3.71 6.49,8.31 -0.41,2.23 -1.5,3.86 -3.28,4.87 -1.78,1.02 -4.15,1.25 -7.1,0.71z"></path>
                            <polygon id="5" class="fil0 tyre-17" points="299.23,41.91 295.66,40.87 297.92,35.97 307.75,38.87 298.34,59.29 292.47,56.58 "></polygon>
                            <polygon id="6" class="fil0 tyre-17" points="317.31,49.99 309.85,45.25 312.5,41.08 326.09,49.69 324.11,52.82 307.65,64.21 301.96,60.6 "></polygon>
                        </g>
                    </svg>
                </div>
                <div id="shop_by_size_model" class="modal-body">
                    <div class="form-sec">
                        <form action="{{route('front.product.index')}}" method="get" enctype="multipart/form-data">
                            <div class="form-row d-flex align-items-end flex-wrap">
                                <div class="form-group select-field">
                                    <label for="width">Width</label>
                                    <select class="form-control" name="width" id="width">
                                        <option selected="true" disabled="disabled" value="">Select Width</option>
                                        <option selected="true" disabled="disabled" value="">E.G. 195</option>
                                        @forelse($width->subAttributes as $subAttribute)
                                        <option value="{{$subAttribute->id}}">{{$subAttribute->translation->name}}</option>
                                        @empty
                                        <option disabled>No Width Available</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group select-field">
                                    <label for="height">Height</label>
                                    <select class="form-control" name="height" id="height" disabled>
                                        <option selected="true" disabled="disabled" value="">Select Height</option>
                                    </select>
                                </div>
                                <div class="form-group select-field rim-field" >
                                    <label for="rim">Rim</label>
                                    <select class="form-control" name="rim" id="rim" disabled>
                                        <option selected="true" disabled="disabled" value="">Select Rim</option>
                                        >
                                    </select>
                                </div>
                                <input hidden name="search" value="1">
                                <input hidden name="search_model" value="1">
                                <input hidden value="1" name="shop_by_size">
                                <div class="submit-btn">
                                    <button type="submit" class="btn btn--primary btn--animate">Search</button>
                                </div>
                            </div>
                            <div class="accordions">
                                <div class="acc-title">
                                    <a href="#demo" class="primary-title collapse-btn" id="plus-button" data-toggle="collapse">
                                        <i id="minus-class" class="fas fa-plus-circle"></i>
                                        <i id="minus-class-none" class="fas fa-plus-circle d-none"></i>
                                        Need Different Rear Tyres?</a>
                                </div>
                                <div id="demo" class="collapse">
                                    <div class="form-row d-flex align-items-end flex-wrap">
                                        <div class="form-group select-field">
                                            <label for="Date">Width</label>
                                            <select class="form-control" name="width_back" id="width-back">
                                                <option selected="true" disabled="disabled" value="">Select Width
                                                </option>
                                                @forelse($width->subAttributes as $subAttribute)
                                                <option value="{{$subAttribute->id}}">{{$subAttribute->translation->name}}</option>
                                                @empty
                                                <option disabled>No Width Available</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group select-field">
                                            <label for="Time">Height</label>
                                            <select class="form-control" name="height_back" id="height-back" disabled>
                                                <option selected="true" disabled="disabled" value="">Select Height
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group select-field rim-field">
                                            <label for="Location">Rim</label>
                                            <select class="form-control" name="rim_back" id="rim-back" disabled>
                                                <option selected="true" disabled="disabled" value="">Select Rim</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="shop_by_vehicle_model" class="modal-body">
                    <div class="form-sec">
                        <form action="{{route('front.product.index')}}" method="get" enctype="multipart/form-data">
                            <div class="form-row d-flex justify-content-center align-items-end flex-wrap">

                                <div class="form-group select-field">
                                    <label for="Date">Vehicle</label>
                                    <select class="form-control" name="vehicle" id="vehicles-search" required>
                                        <option selected="true" disabled="disabled" value="">Select Vehicle</option>
                                        @forelse($categories as $category)
                                        <option value="{{$category->id}}">{{$category->translation->name}}</option>
                                        @empty
                                        <option disabled>No Vehicle Available</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group select-field">
                                    <label for="Time">Model</label>
                                    <select class="form-control" name="model" id="models-search" required disabled>
                                        <option selected="true" disabled="disabled" value="">Select Model</option>
                                    </select>
                                </div>
                                <div class="form-group select-field">
                                    <label for="Location">Year</label>
                                    <select class="form-control" name="year" id="years-search" required disabled>
                                        <option selected="true" disabled="disabled" value="">Select Year</option>
                                    </select>
                                </div>
                                <input hidden name="search" value="1">
                                <input hidden name="search_model" value="1">
                                <input hidden value="1" name="shop_by_vehicle">
                                <div class="submit-btn">
                                    <button type="submit" class="btn btn--primary btn--animate">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Site header/Navigation Bar End -->
</section>
<!--/ header -->



@push('script-page-level')
<script>
    $(document).ready(function() {

        $('#trigger').click(function(event) {
            $(this).addClass('active-nav')
            event.stopPropagation();

            $('#drop').toggle();

        });
        $(document).click(function() {
            $('#trigger').removeClass('active-nav')
            $('#drop').hide();

        });

        $("#shop_by_vehicle_model").hide()
        // hamburger icon           
        $(".navbar-toggler-btn .hamburger").click(function() {
            $(".hamburger").toggleClass("is-active");
            $(".collapseable-nav").toggleClass("menu-overlay");
            $(".collapseable-nav").slideToggle();
            $("html").toggleClass("hide-overflow")
            // $("html").toggleClass("overflow-overlay");
        });
        // Sort filter

        $(".filter-option-sm .filter-btn").click(function() {
            $(".filter-option").toggleClass("show-filter");
        });
        $(".close-filter").click(function() {
            $(".filter-option").removeClass("show-filter");
        });

    });

    $("#plus-button").on('click', function (){
        if ($("#minus-class").hasClass('fa-minus-circle')){
            $("#minus-class").removeClass('fa-minus-circle');
            $("#minus-class").addClass('fa-plus-circle');
        }else {
            $("#minus-class").removeClass('fa-plus-circle');
            $("#minus-class").addClass('fa-minus-circle');
        }

        if ($("#minus-class-none").hasClass('fa-minus-circle')){
            $("#minus-class-none").removeClass('fa-minus-circle');
            $("#minus-class-none").addClass('fa-plus-circle');
        }else{
            $("#minus-class-none").removeClass('fa-plus-circle');
            $("#minus-class-none").addClass('fa-minus-circle');
        }
    })

    $("#vehicles-search").on("change", function() {
        var vehicle_id = $(this).val();
        $('#models-search')
            .find('option')
            .remove()
            .end()
            .append('<option selected="true" disabled="disabled" value="">Select Model</option>')
        // .val()
        ;
        $.ajax({
            url: window.Laravel.apiUrl + "models/" + vehicle_id,
            success: function(data) {
                // console.log(window.Laravel.apiUrl+"models/"+vehicle_id)
                if (data.length > 0) {
                    $.each(data, function(key, value) {
                        var option = new Option(value.translation.name, value.id);
                        $(option).html(value.translation.name);
                        $("#models-search").append(option).prop('disabled', false);
                        // $('#models').
                        // console.log('key', key, 'value', value.id)
                    })
                } else {
                    var option = new Option("No model is available", 0);
                    $(option).html("No model is available");
                    $("#models-search").append(option).prop('disabled', false);
                }

            }
        });
    });

    $("#models-search").on("change", function() {
        $('#years-search')
            .find('option')
            .remove()
            .end()
            .append('<option selected="true" disabled="disabled" value="" >Select Year</option>')
        // .val()
        ;
        var model_id = $(this).val();
        $.ajax({
            url: window.Laravel.apiUrl + "years/" + model_id,
            success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(key, value) {
                        var option = new Option(value, value);
                        $(option).html(value);
                        $("#years-search").append(option).prop('disabled', false);
                    })
                } else {
                    var option = new Option("No year is available", 0);
                    $(option).html("No year is available");
                    $("#years-search").append(option).prop('disabled', false);
                }

            }
        });
    });

    $('input:checkbox[name="shop_by_vehicle"]').change(function() {
        if ($(this).is(':checked')) {
            $("#shop_by_size_model").hide()
            $("#shop_by_vehicle_model").show()
            $('input:checkbox[name="shop_by_size"]').prop("checked", false)
        }
    });

    $('input:checkbox[name="shop_by_size"]').change(function() {
        if ($(this).is(':checked')) {
            $("#shop_by_vehicle_model").hide()
            $("#shop_by_size_model").show()
            $('input:checkbox[name="shop_by_vehicle"]').prop("checked", false)
        }
    });

    $("#width").on("change", function() {
        $('#height')
            .find('option')
            .remove()
            .end()
            .append('<option selected="true" disabled="disabled" value="">E.G. 65</option>')
        // .val()
        ;
        var width_id = $(this).val();
        addClassToTyre();
        $.ajax({
            url: window.Laravel.apiUrl + "height/" + width_id,
            success: function(data) {
                // console.log('this is width change =>',data)
                // console.log('this is width change length =>',data.length)
                if (data.length > 0) {
                    $.each(data, function(key, value) {
                        // console.log('this is key and value', key, value);
                        var option = new Option(value.translation.name, value.id);
                        $(option).html(value.translation.name);
                        $("#height").append(option).prop('disabled', false);
                        // $('#models').
                        // console.log('key', key, 'value', value.id)
                    })
                } else {
                    var option = new Option("No Height Size is Available", 0);
                    $(option).html("No Height Size is Available");
                    $("#height").append(option).prop('disabled', false);
                }

            }
        });
    });

    $("#height").on("change", function() {
        $('#rim')
            .find('option')
            .remove()
            .end()
            .append('<option selected="true" disabled="disabled" value="">E.G. 15</option>')
        // .val()
        ;
        var height_id = $(this).val();
        addClassToTyre();
        $.ajax({
            url: window.Laravel.apiUrl + "rim/" + height_id,
            success: function(data) {
                console.log(data)
                if (data.length > 0) {
                    $.each(data, function(key, value) {
                        var option = new Option(value.translation.name, value.id);
                        $(option).html(value.translation.name);
                        $("#rim").append(option).prop('disabled', false);
                    })
                } else {
                    var option = new Option("No RIM Size is available", 0);
                    $(option).html("No RIM Size is available");
                    $("#rim").append(option).prop('disabled', false);
                }

            }
        });
    });

    $("#rim").on('change', function() {
        addClassToTyre();
    })


    $("#width-back").on("change", function() {
        var width_id = $(this).val();
        $('#height-back')
            .find('option')
            .remove()
            .end()
            .append('<option selected="true" disabled="disabled" value="">E.G. 65</option>')
        // .val()
        ;
        $.ajax({
            url: window.Laravel.apiUrl + "height/" + width_id,
            success: function(data) {
                console.log(data)
                if (data.length > 0) {
                    $.each(data, function(key, value) {
                        var option = new Option(value.translation.name, value.id);
                        $(option).html(value.translation.name);
                        $("#height-back").append(option).prop('disabled', false);
                        // $('#models').
                        // console.log('key', key, 'value', value.id)
                    })
                } else {
                    var option = new Option("No Height Size is Available", 0);
                    $(option).html("No Height Size is Available");
                    $("#height-back").append(option).prop('disabled', false);
                }

            }
        });
    });

    $("#height-back").on("change", function() {
        $('#rim-back')
            .find('option')
            .remove()
            .end()
            .append('<option selected="true" disabled="disabled" value="">E.G. 15</option>')
        // .val()
        ;
        var height_id = $(this).val();
        $.ajax({
            url: window.Laravel.apiUrl + "rim/" + height_id,
            success: function(data) {
                console.log(data)
                if (data.length > 0) {
                    $.each(data, function(key, value) {
                        var option = new Option(value.translation.name, value.id);
                        $(option).html(value.translation.name);
                        $("#rim-back").append(option).prop('disabled', false);
                    })
                } else {
                    var option = new Option("No RIM Size is available", 0);
                    $(option).html("No RIM Size is available");
                    $("#rim-back").append(option).prop('disabled', false);
                }
            }
        });
    });

    function addClassToTyre() {
        if ($("#width").val() != undefined && $("#width").val() != null) {
            $('.tyre-205').addClass('text-red')
        } else {
            $('.tyre-205').removeClass('text-red')
        }

        if ($("#height").val() != undefined && $("#height").val() != null) {
            $('.tyre-55').addClass('text-red')
        } else {
            $('.tyre-55').removeClass('text-red')

        }

        if ($("#rim").val() != undefined && $("#rim").val() != null) {
            $('.tyre-17').addClass('text-red')
        } else {
            $('.tyre-17').removeClass('text-red')
        }

    }

    $('#width').hover(
        function() {
            if ($("#width").val() == undefined) {
                $('.tyre-205').toggleClass('text-red')
            }
        }
    );
    $('#height').hover(
        function() {
            if ($("#height").val() == undefined) {
                $('.tyre-55').toggleClass('text-red')
            }
        }
    );
    $('#rim').hover(
        function() {
            if ($("#rim").val() == undefined) {
                $('.tyre-17').toggleClass('text-red')
            }
        }
    );
</script>
@endpush