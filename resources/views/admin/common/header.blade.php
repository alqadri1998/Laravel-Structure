<header class="m-grid__item    m-header "  data-minimize-offset="200" data-minimize-mobile-offset="200" >
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{route('admin.home.index')}}" class="m-brand__logo-wrapper">
                            <img alt="" src="{!! imageUrl(asset('assets/front-tyre-shop/images/logo-white.png'), 198, 44, 100, 2) !!}" class="img-fluid"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block ">
					 
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Topbar -->
                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark "  >
                    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">

                    </ul>
                </div>
             
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            {{--bell icon for notifications--}}
                         {{--   <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img dashboard-list-pos m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                <a class="nav-link same-icon clickable dash-m-top" href="#" id="notify-dropdown" role="button" data-toggle="dropdown">
                                    <i class="fa fa-bell bell-icon" aria-hidden="true"></i>
                                    <span class="badge num-five bell-icon-badge">
                                <span class="c-clr bell-span"></span>
                                </span>
                                </a>
                                <div class="dropdown-menu text-capitalize set-width dashoard-pos" aria-labelledby="notify-dropdown">
                                    <div class="tooltip-arrow">
                                        <div class="overlap">
                                            <div class="bef">
                                                <div class='notification-item d-flex align-items-center'><a >
                                                        <div class='d-flex align-items-start'>
                                                            <div><img class='img-fluid'  ></div>
                                                            <div class='info w-100'>
                                                                <div class='text'>
                                                                    <p class='title mb-0' i18n>Loading....</p>
                                                                </div></div></div></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>--}}

                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle" style="    width: 100px;">
												<span class="m-topbar__userpic">
													<img src="{!! (strlen($adminData['profile_pic']) > 0) ? imageUrl($adminData['profile_pic'],100,100,100):asset('assets/img/default_profile.jpg') !!}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
												</span>
                                    <span class="m-topbar__username" style="color: black">
													{!! $adminData['full_name'] !!}
												</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center " style="background: url(../../assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">

                                                    <img src="{!! (strlen($adminData['profile_pic']) > 0) ? imageUrl($adminData['profile_pic'],100,100,100):asset('assets/img/default_profile.jpg') !!}" class="m--img-rounded m--marginless" alt=""/>
                                                </div>
                                                <div class="m-card-user__details">
																<span class="m-card-user__name m--font-weight-500" style="color:#1b1c1e">
																	{!! $adminData['full_name'] !!}
																</span>
                                                    <a href="" class="m-card-user__email m--font-weight-300 m-link" style="color:#1b1c1e ">
                                                        Site Owner
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
                                                        <span class="m-nav__section-text">
                                                            Section
                                                        </span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{!! route('admin.home.edit-profile') !!}" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                            <span class="m-nav__link-title">
                                                                <span class="m-nav__link-wrap">
                                                                    <span class="m-nav__link-text">
                                                                        My Profile
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                  
                                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                                    <li class="m-nav__item">
                                                        <a href="{!! route('admin.auth.login.logout') !!}"
                                                           onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                            Logout
                                                            <form id="logout-form" action="{!! route('admin.auth.login.logout') !!}" method="POST" style="display: none;">
                                                                {!! csrf_field() !!}
                                                            </form>
                                                        </a>

                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- @if($userData['role_id']==config('settings.supplier_role'))
                                <div class="shopping-cart"><a href="{{route('admin.cart.index')}}"><i class="fas fa-shopping-cart"></i>@if(Cart::count() > 0) <span class="badge position-absolute rounded-circle" style="    background: red;
                                    top: -7px; position: absolute;left: 10px;color: white;  padding: 2.5px 4px;border-radius: 50%;">  {{Cart::count()}}</span>@endif </a> </div>
                               @endif -->
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>

