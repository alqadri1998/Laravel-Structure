@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <section class="services-sub spacing">
        <div class="container">
            <div class="row sub-services-row">
                <div class="col-12 col-sm-6 services-left-col">
                    <div class="service-left-img">
                        <img src="{!! imageUrl(url($service->image),584,295,100,1) !!}" alt="left-img" class="left-img img-fluid">
                    </div>
                </div>

                {!! $service->translation->description !!}

            </div>
        </div>
    </section>

    @include('front.common.book-appointment')

@endsection
