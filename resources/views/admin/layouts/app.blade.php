<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            {!! config('settings.company_name') !!}
        </title>
        <meta name="description" content="Bootstrap alert examples">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel='icon' href='{{asset('assets/img/favicon.png')}}' type='image/x-icon'/>
        <script>
            WebFont.load({
                google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <script type="text/javascript">
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/')."/admin/"/*url(config('app.locale')).'/'*/,
                'apiUrl' => url('/')."/api/"/*url(config('app.locale')).'/'*/,
               /* 'baseUrl' => url('/').'/'.config('app.locale')."/admin/",
                'apiUrl' => url('/').'/'.config('app.locale')."/api/",*/
                'base' => url('/').'/',
                 'locale' => config('app.locale')
            ]) !!};
        </script>
        <style>
            .overlap .bef{
                max-height: 420px !important;
                height: auto !important;
            }
        </style>
        <link href="{{asset('assets/admin/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/admin/css/style1.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <link href="{{asset('assets/admin/css/sdtyres.css')}}" rel="stylesheet" type="text/css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
        <link rel="shortcut icon" href="{{asset('dist/assets/img/rent-car-favicon.png')}}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        @stack('stylesheet-page-level')
        @stack('stylesheet-end')
    </head>
    <body data-ng-app="app" class="rtl m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        <div class="m-grid m-grid--hor m-grid--root m-page">
            @include('admin.common.header')
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                @include('admin.common.left-sidebar')
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    @yield('breadcrumb')
                    <div class="m-content">
                        @include('admin.common.alerts')
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('admin.common.footer')
        </div>
        <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
            <i class="la la-arrow-up"></i>
        </div>
        <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
        <script src="{{asset('assets/admin/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/admin/js/scripts.bundle.js')}}" type="text/javascript"></script>
        <script src="{!! asset('assets/admin/js/custom/functions.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('assets/admin/js/select2.js') !!}" type="text/javascript"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.5/angular.min.js"></script>
        <script src="{{ asset('assets/admin/js/app/app.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/admin/js/app/services/common.js')}}" type="text/javascript"></script>

        <!-- end of global js -->
        @stack('script-page-level')
        <!-- custom scripts -->
        @stack('script-end')
        <script type="text/javascript">
            function count() {
                $.ajax({
                    headers: {

                        'Authorization': 'Bearer {!! $admin['token'] !!}'
                    },
                    url: window.Laravel.apiUrl+"admin/notifications-count",
                    success:function (res) {
                        $(".bell-icon").text(res.data.collection.count);
                    }
                });

            }
            $.fn.serializeObject = function () {
                var o = {};
                var a = this.serializeArray();
                $.each(a, function () {
                    if (o[this.name] !== undefined) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };
            $(document).ready(function(){

                    if( $('.m-menu__item ul.m-menu__subnav li.nav-active').length !== 0) {
                        $('.m-menu__item').addClass('m-menu__item--open');
                    }
                if ($('.mt-select2').length > 0) {
                    $(".mt-select2").select2({
                        theme: "bootstrap"
                    });
                }
                if ($('.mt-datetime-picker').length > 0) {
                    $('.mt-datetime-picker').datepicker({minDate: new Date(new Date().getTime()+(24 * 60 * 60 * 1000)),}); // min date = tomorrw
                }
            });
        </script>
        <script>
            $(document).ready(function () {
                $('.dropdown-menu del-notification').on('click', function(e) {
                    e.stopPropagation();
                });


                $(".bell-icon").on('click',function () {

                    $.ajax({
                        headers: {

                            'Authorization': 'Bearer {!! $admin['token'] !!}'
                        },
                        url: window.Laravel.apiUrl+"admin/notifications",
                        success:function (res) {
                            if (res.data.collection == ''){
                                $(".bef").empty();
                                $('.bef').height('95px');
                                let div =$("<div class='notification-item d-flex align-items-center'><a >" +
                                    "<div class='d-flex align-items-start'>" +
                                    "<div><img class='img-fluid'  ></div>" +
                                    "<div class='info w-100'>" +
                                    "<div class='text'>" +
                                    "<p class='title mb-0' i18n>no data found</p>" +
                                    "</div></div></div></a>" +
                                    "</div>");
                                $(".bef").append(div);
                            }
                            else{
                                $(".bef").empty();

                                $.each(res.data.collection,function (key,value) {
                                    let extras = JSON.parse(value['extras']);
                                    let route = window.Laravel.baseUrl+"orders/"+extras['order_id']+'/order-detail';
                                    let div =$("<div class='notification-item d-flex align-items-center'><a class='is-read' data-id='"+extras['order_id']+"' href='"+route+"' >" +
                                        "<div class='d-flex align-items-start'>" +
                                        "<div class='image mr-2'><img src='{!! imageUrl(asset('assets/img/favicon.png')) !!}' class='img-fluid'  ></div>" +
                                        "<div class='info w-100'>" +
                                        "<div class='text'>" +
                                        "<p class='title mb-0' i18n>"+value['translation']['title']+"</p>" +
                                        "<p class='desc mb-0' i18n>"+value['translation']['description']+"</p></div></div></div></a>" +
                                        "<p class='time mb-0'>"+value['time']+"</p>" +
                                        "<button class='btn delete del-notification' data-id='"+value['id']+"'>" +
                                        "<i class='fa fa-times' aria-hidden='true'></i></button></div>");
                                    $(".bef").append(div);
                                });
                                let view_all = window.Laravel.baseUrl+"admin/notifications";
                                let divBottom = $("<div class='w-100' style='height: 54px;'></div><div class='last-btn d-flex justify-content-between bg-light p-2'>" +
                            "<a href='"+view_all+"' class='view-all ml-2 gothic-bold'>View all</a><a href='javascript:void(0)' class='clear mr-2 clear-all'><i class='fa fa-times secondary-color '>clear all</i></a></div>");
                        $(".bef").append(divBottom);
                                if ($(".bell-icon").text() > 0){
                                    $.ajax({
                                        headers: {
                                            'Authorization': 'Bearer {!! $admin['token'] !!}'
                                        },
                                        url: window.Laravel.apiUrl+"admin/notification-seen",
                                        success: function (res) {
                                            count();
                                        }
                                    });
                                }
                            }
                        }
                    })
                });
                $(document).on('click','.del-notification',function () {
                    let id =  $(this).attr('data-id');
                    swal({
                            title: "Are You Sure You Want To Delete This?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Delete",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false,
                            showLoaderOnConfirm: true
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $.ajax({
                                    headers: {

                                        'Authorization': 'Bearer {!! $admin['token'] !!}'
                                    },
                                    url: window.Laravel.apiUrl+"admin/notification-delete/"+id,
                                })
                                    .done(function(res){ toastr.success("You have deleted Notification successfully!");
                                        $('.bell-icon').trigger('click');
                                        count();
                                        swal.close()
                                    })
                                    .fail(function(res){ toastr.success("You have deleted notification successfully!"); swal.close()  });
                            } else {
                                 swal.close();
                            }
                        });
                })

                $(document).on('click','.clear-all',function () {
                    swal({
                            title: "Are You Sure You Want To Delete This?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Delete",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false,
                            showLoaderOnConfirm: true
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $.ajax({
                                    headers: {

                                        'Authorization': 'Bearer {!! $admin['token'] !!}'
                                    },
                                    url: window.Laravel.apiUrl+"admin/notifications-clear",
                                })
                                    .done(function(res){ toastr.success("All Notifications deleted  successfully!");
                                        $(".bell-icon").click()
                                        swal.close()
                                    })
                                    .fail(function(res){ toastr.success("All Notifications deleted successfully!"); swal.close()  });
                            } else {
                                 swal.close();
                            }
                        });
                })
            });
        </script>
        <script>

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('myKey', {
                auth: {
                    headers: {
                        {{--'X-CSRF-Token': '{{ csrf_token() }}',--}}
                        'calledFrom': 'admin',
                        'Authorization': 'Bearer '+'{{$admin['token']}}'
                    }
                },
                wsHost: window.location.hostname,
                wsPort: 6001,
                 authEndpoint: '/sd-tyres-store/en/broadcasting/auth',
              //  authEndpoint: '/en/broadcasting/auth',
               // disabledTransports: ['wss', 'sockjs']
                enabledTransports: ['ws']
            });

            var channel = pusher.subscribe('private-sd-tyres-admin-'+{{$admin['id']}});
            channel.bind('pusher:subscription_succeeded', function(members) {
                console.log('Connected to channel Admin');
                count();
            });
            channel.bind('newNotificationEvent', function(data) {
                count();
            });
        </script>
        <script>

            $(document).ready(function () {
                setInterval(countNotifications,20000);
                {{--Unable to get websocket to work, so showing the notification manually--}}
                function countNotifications() {
                    // console.log('is this 10 seconds ')
                    $.ajax({
                        headers: {

                            'Authorization': 'Bearer {!! $admin['token'] !!}'
                        },
                        url: window.Laravel.apiUrl+"admin/notifications-count",
                        success:function (res) {
                            $(".bell-icon").text(res.data.collection.count);
                        }
                    });

                }
            });

            function specialCharacters(expression){
                var key = event.keyCode || event.which;
                // console.log(key)
                $(".special_character_error").html("");
                //Regular Expression
                var reg_exp = expression;
                //Validate Text Field value against the Regex.
                var is_valid = reg_exp.test(String.fromCharCode(key));
                if (!is_valid) {
                    $(".special_character_error").html("Special characters are not allowed in email");
                }
                return is_valid;
            }

        </script>

        @yield('custom_js')
    </body>
</html>
