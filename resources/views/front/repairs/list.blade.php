@extends('front.layouts.app')
@section('content')
    <!-- Service Listing-->
    @include('front.common.breadcrumb')

    <section class="our-services spacing services">
        <div class="container">

            <div class="row custom-row">
                @forelse($repairs as $repair)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 cols">
                        <div class="services-card">
                            <div class="services-card-title text-center">
                                <h4 class="title">{{$repair->translation->title}}</h4>
                            </div>
                            <a href="{!! route('front.repairs.detail',['slug' => $repair->slug]) !!}">

                                <div class="services-card-content">
                                <div class="services-bg">
                                    <img src="{{imageUrl($repair->image)}}" alt="services-bg-img" class="services-bg-img">
                                    </div> 
                                    <img src="{{url($repair->icon)}}" class="img-fluid flaticon">
                                </div>
                            </a>

                        </div>
                    </div>
                    @empty
                @endforelse
            </div>
            {!! $repairs->appends(request()->query())->links() !!}

        </div>
    </section>

@endsection
