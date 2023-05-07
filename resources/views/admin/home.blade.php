@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
    <link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css"/>
@endpush

@push('script-page-level')
    <script>
        {{--var dailyVisitors = {!! $dailyVisitorChart !!}--}}
        {{--var countryWiseVisitors = {!! $countryWiseVisitors !!}--}}
    </script>
    <script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    {{--<script src="{{asset('assets/admin/js/adv_datatables/users-dashboard.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{asset('assets/admin/js/adv_datatables/cleaners-dashboard.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{asset('assets/admin/js/adv_datatables/servants-dashboard.js')}}" type="text/javascript"></script>--}}
    {{--<script src="{{asset('assets/admin/js/adv_datatables/pro-dashboard.js')}}" type="text/javascript"></script>--}}
    <script src="{{asset('assets/admin/js/charts/amcharts/charts.js')}}" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/radar.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/pie.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js"
            type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>
@endpush

@section('content')
    <!--begin:: Widgets/Stats-->
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="welcome-note-admin">
                {{'Welcome To '. config('settings.company_name').' Administration.'}}
            </div>
{{--            <div class="row m-row--no-padding m-row--col-separator-xl">--}}
{{--                --}}
{{--            --}}{{--    @if($userData['role_id']==config('settings.supplier_role'))--}}
{{--                    <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                        <!--begin::New Feedbacks-->--}}
{{--                        <div class="m-widget24">--}}
{{--                            <div class="m-widget24__item">--}}
{{--                                <h4 class="m-widget24__title">--}}
{{--                                    Cart--}}
{{--                                </h4>--}}
{{--                                <br>--}}
{{--                                <span class="m-widget24__desc">--}}
{{--                                Cart Total--}}
{{--                            </span>--}}
{{--                                <span class="m-widget24__stats m--font-info">--}}
{{--                                {!! Cart::count() !!}--}}
{{--                            </span>--}}
{{--                                <div class="m--space-10"></div>--}}

{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <!--end::New Feedbacks-->--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                    <!--begin::New Orders-->--}}
{{--                    <div class="m-widget24">--}}
{{--                        <div class="m-widget24__item">--}}
{{--                            <h4 class="m-widget24__title">--}}
{{--                                Total Products--}}
{{--                            </h4>--}}
{{--                            <br>--}}
{{--                            <span class="m-widget24__desc">--}}
{{--                                Total Products Order--}}
{{--                            </span>--}}
{{--                            <span class="m-widget24__stats m--font-info ">--}}
{{--                                {!! $totalProducts !!}--}}
{{--                            </span>--}}
{{--                            <div class="m--space-10"></div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--end::New Orders-->--}}
{{--                </div>--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                    <!--begin::New Feedbacks-->--}}
{{--                    <div class="m-widget24">--}}
{{--                        <div class="m-widget24__item">--}}
{{--                            <h4 class="m-widget24__title">--}}
{{--                                Service Package--}}
{{--                            </h4>--}}
{{--                            <br>--}}
{{--                            <span class="m-widget24__desc">--}}
{{--                                Total Service Package--}}
{{--                            </span>--}}
{{--                            <span class="m-widget24__stats m--font-info">--}}
{{--                                {!! $totalPackages !!}--}}
{{--                            </span>--}}
{{--                            <div class="m--space-10"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--end::New Feedbacks-->--}}
{{--                </div>--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                    <!--begin::New Orders-->--}}
{{--                    <div class="m-widget24">--}}
{{--                        <div class="m-widget24__item">--}}
{{--                            <h4 class="m-widget24__title">--}}
{{--                                Pending Orders--}}
{{--                            </h4>--}}
{{--                            <br>--}}
{{--                            <span class="m-widget24__desc">--}}
{{--                                Total pending Order--}}
{{--                            </span>--}}
{{--                            <span class="m-widget24__stats m--font-info">--}}
{{--                                {!! $pendingOrders !!}--}}
{{--                            </span>--}}
{{--                            <div class="m--space-10"></div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--end::New Orders-->--}}
{{--                </div>--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                    <!--begin::New Orders-->--}}
{{--                    <div class="m-widget24">--}}
{{--                        <div class="m-widget24__item">--}}
{{--                            <h4 class="m-widget24__title">--}}
{{--                                In Progress Orders--}}
{{--                            </h4>--}}
{{--                            <br>--}}
{{--                            <span class="m-widget24__desc">--}}
{{--                                Total In Progress Orders--}}
{{--                            </span>--}}
{{--                            <span class="m-widget24__stats m--font-info">--}}
{{--                                {!! $inProgressOrders !!}--}}
{{--                            </span>--}}
{{--                            <div class="m--space-10"></div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--end::New Orders-->--}}
{{--                </div>--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                    <!--begin::New Feedbacks-->--}}
{{--                    <div class="m-widget24">--}}
{{--                        <div class="m-widget24__item">--}}
{{--                            <h4 class="m-widget24__title">--}}
{{--                                Completed Orders--}}
{{--                            </h4>--}}
{{--                            <br>--}}
{{--                            <span class="m-widget24__desc">--}}
{{--                                Total Completed Orders--}}
{{--                            </span>--}}
{{--                            <span class="m-widget24__stats m--font-info">--}}
{{--                                {!! $completeOrders !!}--}}
{{--                            </span>--}}
{{--                            <div class="m--space-10"></div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--end::New Feedbacks-->--}}
{{--                </div>--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                    <!--begin::New Feedbacks-->--}}
{{--                    <div class="m-widget24">--}}
{{--                        <div class="m-widget24__item">--}}
{{--                            <h4 class="m-widget24__title">--}}
{{--                                Coupons--}}
{{--                            </h4>--}}
{{--                            <br>--}}
{{--                            <span class="m-widget24__desc">--}}
{{--                                Total Coupons--}}
{{--                            </span>--}}
{{--                            <span class="m-widget24__stats m--font-info">--}}
{{--                                {!! $coupons !!}--}}
{{--                            </span>--}}
{{--                            <div class="m--space-10"></div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--end::New Feedbacks-->--}}
{{--                </div>--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                    <!--begin::New Feedbacks-->--}}
{{--                    <div class="m-widget24">--}}
{{--                        <div class="m-widget24__item">--}}
{{--                            <h4 class="m-widget24__title">--}}
{{--                                Promotions--}}
{{--                            </h4>--}}
{{--                            <br>--}}
{{--                            <span class="m-widget24__desc">--}}
{{--                               Total Promotions--}}
{{--                            </span>--}}
{{--                            <span class="m-widget24__stats m--font-info">--}}
{{--                                {!! $promotions !!}--}}
{{--                            </span>--}}
{{--                            <div class="m--space-10"></div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--end::New Feedbacks-->--}}
{{--                </div>--}}
{{--                <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                    <!--begin::New Feedbacks-->--}}
{{--                    <div class="m-widget24">--}}
{{--                        <div class="m-widget24__item">--}}
{{--                            <h4 class="m-widget24__title">--}}
{{--                                Categories--}}
{{--                            </h4>--}}
{{--                            <br>--}}
{{--                            <span class="m-widget24__desc">--}}
{{--                                Total Categories--}}
{{--                            </span>--}}
{{--                            <span class="m-widget24__stats m--font-info">--}}
{{--                                {!! $categories !!}--}}
{{--                            </span>--}}
{{--                            <div class="m--space-10"></div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--end::New Feedbacks-->--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
    <!--end:: Widgets/Stats-->
    <!--Begin::Main Portlet-->
    <div class="row">
    <div class="col-xl-12">

    </div>
    </div>
    <!--End::Main Portlet-->



@endsection

@section('custom_js')


@endsection
