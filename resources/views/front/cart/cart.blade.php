@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <section class="cart spacing">
        <div class="container">
            {{--Cart item--}}
            <form id="cartForm" action="{!! route('front.cart.update') !!}" method="post">
                @csrf
                @forelse($products as $product)
                    <div class="row cart-row mb-5 position-relative">
                        <button type="button" class="close position-absolute deleteCart"
                                data-id="{!! $product->cart_id !!}">×
                        </button>
                        <div class="col-12 col-md-2 cart-img-col">
                            <div class="img-block">
{{--                                <img src="{{imageUrl(url($product->image),104,130,100,1)}}"--}}
                                <img src="{{$product->image}}" style="height: 104px;"
                                     alt="{!! $product->translation->title !!}" class="img-fluid tyre-img">
                            </div>
                        </div>
                        <div class="col-12 col-md-10 cart-right-col">
                            <div class="name-price-bock d-flex justify-content-between">
                                <div class="name-block">
                                    <p class="name">
                                        {!! $product->translation->title !!}
                                    </p>
                                    <p class="desc">
                                        @if(isset($product->attributes))
                                            @forelse($product->attributes as $attribute)
                                                @if($attribute->name == 'Width'){{$attribute->value}}@endif
                                            @empty
                                            @endforelse
                                            /
                                            @forelse($product->attributes as $attribute)
                                                @if($attribute->name == 'Height'){{$attribute->value}}@endif
                                            @empty
                                            @endforelse

                                            @forelse($product->attributes as $attribute)
                                                @if($attribute->name == 'RIM'){{$attribute->value}}@endif
                                            @empty
                                            @endforelse

                                            @forelse($product->attributes as $attribute)
                                                @if($attribute->name == 'Load/Speed Index'){{$attribute->value}}@endif
                                            @empty
                                            @endforelse
                                        @endif
                                    </p>
                                    <p class="desc">
                                        {{$product->year}}
                                    </p>
                                </div>


                                <div class="right-inner-block name-block d-flex flex-column justify-content-between">
                                    <div class="price-quantity">
                                        <div class="price-block">
                                            <h3 class="price">{{$currency.' '.getConvertedPrice(1,$product->total_price)}}</h3>
                                        </div>
                                    </div>
                                    <div class="price-sm">
                                        <div class="quantity-block">
                                            <span class="quantity">Quantity:</span>
                                            <div class="select-container d-inline-block">
                                                <select class="quantity-product"
                                                        name="quantity[{!! $product->cart_id !!}]">
                                                    @for ($i = 1; $i <= $product->productQuantity+$product->quantity; $i++)
                                                        <option value="{{$i}}"
                                                                @if($i==$product->quantity) selected @endif>{{$i}}</option>
                                                    @endfor
                                                    @if($product->quantity > $product->productQuantity)
                                                        <option value="{{$product->quantity}}"
                                                                selected>{{$product->quantity}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <h4 class="price">
                                            <span class="price-title">Price:</span> {{$currency.' '.getConvertedPrice(1,$product->product_price)}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-danger"> {!! __('cart is empty!') !!}</div>
                @endforelse
                @if(!empty($product))

                    <div class="check-boxes-row d-flex flex-wrap justify-content-between">
                        <div class="desc">
                            <p class="primary-text">
                                @if($with_fitting == 1)
                                    {{__('With Tyre Installation - Deliver Installer Partner')}}
                                @else
                                    {{__('Without Tyre Installation - Deliver To Address')}}
                                @endif
                            </p>
                        </div>
                        <div class="radio-col d-flex align-items-center flex-wrap">
                            <label class="radio-container">{{__('With Fitting')}}
                                <input type="radio" @if($with_fitting==1)checked @endif value="1" id="fitting"
                                       name="with_fitting">
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-container">{{__('No Fitting')}}
                                <input type="radio" value="0" @if($with_fitting==0)checked @endif id="no_fitting"
                                       name="with_fitting">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                @endif

                {{-- / cart item--}}

                {{--Price details of the whole cart--}}
                @php
                    $new_total = $total_with_vat/100*config('settings.value_added_tax');
                    $subTotal1 = $subTotal+$new_total;

                @endphp
                {{--Select location--}}
                <div class="price-details-block d-flex
            @if(!empty($product))
                @if(isset($with_fitting))
                @if($with_fitting == 1)
                        justify-content-between
                        @else
                        justify-content-end
                        @endif
                @else
                        justify-content-end
                    @endif
                @else
                        justify-content-end
@endif ">
                    @if(!empty($product))
                        @if($with_fitting == 1)
                            <div class="select-location-main">

                                <div class="location-topbar d-flex">
                                    <div class="left-col d-flex">
                                        <i class="fas fa-car"></i>
                                        <h4 class="title">{{__('Select Services Location')}}</h4>
                                    </div>
                                    <div class="right-col">
                                        <a href="#exampleModal-1" class="search-text" data-toggle="modal"
                                           data-target="#exampleModal-1">
                                            {{__('Change')}} <i class="fas fa-search"></i>
                                        </a>
                                    </div>
                                </div>
                                {{--Display single location--}}
                                @if(!empty($selectedBranch))
                                    <div class="location-content">
                                        <div class="title-desc">
                                            <h4 class="title">
                                                {{$selectedBranch->name}}
                                            </h4>
                                            <p class="desc">
                                                {{$selectedBranch->address}}
                                            </p>
                                        </div>
                                        <a href="#" class=" map-icon" data-toggle="modal" data-target="#exampleModal">
                                            <p class="text map-link mb-0">{{__('See on Map')}}</p>
                                            <div class="map-img-block">
                                                <img src="{{asset('assets\front-tyre-shop\images\google-maps.png')}}"
                                                     onclick="initAutocomplete({{$selectedBranch->latitude}}, {{$selectedBranch->longitude}}, '{{$selectedBranch->address}}')"
                                                     alt="map-img" class="map-img img-fluid">
                                            </div>
                                        </a>
                                        <div class="date-block">
                                            <div class="date-field">
                                                @php
                                                    $date=date_create($selectedBranch->date);
                                                    $formatDate = date_format($date,"l, F d, Y");
                                                @endphp

                                                {{$formatDate}} {{strtoupper($selectedBranch->time)}}
                                            </div>
                                        </div>
                                        <a href="{{route('front.cart.remove.location')}}" class="cross-btn">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                            @endif


                            <!-- Map Modal -->
                                <div class="modal fade map-model" id="exampleModal" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content position-relative">
                                            <div id="map"
                                                 style="width:100%; height:510px; border: 1px solid rgb(220, 220, 220);">

                                            </div>
                                            {{--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d435518.68178730266!2d74.05418089829882!3d31.483220874215338!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39190483e58107d9%3A0xc23abe6ccc7e2462!2sLahore%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2s!4v1607346769297!5m2!1sen!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>--}}
                                            <button type="button" class="cross-btn" data-dismiss="modal"><i
                                                        class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                    @endif


                    {{--Cart calculations--}}
                    <div class="box">
                        <h4 class="title">{{__('Price Details')}}</h4>
                        <div class="items-details-block ">
                            <p class="title-price d-flex justify-content-between">
                                <span class="light">Item's Total:</span> <span
                                        id="product_total">@if($products){{$currency.' '.getConvertedPrice(1,$subTotal)}} @else {{$currency.' '.getConvertedPrice(1,$subTotal)}} @endif </span>
                            </p>
                            <p class="title-price d-flex justify-content-between">
                                <span class="light"> Mobile installation Fee:</span> @if($products){{$currency.' '.getConvertedPrice(1,$mif)}} @else {{$currency.' '.getConvertedPrice(1,0)}} @endif
                            </p>
                            <p class="title-price d-flex justify-content-between">
                                <span class="light">Total (Excl. VAT):</span>
                                <span>{{$currency.' '.getConvertedPrice(1,$subTotal+$mif)}}</span>
                            </p>
                            <p id="tax" class="title-price d-flex justify-content-between">
                                <span class="light">Tax:</span> <span
                                        id="vat">{{$currency.' '.getConvertedPrice(1,$new_total)}}</span>
                            </p>

                            <div id="coupon-input">
                                <h4 class="title-price">
                                    {{__('Discount Codes')}}
                                </h4>
                                @if(!empty($product))
                                    <div class="coupen-discount position-relative">
                                        <input id="coupon_value" placeholder="Enter your coupon code"
                                               class="btn btn-block btn--white">
                                        <button type="button"
                                                class="btn btn--primary btn--animate position-absolute apply_coupon">{{__('Apply')}}</button>
                                    </div>
                                @endif
                            </div>

                            <div class="btn btn-block btn--white btn--gray d-flex justify-content-between">{{__('Grand Total Incl. Tax:')}}
                                <span id="grand_total"
                                      class="btn-price tex-right">{{$currency.' '.getConvertedPrice(1,$subTotal1)}}</span>
                            </div>
                            @if(!empty($product))
                                <a href="{!! route('front.checkout.index')!!}" id="checkout"
                                   class="btn btn-block btn--primary btn--animate">{{__('Checkout')}}</a>
                            @endif
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <!-- Select Services Modal -->
    <div class="modal fade map-model services-model" id="exampleModal-1" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content position-relative">

                @forelse($branches as $branch)
                    <form action="{!! route('front.cart.select.location') !!}" method="post">
                        @csrf
                        <div class="location-content location-content-inner-lg border">
                            <div class="title-desc">
                                <h4 class="title">
                                    {{$branch->translation->title}}
                                </h4>
                                <p class="desc">
                                    {{$branch->address}}
                                </p>
                            </div>
                            <div class="timing-sec">
                                {!! $branch->timings !!}
                            </div>
                            <a href="#" class=" map-icon" data-toggle="modal" data-target="#exampleModal">
                                <p class="text map-link mb-0">{{__('See on Map')}}</p>
                                <div class="map-img-block">
                                    <img src="{{asset('assets\front-tyre-shop\images\google-maps.png')}}"
                                         onclick="initAutocomplete({{$branch->latitude}}, {{$branch->longitude}}, '{{$branch->address}}')"
                                         alt="map-img" class="map-img img-fluid">
                                </div>
                            </a>
                            <div class="input-fields-block">
                                <h5 class="title">
                                    {{__('Select your tyre installation appointment date/time.')}}
                                </h5>
                                <div class="row btn-row">
                                    <div class="form-group col-6 col-md-4">
                                        <select class="form-control select-field" name="booking_date" required>
                                            <option selected="true" disabled="disabled">Select Date</option>
                                            @forelse($dates as $date)
                                                <option value="{{$date}}">{{$date}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group col-6 col-md-4">
                                        <select class="form-control select-field" name="booking_time" required>
                                            <option selected="true" disabled="disabled">Time</option>
                                            <option value="Am">AM</option>
                                            <option value="Pm">PM</option>
                                        </select>
                                    </div>
                                    <input hidden name="location" value="{{$branch->slug}}">
                                    <div class="form-group col-12 col-md-4">
                                        <button type="submit" class="btn btn--primary">
                                            {{__('Select')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                @empty
                @endforelse
                <button type="button" class="cross-btn" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
        </div>
    </div>

@endsection

@push('script-page-level')
    <script>

        @if($errors->has('booking_date'))
        toastr.error('Alert', 'Date is not selected for location.')
        @endif

        @if($errors->has('booking_time'))
        toastr.error('Alert', 'Time is not selected for location.')
        @endif

        $(document).ready(function () {
            $(document).on('click', '.apply_coupon', function () {
                var code = $("#coupon_value").val();
                if (code == '') {
                    toastr.error("{!! __("Enter Coupon First") !!}")
                } else
                    $.ajax({
                        url: window.Laravel.baseUrl + "valid-coupon/" + code,
                        success: function (data) {
                            console.log(data)
                            if (data == 'expired') {
                                toastr.error("{!! __("Coupon Expired") !!}");
                            } else {
                                if (data == 'false') {
                                    toastr.error("{!! __("Invalid Coupon") !!}");
                                } else {
                                    let new_total = "{!! getConvertedPrice(1,$subTotal) !!}";
                                    let discount = new_total / 100 * data;
                                    new_total = new_total - discount;
                                    let vat = "{!! config('settings.value_added_tax') !!}";
                                    let mif = "{!! config('settings.mobile_installation_fee') !!}";
                                    let after_vat = new_total / 100 * vat;
                                    // let grand_total = new_total+after_vat;

                                    let grand_total = new_total + {!!isset($new_total) ? $new_total : 0!!};
                                    grand_total = "{!! $currency !!}" + " " + grand_total.toFixed(2);
                                    after_vat = "{!! $currency !!}" + " " + after_vat.toFixed(2);
                                    new_total = "{!! $currency !!}" + " " + new_total.toFixed(2);
                                    discount = "{!! $currency !!}" + " " + discount.toFixed(2);
                                    console.log('discount:', discount, 'grand_total:', grand_total, 'new total:', new_total, 'vat:', vat, {!!isset($new_total) ? $new_total : 0!!});
                                    $("#grand_total").text(grand_total);
                                    // $("#product_total").text(new_total);
                                    $("#vat").text(after_vat);
                                    {{--$("#vat").text({!!isset($new_total) ? $new_total : 0!!});--}}
                                    {{--let action = "{!! route('front.checkout.index') !!}" + "?code=" + code;--}}
                                    {{--$("#checkout").attr('href', action);--}}
                                    $("#coupon-input").hide();
                                    {{--$(".discount-text").text(data + "% {!! __("Discount is applied ") !!}");--}}
                                    $("#tax").after(`<p id="discount-price" class="title-price d-flex justify-content-between"><span class="light">Discount:</span>` + discount + `</p>`);
                                    // $(".message-heighlight").show();
                                    toastr.success("{!! __("Coupon Applied ") !!}")

                                }
                            }


                        }
                    })
            });

            $(".quantity-product").on("change", function () {
                $("#cartForm").submit();
            });

            $('input:radio[name="with_fitting"]').change(
                function () {
                    if ($(this).is(':checked') && $(this).val() == '0') {
                        $("#fitting_text").empty().append(`<p class="primary-text">
                            {{__('Without Tyre Installation - Deliver To Address')}}
                        </p>`);

                    } else {
                        $("#fitting_text").empty().append(`<p class="primary-text">
                            {{__('With Tyre Installation - Deliver Installer Partner')}}
                        </p>`);

                    }
                    $("#cartForm").submit();

                });

            $(".deleteCart").on('click', function () {
                console.log('it is working')
                let id = $(this).attr('data-id');
                $.ajax({
                    url: window.Laravel.baseUrl + "delete-cart/" + id,
                    success: function (data) {
                        toastr.success("{!! __("Product removed from cart ") !!}")
                        location.reload();
                    }
                })
            })


        })

        function initAutocomplete(lat = {{ config('settings.latitude') }}, lng = {{ config('settings.longitude') }}, address = '{{ config('settings.address') }}') {


            var map = new google.maps.Map(document.getElementById('map'), {

                center: {

                    lat: lat,

                    lng: lng

                },

                zoom: 13,

                mapTypeId: 'roadmap',
                styles: [
                    {
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#ffffff"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#616161"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#f5f5f5"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#eeeeee"
                            },
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.land_parcel",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#bdbdbd"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#eeeeee"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#757575"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#e5e5e5"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#9e9e9e"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#eeeeee"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#757575"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#e2e2e2"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#616161"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#9e9e9e"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit.station",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#eeeeee"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#c9c9c9"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#9e9e9e"
                            }
                        ]
                    }
                ]

            });


            var marker = new google.maps.Marker({

                position: {

                    lat: lat,

                    lng: lng

                },

                {{--                icon:`{{url("assets/front/images/contact-map.png")}}`,--}}

                map: map,

                draggable: false

            });

            var str = address;
            var infowindow = new google.maps.InfoWindow({
                content: str,
            });

            infowindow.open(map, marker);

        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3l&libraries=places&callback=initAutocomplete"></script>

@endpush