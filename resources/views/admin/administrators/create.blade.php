@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    @include('admin.common.upload-gallery-js-links')
    <script>
        function getAsDate(day, time)
        {
            var hours = Number(time.match(/^(\d+)/)[1]);
            var minutes = Number(time.match(/:(\d+)/)[1]);
            var AMPM = time.match(/\s(.*)$/)[1];
            if(AMPM == "pm" && hours<12) hours = hours+12;
            if(AMPM == "am" && hours==12) hours = hours-12;
            var sHours = hours.toString();
            var sMinutes = minutes.toString();
            if(hours<10) sHours = "0" + sHours;
            if(minutes<10) sMinutes = "0" + sMinutes;
            time = sHours + ":" + sMinutes + ":00";
            var d = new Date(day);
            var n = d.toISOString().substring(0,10);
            var newDate = new Date(n+"T"+time);
            return newDate;
        }
        $(document).ready(function(){
            var values = [];
            var timing = [];
            $('.company_form').submit(function(event){
//                        console.log(1);
//                event.preventDefault();
                var inputs = $('.company_form :input');
                inputs.each(function() {
                    values[this.name] = $(this).val();
                });
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                if(dd<10) {
                    dd = '0'+dd
                }
                if(mm<10) {
                    mm = '0'+mm
                }
                today = dd + '/' + mm + '/' + yyyy;
                for(var i=0; i<=6 ; i++){
                    timing.push({
                        'start_time' : new moment(getAsDate(today, values['timing['+i+'][start_time]'])).unix(),
                        'end_time' : new moment(getAsDate(today, values['timing['+i+'][end_time]'])).unix(),
                        'day' : values['timing['+i+'][day]'],
                        'off' : values['timing['+i+'][off]']
                    })
                }
                $('input[name=unix_timing]').val(JSON.stringify(timing));
            });
        });

        var latitude = {!! ($admin->id > 0) ? ((empty($admin->latitude) ? 31.55460609999999 : $admin->latitude)) : 31.55460609999999 !!};
        var longitude = {!! ($admin->id > 0) ? ((empty($admin->longitude) ? 74.35715809999999 : $admin->longitude)) : 74.35715809999999 !!};

        function initAutocomplete(mapId, searchId, long, latit) {

            var map = new google.maps.Map(document.getElementById(mapId), {
                center: {lat: latitude, lng: longitude},
                zoom: 13,
                mapTypeId: 'roadmap'
            });

            var marker = new google.maps.Marker({
                position: {
                    lat: latitude, lng: longitude
                },
                map: map,
                draggable: true
            });

            var searchBox = new google.maps.places.SearchBox(document.getElementById(searchId));

            google.maps.event.addListener(searchBox, 'places_changed', function () {

                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;

                for (i = 0; place = places[i]; i--) {
                    bounds.extend(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                }

                map.fitBounds(bounds);
                map.setZoom(15);

            });

            google.maps.event.addListener(marker, 'position_changed', function () {

                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();

                document.getElementById(latit).value = lat;
                document.getElementById(long).value = lng;

            });
        }
        $(document).ready(function () {
            setTimeout(function () {
                initAutocomplete('map2',  'searchmap2', 'longitude2', 'latitude2');
            }, 400);
        });
        $('#arabic').on('click', function(){
            setTimeout(function(){
                initAutocomplete('map1', 'searchmap1', 'longitude1', 'latitude1');
            },100)
        });

        $('.companies-submit').click(function () {
            var formData = new FormData(document.forms.namedItem('company-form'));
            console.log(formData);
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lwc&libraries=places&callback=initAutocomplete"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Add Customer
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                    @include('admin.administrators.form', ['admin', $admin, 'action' => $action, 'roles' => $roles])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
