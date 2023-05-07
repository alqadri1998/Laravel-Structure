<div class="col-md-12 col-lg-3">
    <ul class="nav-left-mt-a nav d-none d-lg-block flex-column">
        <li class="nav-item {!! (url()->current() == route('front.dashboard.index')) ?'active':'' !!}">
            <a href="{!! route('front.dashboard.index') !!}" class="nav-link"><i class="fas fa-caret-right"></i>{{__('My Account')}}</a>
        </li>
        <li class="nav-item {!! (url()->current() == route('front.dashboard.order.index',['status'=>'confirmed'])  || str_contains(url()->current(),'order-detail') || str_contains(url()->current(),'orders')  ) ?'active':'' !!}">
            <a href="{!! route('front.dashboard.order.index',['status'=>'confirmed']) !!}" class="nav-link"><i class="fas fa-caret-right"></i>{{__('my order')}}</a>
        </li>
        <li class="nav-item {!! (url()->current() == route('front.dashboard.address.index')) ?'active':'' !!}">
            <a href="{{route('front.dashboard.address.index')}}" class="nav-link"><i class="fas fa-caret-right"></i>{{__('Address Book')}}</a>
        </li>
        <li class="nav-item {!! (url()->current() == route('front.dashboard.edit-profile')) ?'active':'' !!}">
            <a href="{{route('front.dashboard.edit-profile')}}" class="nav-link"><i class="fas fa-caret-right"></i>{{__('Account Information')}}</a>
        </li>
        <li class="nav-item {!! (url()->current() == route('front.dashboard.subscription')) ?'active':'' !!}">
            <a href="{!! route('front.dashboard.subscription') !!}" class="nav-link"><i class="fas fa-caret-right"></i>{{__('Newsletter Subscriptions')}}</a>
        </li>
        <li class="nav-item">
            <a href="{!! route('front.auth.logout') !!}" class="nav-link"><i class="fas fa-caret-right"></i>{{__('logout')}}</a>
        </li>

    </ul>

</div>