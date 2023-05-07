@extends('front.layouts.app')
@section('content')
    <main>
    @include('front.common.breadcrumb')
    <!-- Privacy Policy Section -->
        <section @if($page->slug == "terms-condition")class="terms-conditions spacing"
                 @else class="privacy-policy spacing" @endif >
            <div class="container">
                <div class="text-center">
                    <h2 class="secondary-headline secondary-headline-black">
                        {{$page->translation->title}}
                        <img class="left-border img-fluid" src="{{asset('assets/front-tyre-shop/images/left-border.png')}}" alt="left-border">
                        <img class="right-border img-fluid" src="{{asset('assets/front-tyre-shop/images/right-border.png')}}" alt="right-border">
                    </h2>
                </div>
                <div class="row">
                    {!! $page->translation->content !!}
                </div>
            </div>
        </section>
    </main>
@endsection