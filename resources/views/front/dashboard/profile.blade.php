@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
<!-- Profile html start -->
<section class="custom-sec-inner-account">
    <div class="dashborad-ses">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-navbar')

                <div class="col-md-12 col-lg-9">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="my-account-tittle">{{__('Account Information')}}</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="main-my-account-pagee">
                                <h3 class="info-tittle">{{__('Contact Information')}}</h3>
                                <div class="inner-my-account">
                                    <p class="p-innr-acc">{!! $user['full_name']!!}</p>
                                    <p class="p-innr-acc">{!! $user['email'] !!}</p>
                                </div>
                                <div class="my-ccount-edit">
                                    <a href="{{route('front.dashboard.edit-profile')}}" class="edit-btn-my" > {{('Edit')}}</a>
                                    <a href="{{route('front.dashboard.edit-profile')}}" class="edit-btn-my-2" > {{('Change Password')}}</a>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="main-my-account-pagee">
                                <h3 class="info-tittle">{{__('Newsletters')}}</h3>
                                <div class="inner-my-account">
                                    @if($subscribed == 1)
                                        <p class="p-innr-acc">{{__('You Subscribe to "General Subscription"')}}</p>
                                    @else
                                        <p class="p-innr-acc">{{__('You Are Not Subscribed to Our News Letter')}}</p>
                                    @endif
                                </div>
                                <div class="my-ccount-edit">
                                    <a href="{!! route('front.dashboard.subscription') !!}" class="edit-btn-my" > {{('Edit')}}</a>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center justify-content-between title-subtitle-row">
                                <h2 class="my-account-tittle mt-5">{{__('Address Book')}}</h2>
                                <h2 class="sub-tittle-info-manage"><a class="manage-link" href="{{route('front.dashboard.address.index')}}">{{__('Manage Addresses')}}</a></h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="main-my-account-pagee">
                                <h3 class="info-tittle">{{__('Default Billing Address')}}</h3>
                                <div class="inner-my-account">
                                    @if(isset($billingAddress))
                                        <p class="p-innr-acc">
                                            {{$billingAddress->first_name}}
                                        </p>
                                        <p class="p-innr-acc">
                                            {{$billingAddress->last_name}}
                                        </p>
                                        <p class="p-innr-acc">
                                            {{$billingAddress->address}}

                                        </p>
                                        <p class="p-innr-acc">
                                            {{$billingAddress->street_address}}
                                        </p>
                                        <p class="p-innr-acc">
                                            {{$billingAddress->post_code}}
                                        </p>
                                        <p class="p-innr-acc">
                                            T: {{$billingAddress->user_phone}}
                                        </p>
                                    @else
                                        <p class="p-innr-acc">You have not set a default billing address.</p>
                                    @endif
                                </div>
                                <div class="my-ccount-edit">
                                    @if(isset($billingAddress))
                                        <a href="{{route('front.dashboard.address.edit', $billingAddress->id)}}" class="edit-btn-my">Change Default Billing Address</a>
                                    @else
                                        <button type="button" class="edit-btn-my">Edit Address</button>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="main-my-account-pagee">
                                <h3 class="info-tittle">{{__('Default Shipping Address')}}</h3>
                                <div class="inner-my-account">
                                    @if(isset($shippingAddress))
                                        <p class="p-innr-acc">
                                            {{$shippingAddress->first_name}}
                                        </p>
                                        <p class="p-innr-acc">
                                            {{$shippingAddress->last_name}}
                                        </p>
                                        <p class="p-innr-acc">
                                            {{$shippingAddress->address}}

                                        </p>
                                        <p class="p-innr-acc">
                                            {{$shippingAddress->street_address}}
                                        </p>
                                        <p class="p-innr-acc">
                                            {{$shippingAddress->post_code}}
                                        </p>
                                        <p class="p-innr-acc">
                                            T: {{$shippingAddress->user_phone}}
                                        </p>
                                    @else
                                        <p class="p-innr-acc">You have not set a default billing address.</p>
                                    @endif
                                </div>
                                    <div class="my-ccount-edit">
                                        @if(isset($shippingAddress))
                                        <a href="{{route('front.dashboard.address.edit', $shippingAddress->id)}}" class="edit-btn-my">Change Default Shipping Address</a>
                                        @else
                                            <button type="button" class="edit-btn-my">{{__('No Address Selected As Default Shipping Address')}}</button>
                                        @endif
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!--/ Profile html -->
@endsection
