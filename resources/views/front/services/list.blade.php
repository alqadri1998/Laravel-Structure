@extends('front.layouts.app')
@section('content')
    <!-- Service Listing-->
    @include('front.common.breadcrumb')

    <section class="our-services spacing services">
        <div class="container">

            <div class="row custom-row">
                @forelse($services as $service)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 cols">
                        <div class="services-card">
                            <div class="services-card-title text-center">
                                <h4 class="title">{{$service->translation->title}}</h4>
                            </div>
                            <a href="{!! route('front.services.detail',['slug' => $service->slug]) !!}">

                                <div class="services-card-content">
                                    <div class="services-bg">
                                    <img src="{{imageUrl($service->image)}}" alt="services-bg-img" title="{{$service->translation->title}}" class="services-bg-img">
                                    </div>                                    
                                    <img src="{{url($service->icon)}}" class="img-fluid flaticon">
                                </div>
                            </a>

                        </div>
                    </div>
                    @empty
                @endforelse
            </div>

            {!! $services->appends(request()->query())->links() !!}

        </div>
    </section>

@endsection
