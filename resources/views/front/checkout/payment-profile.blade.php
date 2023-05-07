{{--
@extends('front.layouts.app')
@section('content')
@include('front.common.breadcrumb')
<!-- payment-profile -->
<section class="payment-profile">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3">
                <ul class="nav-left-mt-a nav d-lg-block flex-column Poppins-Redular pb-4 mb-5">
                    <li class="nav-item">
                        <a class="nav-link c-link" href="#"><i class="fa fa-user custom-m" aria-hidden="true"></i>
                            profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link c-link" href="#"><i class="fas fa-shopping-bag custom-m"></i>orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link c-link" href="#"><i class="fas fa-heart custom-m"></i>Favourite</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link c-link" href="#"><i class="fas fa-bell custom-m"></i>Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link c-link" href="#"><i class="fas fa-hands-helping custom-m"></i>Payment Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link c-link" href="#"><i class="fas fa-unlock-alt custom-m"></i>Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link c-link" href="#"><i class="fas fa-sign-out-alt custom-m"></i>Logout</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-8 col-lg-9">
                <img src="{{asset('assets/front/images/paypal.jpg')}}" class="logo img-fluid">
                <h1 class="black gothic-bold payment-profile-heading">Save your payment profile</h1>
                <form action="#" method="post">
                    <div class="edit-the-profile">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="client-id" class="black gothic-normel text-capitalize">client id</label>
                                    <input type="text" class="form-control mb-4 f-input-cls msg-box-style" id="#" placeholder="Client Id">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="seceret" class="black gothic-normel text-capitalize">seceret</label>
                                    <input type="text" class="form-control mb-4 custm-build f-input-cls pswd-pad msg-box-style" id="#" placeholder="Seceret">
                                </div>
                            </div>
                            <div class="col-12">
                                <a href="#" class="mt-btn-primary payment-profile-btn">save</a>
                            </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
<!--/ payment-profile -->
@endsection--}}
