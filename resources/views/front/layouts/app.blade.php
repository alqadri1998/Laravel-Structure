<!DOCTYPE html>
<html lang="en" data-ng-app="cars">
{{--<html lang="{!! $locale !!}" dir="{!! ($locale=='en') ? 'ltr':'rtl' !!}" data-ng-app="servantCleaner">--}}

<!-- begin::Head -->

<head>
    {{--Tyre Shop Head--}}
    <meta charset="UTF-8">
    <title>
        {!! config('settings.company_name') !!}
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <link rel='icon' href='{{asset('assets/img/favicon.png')}}' type='image/x-icon'/>

    <link rel="stylesheet" type="text/css" media="screen"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/front-tyre-shop/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front-tyre-shop/css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front-tyre-shop/scss/css/style.css')}}">

    <link rel="stylesheet" type="text/css" media="screen"
          href="{{asset('assets/front-tyre-shop/scss/css/bootstrap.min.css')}} "/>
    {{-- / Tyre Shop Head--}}


    @stack('stylesheet-page-level')
    @stack('stylesheet-end')
    <link rel="stylesheet" href="{{asset('assets/front/css/slick.css')}}"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

</head>

<body class="{!! $locale == 'en'?'ltr':'rtl' !!}">
{{--<div class="mt-frontend">--}}


    @include('front.common.header')

    @yield('content')

    @include('front.common.footer')




<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5f48962e1e7ade5df444b4e4/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->


    {{--Scripts Tyre Shop--}}
    <script src="{{asset('assets/front-tyre-shop/js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('assets/front-tyre-shop/js/jquery-migrate-1.4.1.min.js')}}"></script>
    <script src="{{asset('assets/front-tyre-shop/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/front-tyre-shop/js/bootstrap.min.js')}}"></script>    
    <script type="text/javascript" src="{{asset('assets/front-tyre-shop/js/slick.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/front-tyre-shop/js/main.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>

    
    {{--/ Scripts Tyre Shop--}}








    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/')."/"/*url(config('app.locale')).'/'*/,
                'apiUrl' => url('/')."/api/"/*url(config('app.locale')).'/'*/,
             /*   'baseUrl' => url('/').'/'.config('app.locale')."/",
                'apiUrl' => url('/').'/'.config('app.locale')."/api/",*/
                'base' => url('/').'/',
                 'locale' => config('app.locale'),
                 'translations' => [
                     'clear-all' => 'Clear All',
                     'view-all' => 'View All',
                     'yes' => 'Yes',
                     'no' => 'No',
                     'sub-category' => 'Sub Category',
                     'sub-sub-category' => 'Select Sub-Subcategory',
                     'select' => 'Select',
                 ]
                //  'user_id' => $user['id'],
                //  'authorization' => $user['token']

            ]) !!};
    </script>


    <script>
        $(function () {
            // ------------------------------------------------------- //
            // Multi Level dropdowns
            // ------------------------------------------------------ //
            $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function (event) {
                event.preventDefault();
                event.stopPropagation();

                $(this).siblings().toggleClass("show");


                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });

            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>

    <script>
        function myFunctionDrop(sel) {
            $('.level2').removeClass('show');
            // $(this).find('ul').addClass('show');
        }

        @if(isset($userData))
        {{--Unable to get websocket to work, so showing the notification manually--}}
        $(document).ready(function () {
            setInterval(cartCount,20000);
            // setInterval(cartCount,5000);
            function cartCount() {
                console.log('cart counted');
                $.ajax({
                    headers: {

                        'Authorization': 'Bearer {!! $user['token'] !!}'
                    },
                    url: window.Laravel.apiUrl+"user/cart-count/"+ {{$user['id']}},
                    success:function (res) {
                        // console.log('response of cart count', res);
                        $("#cartCount").text(res.data.collection.count);
                    }
                });

            }
        });
        @endif

        $(document).ready(function () {

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            if ("{!! session()->has('status') !!}") {

                toastr.success('Success', "{!! session()->get('status') !!}")
            }
            if ("{!! session()->has('err') !!}") {

                toastr.error('Alert', "{!! session()->get('err') !!}")
            }

            if ($('#dropdownMenuLink').length > 0) {
                $('#dropdownMenuLink').trigger('click');
            }
        });
    </script>


    @if($userData)
        <script>
            function count() {
                $.ajax({
                    headers: {

                        'Authorization': 'Bearer {!! $user['token'] !!}'
                    },
                    url: window.Laravel.apiUrl + "notifications-count",
                    success: function (res) {
                        $(".bell-span").text(res.data.collection.count);
                    }
                });

            }

            function showNotifications() {
                $.ajax({
                    headers: {

                        'Authorization': 'Bearer {!! $user['token'] !!}'
                    },
                    url: window.Laravel.apiUrl + "notifications",
                    success: function (res) {
                        if (res.data.collection == '') {
                            $(".bef").empty();
                            $('.bef').height('95px');

                            let div = $("<div class='notification-item d-flex align-items-center'><a >" +
                                "<div class='d-flex align-items-start'>" +
                                "<div class='mx-2'><img class='img-fluid'  ></div>" +
                                "<div class='info w-100'>" +
                                "<div class='text'>" +
                                "<p class='title mb-0' i18n>no data found</p>" +
                                "</div></div></div></a>" +
                                "</div>");
                            $(".bef").append(div);
                        } else {
                            $(".bef").empty();

                            $.each(res.data.collection, function (key, value) {
                                let extras = JSON.parse(value['extras']);
                                let route = '';
                                if (extras['order_id'] == undefined) {
                                    route = window.Laravel.baseUrl + "cart";
                                } else {
                                    route = window.Laravel.baseUrl + "order-detail/" + extras['order_id'];
                                }
                                let div = $("<div class='notification-item d-flex align-items-center'><a class='is-read' data-id='" + extras['order_id'] + "' href='" + route + "' >" +
                                    "<div class='d-flex align-items-start ali'>" +
                                    "<div class='image'><img src='{!! imageUrl(asset('assets/img/favicon.png'))!!}' class='img-fluid'  ></div>" +
                                    "<div class='info'>" +
                                    "<div class='text'>" +
                                    "<p class='title mb-0 text-truncate' i18n>" + value['translation']['title'] + "</p>" +
                                    "<p class='desc mb-0 text-truncate' i18n>" + value['translation']['description'] + "</p></div></div></div></a>" +
                                    "<p class='time mb-0 text-truncate'>" + value['time'] + "</p>" +
                                    "<button class='btn delete del-notification img-bt' data-id='" + value['id'] + "'>" +
                                    "<svg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'>" +
                                    "<g id='Union_1' data-name='Union 1'>" +
                                    "<path d='M 6.400000095367432 7.292900085449219 L 4.353549957275391 5.246449947357178 L 4 4.892889976501465 L 3.646450042724609 5.246449947357178 L 1.600000023841858 7.292900085449219 L 0.707099974155426 6.400000095367432 L 2.753550052642822 4.353549957275391 L 3.107110023498535 4 L 2.753550052642822 3.646450042724609 L 0.707099974155426 1.600000023841858 L 1.600000023841858 0.707099974155426 L 3.646450042724609 2.753550052642822 L 4 3.107110023498535 L 4.353549957275391 2.753550052642822 L 6.400000095367432 0.707099974155426 L 7.292900085449219 1.600000023841858 L 5.246449947357178 3.646450042724609 L 4.892889976501465 4 L 5.246449947357178 4.353549957275391 L 7.292900085449219 6.400000095367432 L 6.400000095367432 7.292900085449219 Z' stroke='none'/>" +
                                    "<path d='M 6.400000095367432 6.585780143737793 L 6.585780143737793 6.400000095367432 L 4.892889976501465 4.707109928131104 L 4.185790061950684 4 L 4.892889976501465 3.292890071868896 L 6.585780143737793 1.600000023841858 L 6.400000095367432 1.414219975471497 L 4.707109928131104 3.107110023498535 L 4 3.814209938049316 L 3.292890071868896 3.107110023498535 L 1.600000023841858 1.414219975471497 L 1.414219975471497 1.600000023841858 L 3.107110023498535 3.292890071868896 L 3.814209938049316 4 L 3.107110023498535 4.707109928131104 L 1.414219975471497 6.400000095367432 L 1.600000023841858 6.585780143737793 L 3.292890071868896 4.892889976501465 L 4 4.185790061950684 L 4.707109928131104 4.892889976501465 L 6.400000095367432 6.585780143737793 M 6.400000095367432 8 L 4 5.599999904632568 L 1.600000023841858 8 L 0 6.400000095367432 L 2.400000095367432 4 L 0 1.600000023841858 L 1.600000023841858 0 L 4 2.400000095367432 L 6.400000095367432 0 L 8 1.600000023841858 L 5.599999904632568 4 L 8 6.400000095367432 L 6.400000095367432 8 Z' stroke='none' />" +
                                    "</g>" +
                                    "</svg></button></div>");
                                $(".bef").append(div);
                            });
                            let view_all = window.Laravel.baseUrl + "notifications";
                            let divBottom = $("<div class='w-100' style='height: 54px;'></div><div class='last-btn d-flex justify-content-between bg-light p-2'>" +
                                "<a href='" + view_all + "' class='view-all ml-2 gothic-bold'>" + window.Laravel.translations['view-all'] + "</a><a href='javascript:void(0)' class='clear mr-2 clear-all'><i class='fa fa-times secondary-color '>" + window.Laravel.translations['clear-all'] + "</i></a></div>");
                            $(".bef").append(divBottom);
                            if ($(".bell-span").text() > 0) {
                                $.ajax({
                                    headers: {
                                        'Authorization': 'Bearer {!! $user['token'] !!}'
                                    },
                                    url: window.Laravel.apiUrl + "notification-seen",
                                    success: function (res) {
                                        count();
                                    }
                                });
                            }
                        }
                    }
                })
            }

            $(document).ready(function () {


                $(".ar-up").click(function () {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 400);
                });
                $(document).on('click', '#dropdown-menu', function (e) {
                    e.stopPropagation();
                });

                $("#bell-1").on('click', function () {
                    showNotifications()

                });
                $(document).on('click', '.del-notification', function () {
                    let id = $(this).attr('data-id');
                    swal({
                            title: "{!! "Are you sure you want to delete this?" !!}",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: window.Laravel.translations['yes'],
                            cancelButtonText: window.Laravel.translations['no'],
                            closeOnConfirm: false,
                            closeOnCancel: false,
                            showLoaderOnConfirm: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    headers: {

                                        'Authorization': 'Bearer {!! $user['token'] !!}'
                                    },
                                    url: window.Laravel.apiUrl + "notification-delete/" + id,
                                })
                                    .done(function (res) {
                                        toastr.success("{!! "You have deleted notification successfully!" !!}");
                                        $("#bell-1").click()
                                        count();
                                        swal.close()
                                    })
                                    .fail(function (res) {
                                        toastr.success("{!! "You have deleted notification successfully!" !!}");
                                    });
                            } else {
                                swal.close();
                            }
                        });

                })

                $(document).on('click', '.clear-all', function () {
                    swal({
                            title: "{!! "Are you sure you want to delete this?" !!}",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: window.Laravel.translations['yes'],
                            cancelButtonText: window.Laravel.translations['no'],
                            closeOnConfirm: false,
                            closeOnCancel: false,
                            showLoaderOnConfirm: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    headers: {

                                        'Authorization': 'Bearer {!! $user['token'] !!}'
                                    },
                                    url: window.Laravel.apiUrl + "notifications-clear",
                                })
                                    .done(function (res) {
                                        toastr.success("{!! "All notifications deleted successfully!" !!}");
                                        $("#bell-1").click()
                                        swal.close()
                                    })
                                    .fail(function (res) {
                                        toastr.success("{!! "All notifications deleted successfully!" !!}");
                                    });
                            } else {
                                swal.close();
                            }
                        });
                })
            })


            // function  myfunction(){
            //     $(".dropdown-menu>a>ul").removeClass("show");
            //   }
        </script>
        <!--End of Tawk.to Script-->
    @endif
    @stack('script-page-level')

    @stack('script-end')


{{--</div>--}}
</body>
</html>
