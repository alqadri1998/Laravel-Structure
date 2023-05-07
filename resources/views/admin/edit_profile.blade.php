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

        var latitude = {!! ($adminData['id'] > 0) ? ((empty($adminData['latitude']) ? 31.55460609999999 : $adminData['latitude'])) : 31.55460609999999 !!};
        var longitude = {!! ($adminData['id'] > 0) ? ((empty($adminData['longitude']) ? 74.35715809999999 : $adminData['longitude'])) : 74.35715809999999 !!};

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
                initAutocomplete('map1', 'searchmap1', 'longitude1', 'latitude1');
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
                                    Edit Profile
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        {!! Form::model($adminData, ['route' => 'admin.home.update-profile', 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Full Name') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    {!! Form::text('full_name', old('full_name'), ['class' => 'form-control', 'id' => 'full_name', 'placeholder' => __('Full Name'), 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Username') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    {!! Form::text('user_name', old('user_name'), ['class' => 'form-control', 'id' => 'user_name', 'placeholder' => __('Username'), 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Email') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    {!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'placeholder' => __('Email'), 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Password') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => __('Password')]) !!}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Confirm Password') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'placeholder' => __('Password Confirmation')]) !!}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Address') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">

                                    {!! Form::text('address', old('address', $adminData['address']), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'searchmap'.$languageId]) !!}
                                    {!! Form::hidden('longitude', old('longitude', $adminData['longitude']), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'longitude'.$languageId]) !!}
                                    {!! Form::hidden('latitude', old('latitude', $adminData['latitude']), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'latitude'.$languageId]) !!}
                                </div>
                            </div>
                            {{--Map is no longer required to show--}}
                            <div hidden class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Change Position') !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                    <div id="map{!! $languageId !!}" style="height:500px; width:auto;margin-top: 48px"></div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! __('Image') !!}
                                    <span class="text-danger">*</span>

                                </label>
                                <div class="col-7">
                                    @include('admin.common.upload-gallery-modal')
                                </div>
                            </div>

                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-3 col-form-label">
                                    Current Image
                                    </label>
                                    <div class="col-3" style="padding-top: 140px">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img style="width:120px;height: 120px; " src="{!! imageUrl(url($adminData['profile_pic']), 120, 120, 100, 1) !!}" id="image" class="selected-image img-fluid">
                                        </div>
                                        <span class="mx-2 smaller-font-size text-danger">Recommended size 120  x 120</span>
                                    </div>

                                </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <input type="hidden" value="PUT" name="_method">
                                    <div class="col-4"></div>
                                    <div class="col-7">
                                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                            Save changes
                                        </button>
                                        &nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
