<!DOCTYPE html>
<html lang="{!! config('app.locale') !!}">
    <head>
        <title>{!! __(config('settings.company_name')) !!}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{!! asset('assets/img/favicon.Ico') !!}" />
        <!-- Bootstrap -->
        <!-- global css -->
        <link href="{!! asset('assets/admin/css/app.css') !!}" rel="stylesheet" type="text/css">
        <!-- end of global css -->
        @stack('stylesheet-page-level')
        <style type="text/css">
            html {
                background: #313e4b !important;
            }
        </style>
        <script>var baseUrl = '{!! url("/") !!}/';</script>
    </head>
    <body>
        <div class="preloader">
            <div class="loader_img"><img src="{!! asset('assets/admin/media/loader.gif') !!}" alt="loading..." height="64" width="64"></div>
        </div>
        @yield('content')
        <!-- global js -->
        <script src="{!! asset('assets/admin/js/jquery-1.11.3.min.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('assets/admin/js/bootstrap.min.js') !!}" type="text/javascript"></script>
        <!--<script src="{!! asset('assets/admin/js/backstretch.js') !!}" type="text/javascript"></script>-->
        <!-- end of global js -->
        @stack('script-page-level')
        <script type="text/javascript">
            $(document).ready(function () {
                $(window).on('load', function () {
                    $('.preloader img').fadeOut();
                    $('.preloader').fadeOut();
                });
                if ($('.bg-slider').backstretch) {
//                    $('.bg-slider').backstretch([
//                        baseUrl+"assets/img/pages/lbg-1.jpg", 
//                        baseUrl+"assets/img/pages/lbg-2.jpg", 
//                        baseUrl+"assets/img/pages/lbg-3.jpg"
//                    ], {
//                        duration: 2500,
//                        fade: 1050
//                    });
                }
                $('input').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
