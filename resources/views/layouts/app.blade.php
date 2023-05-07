<!DOCTYPE html>

<html lang="{!! $locale !!}" dir="{!! ($locale=='en') ? 'ltr':'rtl' !!}" data-ng-app="servantCleaner">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1" id="Wj_viewport">

    <meta name="description" content="">

    <meta name="keywords" content="">

    <meta name="format-detection" content ="telephone=no">

    <meta name="format-detection" content="date=no">

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{!! csrf_token() !!}">

    <title>{!! __(config('app.name', 'Cars World')) !!}</title>

    <link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=BenchNine" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <script src="{!! asset('assets/angular/libraries/paging.js') !!}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.20/angular-animate.min.js"></script>

    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.9.0/loading-bar.min.css' type='text/css' media='all' />

    <script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.9.0/loading-bar.min.js'></script>

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script>

        window.Laravel = {!! json_encode([

                'csrfToken' => csrf_token(),

                'baseUrl' => ($maintenance_mode == 1) ? url($locale).'/' : url($locale).'/'.env('UNDER_MAINTENANCE_MODE_PREFIX').'/',

                'base' => url('/').'/',

                'authorization' => (!empty($userData) ? $userData['authorization']:''),

            ]) !!};

    </script>

    <script>function togle_menu(x) {x.classList.toggle("change");}</script>

    <script src="https://cdn.jsdelivr.net/npm/angular-toastr@2/dist/angular-toastr.tpls.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/angular-toastr@2/dist/angular-toastr.css">

    <script src="{!! asset('assets/angular/app/app.js') !!}"></script>

    <style>

        #loading-bar .bar {

            background-color: #1f496e;

            height: 3px;

        }

    </style>

    @stack('style-page-level')

</head>

<body class="aliceblue flipped">

<div id="ajaxLoader" class="ajaxLoader" style="display:none;color:#1f496e;position: fixed;left:50%;top:50%; z-index: 1001;">

    <div id="status" ><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>

        <span class="sr-only">Loading...</span></div>

</div>

<div id="app">

    @yield('content')

</div>

<!-- Scripts -->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>

<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>




@stack('script-page-level')

</body>

</html>