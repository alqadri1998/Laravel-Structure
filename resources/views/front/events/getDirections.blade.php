{{--@extends('front.layouts.app')--}}
{{--@section('content')--}}
{{--    @include('front.common.breadcrumb')--}}
{{--    <!-- events-detail -->--}}
{{--    <section class="events-detail">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div   class="col-12">--}}
{{--                    <div id="map" class="map-cls">--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <!-- /events-detail -->--}}
{{--@endsection--}}

{{--@push('script-page-level')--}}
{{--    --}}{{--<script>--}}

{{--        --}}{{--var lat = {!!  $event->latitude  !!};--}}
{{--        --}}{{--var lng = {!! $event->longitude!!};--}}
{{--        --}}{{--// Initialize and add the map--}}
{{--        --}}{{--function initMap() {--}}
{{--            --}}{{--let mapinit = () =>{--}}
{{--                --}}{{--// The location of Uluru--}}
{{--                --}}{{--var uluru = {lat:lat , lng: lng};--}}
{{--                --}}{{--var uluru2 = {lat: window.currentLat, lng: window.currentLng};--}}
{{--                --}}{{--// The map, centered at Uluru--}}
{{--                --}}{{--var map = new google.maps.Map(--}}
{{--                    --}}{{--document.getElementById('map'), {zoom:19, center: uluru});--}}
{{--                --}}{{--// The marker, positioned at Uluru--}}
{{--                --}}{{--var marker = new google.maps.Marker({position: uluru, map: map});--}}
{{--                --}}{{--var marker = new google.maps.Marker({position: uluru2, map: map});--}}
{{--                --}}{{--var lineCoordinates = [--}}
{{--                    --}}{{--{lat: lat, lng: lng},--}}
{{--                    --}}{{--{lat: window.currentLat, lng: window.currentLng},--}}
{{--                --}}{{--];--}}
{{--                --}}{{--var linePath = new google.maps.Polyline({--}}
{{--                    --}}{{--path: lineCoordinates,--}}
{{--                    --}}{{--geodesic: true,--}}
{{--                    --}}{{--strokeColor: '#1459ff'--}}
{{--                --}}{{--});--}}

{{--                --}}{{--linePath.setMap(map);--}}
{{--            --}}{{--}--}}
{{--            --}}{{--if (navigator.geolocation) {--}}
{{--                --}}{{--navigator.geolocation.getCurrentPosition((position) => {--}}
{{--                    --}}{{--window.currentLat = (position.coords.latitude);--}}
{{--                    --}}{{--window.currentLng = (position.coords.longitude);--}}
{{--                    --}}{{--mapinit()--}}
{{--                --}}{{--})--}}
{{--            --}}{{--}--}}
{{--            --}}{{--mapinit()--}}

{{--        --}}{{--}--}}
{{--        --}}{{--$(document).ready(function () {--}}
{{--            --}}{{--setTimeout(function () {--}}
{{--                --}}{{--initMap();--}}
{{--            --}}{{--}, 400);--}}
{{--        --}}{{--});--}}
{{--    --}}{{--</script>--}}
{{--    <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3&libraries=places&callback=initMap"></script>--}}

{{--@endpush--}}
