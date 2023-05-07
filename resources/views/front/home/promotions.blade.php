@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <!-- promotions html start -->
    <section class="promotion-images-main-sec">
                <div class="container">
                    <div class="row">
                        @forelse($promotions as $promotion)
                        <div class="col-md-4">
                            <div class="main-img-promotion">
                                <form action="{{route('front.product.index')}}" method="get" enctype="multipart/form-data" >
                                    <input hidden name="promotion[{{$promotion->id}}]">
                                    <input hidden name="search" value="1">
                                <button type="submit">
                                    <a href="javascript:void(0)">
                                <img style="width: 360px; height: 234px" class="img-fluid" src="{{$promotion->image}}">
                                    </a>
                                </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </section>
    <!-- end promotions html -->
@endsection