<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">

        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item " aria-haspopup="true" >
                <a  href="{!! route('admin.home.index') !!}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Dashboard
                            </span>

                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'users')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.users.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Users</span>
                </a>

            </li>

            <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'products')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{{route('admin.products.index')}}" class="m-menu__link ">
                                        {{--<i class="m-menu__link-icon {!! $module['icon_class'] !!}"></i>--}}
                    <span class="m-menu__link-text">{{$userData['role_id']==config('settings.supplier_role')?'Make Order':'Tyres'}}</span>

                </a>
                <div class="m-menu__submenu">
                    <span class="m-menu__arrow"></span>
                </div>
            </li>

            <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'packages') ||str_contains(url()->current(),'package')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.packages.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Service Packages</span>
                </a>

            </li>

            <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'categories') ||str_contains(url()->current(),'category')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.category.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Vehicles</span>
                </a>

            </li>
            <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'coupons')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.coupons.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Coupons</span>
                </a>

            </li>
{{--            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'events') ||str_contains(url()->current(),'event')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
{{--                <a     href="{{route('admin.event.index')}}" class="m-menu__link ">--}}
{{--                    <span class="m-menu__link-text">Events</span>--}}
{{--                </a>--}}

{{--            </li>--}}
            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'branches') ||str_contains(url()->current(),'branch')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.branches.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Branches</span>
                </a>

            </li>
            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'brands') ||str_contains(url()->current(),'brand')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.brands.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Brands</span>
                </a>

            </li>
            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'promotions') ||str_contains(url()->current(),'promotion')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.promotions.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Promotions</span>
                </a>

            </li>
            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'services') ||str_contains(url()->current(),'service')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.services.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Services</span>
                </a>

            </li>
{{--            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'repairs') ||str_contains(url()->current(),'repair')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
{{--                <a     href="{{route('admin.repairs.index')}}" class="m-menu__link ">--}}
{{--                    <span class="m-menu__link-text">repairs</span>--}}
{{--                </a>--}}

{{--            </li>--}}
            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'origins') ||str_contains(url()->current(),'origin')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.origins.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Tyre Origins</span>
                </a>

            </li>
            <li class="m-menu__item  m-menu__item--submenu  {!! url()->current() ==route('admin.slider.index') ?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.slider.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Sliders</span>
                </a>

            </li>
{{--            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'catalogues')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
{{--                <a     href="{{route('admin.catalogues.index')}}" class="m-menu__link ">--}}
{{--                    <span class="m-menu__link-text">Catalogues</span>--}}
{{--                </a>--}}

{{--            </li>--}}


    {{--        <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'notifications')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.notifications.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Notifications</span>
                </a>

            </li>--}}



{{--            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'partners')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
{{--                <a     href="{{route('admin.partners.index')}}" class="m-menu__link ">--}}
{{--                    <span class="m-menu__link-text">Partners</span>--}}
{{--                </a>--}}

{{--            </li>--}}


        {{--    <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'attributes') ?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.attributes.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Attributes</span>
                </a>

            </li>--}}


            <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'orders') ?'nav-active':'' !!}" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Orders</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">

                        <li class="m-menu__item {!! url()->current() == route('admin.orders.order',['status'=> 'pending']) ?'nav-active':'' !!} {!! (  isset($previous) && $previous == 'confirmed')?'nav-active':'' !!}" >
                            <a  href="{!! route('admin.orders.order',['status'=> 'pending']) !!}" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Pending</span>
                            </a>
                        </li>

                        <li class="m-menu__item {!! url()->current() == route('admin.orders.order',['status'=> 'In progress']) ?'nav-active':'' !!} {!! (  isset($previous) && $previous == 'In Progress')?'nav-active':'' !!}" >
                            <a  href="{!! route('admin.orders.order',['status'=> 'In progress']) !!}" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">In Progress</span>
                            </a>
                        </li>

                        <li class="m-menu__item {!! str_contains(url()->current(),'completed') ?'nav-active':'' !!} {!! (  isset($previous) && $previous == 'completed')?'nav-active':'' !!} " >
                            <a  href="{!! route('admin.orders.order',['status'=> 'completed']) !!}" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Completed</span>
                            </a>
                        </li>
                        <li class="m-menu__item {!! str_contains(url()->current(),'canceled') ?'nav-active':'' !!} {!! (  isset($previous) && $previous == 'canceled')?'nav-active':'' !!}" >
                            <a  href="{!! route('admin.orders.order',['status'=> 'canceled']) !!}" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Cancelled</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
                            {{--<li class="m-menu__item  m-menu__item--submenu {!! url()->current() == route('admin.orders.order',['status'=> 'pending']) ?'nav-active':'' !!} {!! (  isset($previous) && $previous ==route('admin.orders.order',['status'=> 'pending']))?'nav-active':'' !!}" style="padding-left: 35px;" >--}}
                                {{--<a  href="{!! route('admin.orders.order',['status'=> 'pending']) !!}" class="m-menu__link m-menu__toggle">--}}

                                    {{--<span class="m-menu__link-text">Pending Orders</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}

                         {{--<li class="m-menu__item  m-menu__item--submenu {!! url()->current() == route('admin.orders.order',['status'=> 'In progress']) ?'nav-active':'' !!} {!!  isset($previous)&& $previous  ==route('admin.orders.order',['status'=> 'In progress'])?'nav-active':'' !!}" style="padding-left: 35px;" >--}}
                            {{--<a  href="{!! route('admin.orders.order',['status'=> 'In progress']) !!}" class="m-menu__link m-menu__toggle">--}}

                                {{--<span class="m-menu__link-text">In Progress Orders</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}

                        {{--<li class="m-menu__item  m-menu__item--submenu {!! url()->current() == route('admin.orders.order',['status'=> 'completed']) ?'nav-active':'' !!} {!!  isset($previous) && $previous ==route('admin.orders.order',['status'=> 'completed'])?'nav-active':'' !!} " style="padding-left: 35px;" >--}}
                            {{--<a  href="{!! route('admin.orders.order',['status'=> 'completed']) !!}" class="m-menu__link m-menu__toggle">--}}

                                {{--<span class="m-menu__link-text">Completed Orders</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'canceled') ?'nav-active':'' !!} {!!  isset($previous) && $previous == route('admin.orders.order',['status'=> 'canceled'])?'nav-active':'' !!}"  style="padding-left: 35px;">--}}
                            {{--<a  href="{!! route('admin.orders.order',['status'=> 'canceled']) !!}" class="m-menu__link m-menu__toggle">--}}

                                {{--<span class="m-menu__link-text">Cancelled Orders</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}

            <li class="m-menu__item  m-menu__item--submenu  {!! str_contains(url()->current(),'subscriptions') ||str_contains(url()->current(),'subscription')?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.subscriptions.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Subscriptions</span>
                </a>

            </li>

            <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'pages') ?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.pages.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Info Pages</span>
                </a>

            </li>
{{--            <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'translations') ?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
{{--                <a     href="{{route('admin.translations.index')}}" class="m-menu__link ">--}}
{{--                    <span class="m-menu__link-text">Translations</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="m-menu__item  m-menu__item--submenu {!! str_contains(url()->current(),'site-settings') ?'nav-active':'' !!}" style="padding-left: 35px;" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a     href="{{route('admin.site-settings.index')}}" class="m-menu__link ">
                    <span class="m-menu__link-text">Settings</span>
                </a>

            </li>


        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>