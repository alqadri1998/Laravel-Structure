@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
<section class="custom-sec-inner-account">
    <div class="dashborad-ses">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-navbar')

                <div class="col-md-12 col-lg-9">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <h2 class="my-account-tittle">{{__('Subscription Option')}}</h2>
                        </div>
                        <!-- addess book -->
                        <div class="col-md-12">
                            <div class="inner-account-info-check">
                                <form action="{!! route('front.dashboard.subscription') !!}" method="post">
                                    @csrf
                                <div class="form-check pl-0">
                                    <label class="container">{{__('General Subscription')}}
                                        <input type="checkbox" @if($subscribed == 1) checked @endif name="checked">
                                        <span class="checkmark"></span>
                                    </label>

                                </div>
                            </div>
                            <div class="border-botm-custom mx-0 pt-5">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="location-btn-book-address mt-3">
                                <button type="submit" class="btn btn--primary btn--animate" >{{__('save')}}</button>
{{--                                <a href="#" class="btn btn--primary btn--animate"></a>--}}
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection