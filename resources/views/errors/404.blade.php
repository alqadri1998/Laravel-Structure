@extends('front.layouts.app')
@section('content')
<section class="four-o-four">
    <div class="outer">
        <div class="inner-box">
            <img class="img-fluid" src="{{asset('assets/front-tyre-shop/images/404-text.png')}}" alt="404-text">
            <p class="title">
                {{__('We are sorry, but the page you requested was not found')}}
            </p>
            <div class="btns">
                <a href="{!! route('front.index') !!}" class="btn btn--white btn--animate">{{__('Go Home')}}</a>
                <a href="{{ route('front.contactUs') }}" class="btn btn--transparent btn--animate">{{__('Contact Us')}}</a>
            </div>
            <div class="social-icons justify-content-center mt-5">
                <div class="icons">
                    <a target="_blank" href="{!! __(config('settings.facebook_url')) !!}" class="font-icon"><i class="fab fa-facebook-f"></i></a>
                    <a target="_blank" href="{!! __(config('settings.instagram_url')) !!}" class="font-icon"><i class="fab fa-instagram"></i></a>
                    <a target="_blank" href="{!! __(config('settings.twitter_url')) !!}" class="font-icon"><i class="fab fa-twitter"></i></a>
{{--                    <a target="_blank" href="https://wa.me/{!! __(config('settings.contact_number')) !!}/?text=contact us" class="font-icon"><i class="fab fa-whatsapp"></i></a>--}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
