@extends('front.layouts.app')
@push('stylesheet-page-level')
    <style>
        #telr {
            width: 100%;
            min-width: 600px;
            height: 600px;
            frameborder: 0;
        }
    </style>
@endpush

@section('content')
    @include('front.common.breadcrumb')
    <!-- checkout -->
    <section class="checkout spacing">
        <div class="container">
            <div class="center-page">
                <div class="box">
                    <div class="form">
                        <h2 class="secondary-headline">{{__('Please Select Payment Option')}}</h2>
                        <form method="post" action="{!! route('front.checkout.pay.pal') !!}">
                            @csrf
                            {{--Payment radio buttons--}}
                            <div class="gender-radio m-b-25 d-flex flex-wrap justify-content-start">
                               {{-- <label class="radio-container">{{__('Continue With PayPal')}}
                                    <input type="radio" value="PayPal" checked="checked" name="payment_method">
                                    <span class="checkmark"></span>
                                </label>--}}
                                <label class="radio-container mr-md-5">{{__('Continue With Telr')}}
                                    <input type="radio" value="telr" name="payment_method">
                                    <span class="checkmark"></span>
                                </label>
                                @if($booking != 1)
                                    <label class="radio-container">{{__('Pay At Branch')}}
                                        <input type="radio" value="pay at branch" checked name="payment_method">
                                        <span class="checkmark"></span>
                                    </label>
                                @else
                                    <label class="radio-container">{{__('Cash On Delivery')}}
                                        <input type="radio" value="cash on delivery" checked name="payment_method">
                                        <span class="checkmark"></span>
                                    </label>
                                @endif

                            </div>
                            {{--/ Payment radio buttons--}}

                            <div class="title m-b-25">
                                <h3 class="primary-title">{{__('Shipping/Billing Address')}}</h3>
                            </div>
                            <div class="row">
                                <div class="form-group m-b-25 col-sm-6">
                                    <label class="required" for="first_name">{{__('First Name')}}</label>
                                    <input type="text" class="form-control required" id="first-name"
                                           placeholder="First Name" value="{{$address->first_name}}" name="first_name" maxlength="32" required>
                                    @include('front.common.alert', ['input' => 'first_name'])
                                </div>
                                <div class="form-group m-b-25 col-sm-6">
                                    <label class="required" for="last_name">{{__('Last Name')}}</label>
                                    <input type="text" class="form-control required" id="last-name"
                                           placeholder="Last Name" value="{{$address->last_name}}" name="last_name" maxlength="32" required>
                                    @include('front.common.alert', ['input' => 'last_name'])

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group m-b-25 col-sm-6">
                                    <label class="required" class="" for="email">{{__('Email')}}</label>
                                    <input type="email" class="form-control required" value="{{$user['email']}}" id="email" placeholder="Email"
                                           name="email" required>
                                    @include('front.common.alert', ['input' => 'email'])

                                </div>
                                <div class="form-group m-b-25 col-sm-6">
                                    <label class="required" for="last-name">{{__('Phone Number')}}</label>
                                    <input type="text" class="form-control" value="{{$address->user_phone}}" id="ph-no" placeholder="Phone Number"
                                           name="user_phone" required>
                                    @include('front.common.alert', ['input' => 'user_phone'])

                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <label for="add">{{__('Address')}}</label>
                                <div class="address-icon">
                                    <input type="text" class="form-control" value="{{$address->address}}" placeholder="Street Address"
                                           name="address">
                                           <button type="button" class="marker-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                           </button>
                                </div>
                                @include('front.common.alert', ['input' => 'address'])

                            </div>
                            <div class="row">
                                <div class="form-group m-b-25 col-sm-6 col-md-6">
                                    <label class="required">How did you find us?</label>
                                    <select class="form-control select-field" name="find_us" required>
                                        <option selected="true" disabled="disabled" >How did you find us</option>
                                        <option value="google">Google</option>
                                        <option value="facebook">Facebook</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="friends">Friends</option>
                                    </select>
                                    @include('front.common.alert', ['input' => 'find_us'])

                                </div>
                                <div class="form-group m-b-25 col-sm-6 col-md-6">
                                    <label for="pwd">City</label>
                                    <input type="text" class="form-control " value="{{$address->city}}" placeholder="City"
                                           name="city">
                                    @include('front.common.alert', ['input' => 'city'])

                                </div>
                                <div class="form-group m-b-25 col-sm-6 col-md-12 ful-col">
                                    <label for="pwd">Country</label>
                                    <select class="form-control select-field" name="country">
                                        <option selected="true" disabled="disabled" >Select Country</option>
                                        <option>United Arab Emirates</option>
                                    </select>
                                    @include('front.common.alert', ['input' => 'country'])

                                </div>
                            </div>
                            <div class="form-group m-b-25">
                                <label for="add">{{__('City')}}</label>
                                <input type="text" class="form-control" value="{{$address->city}}" id="add" placeholder="City"
                                       name="city">
                                @include('front.common.alert', ['input' => 'city'])

                            </div>
                            <div class="form-group m-b-25">
                                <label for="pwd">{{__('Post/Zip Code')}}</label>
                                <input type="text" class="form-control " value="{{$address->post_code}}" id="pwd" placeholder="Postcode / Zip"
                                       name="post_code">
                                @include('front.common.alert', ['input' => 'post_code'])

                            </div>

                            {{--Order Notes--}}
                            <div class="form-group m-b-25">
                                <label for="pwd">{{__('Order Notes')}}</label>
                                <textarea class="form-control" placeholder="Order Notes" name="order_notes" id="msg" cols="14"
                                          rows="5">{{old('order_notes')}}</textarea>
                                @include('front.common.alert', ['input' => 'order_notes'])

                            </div>
                            {{--/ Order Notes--}}

                            {{--Vehicle Details--}}
                            <div class="title m-b-25">
                                <h3 class="primary-title">Vehicle Details</h3>
                            </div>
                            <div class="row">
                                {{--Vin Number--}}
                                <div class="form-group m-b-25 col-sm-6">
                                    <label for="pwd">Vin Number</label>
                                    <input type="text" class="form-control" value="{{old('vin_number')}}" id="text" placeholder="Vin Number"
                                           name="vin_number">
                                    @include('front.common.alert', ['input' => 'vin_number'])

                                </div>
                                {{--Number plate--}}
                                <div class="form-group m-b-25 col-sm-6">
                                    <label for="pwd">Vehicle Plate</label>
                                    <input type="text" class="form-control" value="{{old('number_plate')}}" id="text" placeholder="Vehicle Plate"
                                           name="number_plate">
                                    @include('front.common.alert', ['input' => 'number_plate'])

                                </div>
                                {{--category--}}
                                <div class="form-group m-b-25 col-md-4">
                                    <label for="pwd">Make</label>
                                    <select class="form-control select-field" name="vehicle" id="vehicles">
                                        <option selected="true" disabled="disabled" >Select Vehicle</option>
                                    @forelse($categories as $category)
                                            <option value="{{$category->id}}">{{$category->translation->name}}</option>
                                        @empty
                                        <option disabled>No Vehicle Available</option>
                                            @endforelse
                                    </select>
                                    @include('front.common.alert', ['input' => 'vehicle'])

                                </div>

                                {{--Model--}}
                                <div class="form-group m-b-25 col-md-4">
                                    <label for="pwd">Model</label>
                                    <select class="form-control select-field" name="model" id="models">
                                        <option selected="true" disabled="disabled" >Select Model</option>

                                    </select>
                                    @include('front.common.alert', ['input' => 'model'])

                                </div>

                                {{--Year--}}
                                <div class="form-group m-b-25 col-md-4">
                                    <label for="pwd">Year</label>
                                    <select class="form-control select-field" name="year" id="years">
                                        <option selected="true" disabled="disabled">Select Year</option>
                                    </select>
                                    @include('front.common.alert', ['input' => 'year'])

                                </div>
                            </div>
                            {{--/ Vehicle Details--}}
                            @if($booking != 1)
                            {{--Fitting Location--}}
                            <div class="fitting-location">
                                <div class="title m-b-25">
                                    <h3 class="primary-title">Fitting Location</h3>
                                </div>
                                <p class="motor-city">
                                   {{json_decode($booking)->name}}
                                </p>
                                <p class="date-time">
                                    Fitment Date/Time {{json_decode($booking)->date}}  | {{json_decode($booking)->time}}
                                </p>
                            </div>
                            @endif

                        @if($address->id == 0)
                            <input hidden name="address_id" value="0" >
                            @endif
                            @if($booking != 1)
                                <input hidden name="booking" value="{{$booking}}" >
                            @endif
                            <input type="hidden" name="coupon" value="{!!$coupon!!}">
                            <div class="sm-btn text-right">
                                <button type="submit" class="btn btn--primary btn--animate">{{__('Place Order')}}</button>
{{--                                <a href="#" class="btn btn--primary btn--animate">Place order</a>--}}
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ checkout -->

{{--    <iframe id= "telr" src="{{$iframeUrl}}" sandbox="allow-forms allow-modals allow-popups-to-escape-sandbox allow-popups allow-scripts allow-top-navigation allow-same-origin"></iframe>--}}
@endsection
@push('script-page-level')

<script>
    $(document).ready(function () {



    });


    $("#vehicles").on("change", function () {
        var vehicle_id =$(this).val();
        $('#models')
            .find('option')
            .remove()
            .end()
            .append('<option>Select Model</option>')
            // .val()
        ;
        $.ajax({
            url : window.Laravel.baseUrl+"models/"+vehicle_id,
            success:function (data) {
                if (data.length > 0){
                    $.each(data, function (key,value){
                        var option = new Option(value.translation.name, value.id);
                        $(option).html(value.translation.name);
                        $("#models").append(option);
                        // $('#models').
                        // console.log('key', key, 'value', value.id)
                    })
                }else{
                    var option = new Option("No model is available", 0);
                    $(option).html("No model is available");
                    $("#models").append(option);
                }

            }
        });
    });


    $("#models").on("change", function () {
        $('#years')
            .find('option')
            .remove()
            .end()
            .append('<option>Select Year</option>')
        // .val()
        ;
        var model_id =$(this).val();
        $.ajax({
            url : window.Laravel.baseUrl+"years/"+model_id,
            success:function (data) {
                if (data.length > 0){
                    $.each(data, function (key,value){
                        var option = new Option(value, value);
                        $(option).html(value);
                        $("#years").append(option);
                    })
                }else{
                    var option = new Option("No year is available", 0);
                    $(option).html("No year is available");
                    $("#years").append(option);
                }

            }
        });
    });

</script>
@endpush
