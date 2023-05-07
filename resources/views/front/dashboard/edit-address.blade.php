@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <!-- pormotions html start -->
    <section class="custom-sec-inner-account">
        <div class="dashborad-ses">
            <div class="container">
                <div class="row">
                    @include('front.dashboard.common.left-navbar')

                    <div class="col-md-12 col-lg-9">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="my-account-tittle">Contact Information</h2>
                            </div>
                        </div>


                        <!-- addess book -->
                        <form action="{{route('front.dashboard.address.update', isset($address)? $address->id: 0)}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="appoint-ment-main-fieldss">
                                        <div class="form-group  m-b-25">
                                            <label class="label-appoint-field">first name</label>
                                            <input type="text" class="form-control required " id="text-1"
                                                   placeholder="first name" value="{{isset($address)? $address->first_name: old('first_name')}}" name="first_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="appoint-ment-main-fieldss">
                                        <div class="form-group  m-b-25">
                                            <label class="label-appoint-field">last name</label>
                                            <input type="text" class="form-control required " id="text-1"
                                                   placeholder="last name" value="{{isset($address)? $address->last_name: old('last_name')}}" name="last_name" required>
                                        </div>
                                    </div>
                                </div>
                                {{--      <div class="col-md-6">
                                          <div class="appoint-ment-main-fieldss">
                                              <div class="form-group  m-b-25">
                                                  <label class="label-appoint-field">company</label>
                                                  <input type="text" class="form-control required " id="com"
                                                      placeholder="company" name="email">
                                              </div>
                                          </div>
                                      </div>--}}
                                <div class="col-md-6">
                                    <div class="appoint-ment-main-fieldss">
                                        <div class="form-group  m-b-25">
                                            <label class="label-appoint-field">phone number</label>
                                            <input type="text" class="form-control required " id="text-1"
                                                   placeholder="phone number" value="{{isset($address)? $address->user_phone: old('user_phone')}}" name="user_phone" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="appoint-ment-main-fieldss">
                                        <div class="form-group  m-b-25">
                                            <label class="label-appoint-field">fax</label>
                                            <input type="text" class="form-control required " id="fax"
                                                   placeholder="fax" value="{{isset($address)? $address->fax: old('fax')}}" name="fax">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <h2 class="my-account-tittle address">Address Details</h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="appoint-ment-main-fieldss">
                                        <div class="form-group  m-b-25">
                                            <label class="label-appoint-field">Address</label>
                                            <input type="text" class="form-control required " id="text-1"
                                                   placeholder="street address" value="{{isset($address)? $address->address: old('address')}}" name="address" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="appoint-ment-main-fieldss">
                                        <div class="form-group  m-b-25">
                                            <label class="label-appoint-field">city</label>
                                            <input type="text" class="form-control required " id="text-1"
                                                   placeholder="city" value="{{isset($address)? $address->city: old('city')}}" name="city">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="appoint-ment-main-fieldss">
                                        <div class="form-group  m-b-25">
                                            <label class="label-appoint-field">Country</label>
                                            <input type="text" class="form-control required " id="text-1"
                                                   placeholder="United Arab Emirates" value="United Arab Emirates"  name="country" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="appoint-ment-main-fieldss">
                                        <div class="form-group  m-b-25">
                                            <label class="label-appoint-field">zip/postal code</label>
                                            <input type="text" class="form-control required " id="text-1"
                                                   placeholder="postal code" value="{{isset($address)? $address->post_code: old('post_code')}}"  name="post_code" required>
                                        </div>
                                    </div>
                                </div>

                                {{--                                    <div class="col-md-6">--}}
                                {{--                                        <div class="appoint-ment-main-fieldss">--}}
                                {{--                                            <div class="form-group  m-b-25">--}}
                                {{--                                                <label class="label-appoint-field">country</label>--}}
                                {{--                                                <input type="text" class="form-control required " id="text-1"--}}
                                {{--                                                    placeholder="country" name="email">--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                <div class="col-md-12">
                                    <div class="form-group  m-b-25">
                                        <label class="checkbox-container pt-1">Default billing address
                                            <input type="checkbox" @if(isset($address)) @if($address->default_billing == 1) checked @endif @endif name="default_billing">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group  m-b-25">
                                        <label class="checkbox-container pt-1">Default shipping address
                                            <input type="checkbox" @if(isset($address)) @if($address->default_shipping == 1) checked @endif @endif name="default_shipping">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="location-btn-book-address">
                                        <button type="submit" class="btn btn--primary btn--animate" >Save</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- end pormotion html -->
@endsection
