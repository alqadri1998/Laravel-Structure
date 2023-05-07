@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
    <style>
        .mce-notification-warning{
            display: none;}
        .btn.btn-outline.dark {
            border-color: #2f353b;
            color: #2f353b;
            background: 0 0;
        }
    </style>
@endpush

@push('script-page-level')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 200,
            theme: 'modern',
            valid_elements : '*[*]',
            verify_html : false,
            plugins: 'print code preview powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
            toolbar1: 'code | formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            toolbar2: 'undo redo | styleselect | bold italic | link image | alignjustify | formatselect | fontselect | fontsizeselect | cut | copy | paste | outdent | indent | blockquote | alignleft | aligncenter | alignright | code | spellchecker | searchreplace | fullscreen | insertdatetime | media | table | ltr | rtl ',
            image_advtab: true,
            automatic_uploads: false,
            images_upload_credentials: true,
//        images_upload_base_path: '{!! url("admin") !!}',
            images_upload_url: "{!! route('admin.home.save-image') !!}",
//            templates: [
//                { title: 'Test template 1', content: 'Test 1' },
//                { title: 'Test template 2', content: 'Test 2' }
//            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        }).then(function(editors) {
            console.log('it ran')
            $('#mceu_95').hide();
        });
    </script>

    <script>
        var latitude = {!! ($page->id > 0) ? $page->latitude : 31.55460609999999 !!};
        var longitude = {!! ($page->id > 0) ? $page->longitude : 74.35715809999999 !!};
    </script>

    <script>
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
        function test(unix_timestamp){
            var date = new Date(unix_timestamp*1000);
// Hours part from the timestamp
            var hours = date.getHours();
// Minutes part from the timestamp
            var minutes = "0" + date.getMinutes();
// Seconds part from the timestamp
            var seconds = "0" + date.getSeconds();

// Will display time in 10:30:23 format
            var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
            return formattedTime;
        }

        $(document).ready(function() {

            $('.starts').val(test({!! $page->start_time !!}));
            $('.ends').val(test({!! $page->end_time !!}));
            setTimeout(function(){
                initAutocomplete('map2', 'searchmap2', 'longitude2', 'latitude2');
            },1000);
        });



        $('#test').on('click', function(){
            setTimeout(function(){
                initAutocomplete('map1', 'searchmap1', 'longitude1', 'latitude1');
            },1000)
        });

        $('#test1').on('click', function(){
            setTimeout(function(){
                initAutocomplete('map2',  'searchmap2', 'longitude2', 'latitude2');
            },1000)
        });
        $('.post-date').bind('input', function() {
            var date = new Date($(this).val());
//            console.log('date='+date);
            var starts = (new Date(date).getTime())/1000;
//            console.log('start='+starts);
            $('.post_date').val(starts);
        });
        $('.starts').bind('input', function() {

            var date = new Date($('.post_date').val()*1000);
//            console.log(date);
            date = date.getUTCFullYear() +'-'+ (date.getMonth()+1) + '-' + date.getUTCDate();
            date = date + ' ' + $(this).val();
//            console.log('start_date='+date);
            var starts = (new Date(date).getTime())/1000;
//            console.log('start='+starts);
            $('.time_starts').val(starts);
        });
        $('.ends').bind('input', function() {
            var date = new Date($('.post_date').val()*1000);
            date = date.getUTCFullYear() +'-'+ (date.getMonth()+1) + '-' + date.getUTCDate();
            date = date + ' ' + $(this).val();
//            console.log('end_date='+date);
            var ends = (new Date(date).getTime())/1000;
//            console.log('ends='+ends);
            $('.time_ends').val(ends)
        });
        $(document).ready(function(){
            //Image file input change event
            $("#image").change(function(){
                readImageData(this);//Call image read and render function
            });
        });
        function readImageData(imgData){
            if (imgData.files && imgData.files[0]) {
                var readerObj = new FileReader();
                readerObj.onload = function (element) {
                    $('#preview_img').attr('src', element.target.result);
                }

                readerObj.readAsDataURL(imgData.files[0]);
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lwc&libraries=places&callback=initAutocomplete"></script>
{{--    @include('admin.common.upload-gallery-js-links')--}}
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
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#english" role="tab" id="test1">
                                    <i class="flaticon-share m--hide"></i>
                                    English
                                </a>
                            </li>
                            @if($pageId > 0)
{{--                                <li class="nav-item m-tabs__item">--}}
{{--                                    <a class="nav-link m-tabs__link " data-toggle="tab" href="#arabic" role="tab" id="test" >--}}
{{--                                        <i class="flaticon-share m--hide"></i>--}}
{{--                                        عربى--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="english">
                        @include('admin.pages.form', ['languageId' => $locales['en']])
                    </div>
                    @if($pageId > 0)
                        <div class="tab-pane " id="arabic">
                            @include('admin.pages.form', ['languageId' => $locales['ar']])
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
