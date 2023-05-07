@extends('front.layouts.app')
@section('content')
@include('front.common.breadcrumb')




<!-- pormotions html start -->
<section class="conatct-us-page-sec">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="main-address-contact d-flex">
                    <div class="help-one-mt">
                        <div class="inner-help-one">
                            <img class="img-fluid img-color" src="{{asset('assets/front-tyre-shop/images/pin-contact.png')}}" alt="">
                            <a target="_blank" href="https://www.google.com/maps/dir//{{__(config('settings.latitude'))}},{{__(config('settings.longitude'))}}/@ {{__(config('settings.latitude'))}},{{__(config('settings.longitude'))}},12z">
                                <p class="card-text1" dir="ltr">  {{__(config('settings.address'))}}</p>

                            </a>
                        </div>

                    </div>
                    <div class="help-one-mt">
                        <div class="inner-help-one">
                            <img class="img-fluid img-color" src="{{asset('assets/front-tyre-shop/images/mail-contact.png')}}" alt="">
                            <a href="mailto:{{__(config('settings.email'))}}" >
                                <p class="card-text1" dir="ltr">{{__(config('settings.email'))}}
                                </p>
                            </a>
                        </div>
                    </div>
                    <div class="help-one-mt">
                        <div class="inner-help-one bodr">
                            <img class="img-fluid img-color" src="{{asset('assets/front-tyre-shop/images/number-contact.png')}}" alt="">
                            <a href="tel:{{__(config('settings.contact_number'))}}">
                                <p class="card-text1" dir="ltr">{{__(config('settings.contact_number'))}}</p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- contact us form -->

        <form id="contact-us-form" action="{!! route('front.contactUs.email') !!}" method="post">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <h2 class="contact-us-page-tittle">{!! __('If you got any questions') !!} <br> {!! __('Please do not hesitate to send us a message.') !!}</h2>
            </div>
            <div class="col-md-12">
                <div class="appoint-ment-main-fieldss">
                    <div class="form-group  m-b-25">
                        <input type="text" value="{!! old('name') !!}" class="form-control required " id="name"
                               placeholder="{!! __('name') !!}" name="name" required>
                        @if($errors->has('name'))
                            <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ $errors->first('name') }}</small>
                                    </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="appoint-ment-main-fieldss">
                    <div class="form-group  m-b-25">
                        <input type="text" value="{!! old('phone') !!}" class="form-control required " id="text-1"
                               placeholder="{!! __('phone') !!}" name="phone" required>
                        @if($errors->has('phone'))
                            <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ $errors->first('phone') }}</small>
                                    </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="appoint-ment-main-fieldss">
                    <div class="form-group  m-b-25">
                        <input type="email" value="{!! old('email') !!}" class="form-control required " id="email"
                               placeholder="{!! __('email') !!}" name="email" required>
                        @if($errors->has('email'))
                            <span class="help-block">
                                <small class="text-danger font-weight-bold gothic-normel">{{ $errors->first('email') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="appoint-ment-main-fieldss">
                    <div class="form-group text-area-cotact-us-page">
                        <textarea value="{!! old('message_text') !!}" class="form-control" placeholder="{!! __('your message') !!}"  id="exampleFormControlTextarea1" name="message_text"  required></textarea>
                        @if($errors->has('message_text'))
                            <span class="help-block">
                                        <small class="text-danger font-weight-bold gothic-normel">{{ $errors->first('message_text') }}</small>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="appoint-btn-m d-flex justify-content-end">
{{--                    <a type="submit" href="javascript:void(0)" class="btn btn--primary btn--animate" onclick="document.getElementById('contact-us-form').submit();">{!! __('submit') !!}</a>--}}
                    <button type="submit" class="btn btn--primary btn--animate" >{!! __('submit') !!}</button>
                </div>
            </div>
        </div>

        </form>
        <!--/ contact us form -->
    </div>
</section>
<section>
    <!-- map -->
    <div class="google-map">
{{--        <div class="contact-map" > </div>--}}
{{--        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d108829.74796745587!2d{{__(config('settings.longitude'))}}!3d{{__(config('settings.latitude'))}}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1    !5e0!3m2!1sen!2s!4v1580126679279!5m2!1sen!2s"  frameborder="0" style="border:0;" allowfullscreen=""></iframe>--}}
        <div id="map" style="width:100%; height:510px; border: 1px solid rgb(220, 220, 220);" >

        </div>
    </div>
    <!-- end map -->
</section>
<!-- end pormotion html -->

@endsection


@push('script-page-level')
    <script>
        function initAutocomplete() {



            var map = new google.maps.Map(document.getElementById('map'), {

                center: {

                    lat: {{ config('settings.latitude') }},

                    lng: {{ config('settings.longitude') }}

                },

                zoom: 13,

                mapTypeId: 'roadmap',
                styles:[
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

                    lat: {{ config('settings.latitude') }},

                    lng: {{ config('settings.longitude') }}

                },

{{--                icon:`{{url("assets/front/images/contact-map.png")}}`,--}}

                map: map,

                draggable: false

            });

            var str = '{{ config('settings.address') }}';
            var infowindow = new google.maps.InfoWindow({
                content: str,
            });

            infowindow.open(map, marker);

        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA&libraries=places&callback=initAutocomplete"></script>

@endpush