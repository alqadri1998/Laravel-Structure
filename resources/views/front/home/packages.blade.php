@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <!-- Packages Section -->
    <section class="our-services services-package spacing packages">
                <div class="container">

                     <div class="row custom-row">
                          @forelse($servicePackages as $package)
                          <div class="col-sm-6 col-lg-4 cols mb-5">
                               <div class="services-card">
                                    <div class="services-card-title text-center">
                                         <h4 class="title">{{$package->translation->title}}</h4>
                                    </div>
                                    <div class="services-card-content align-items-center justify-content-between">
                                         <div class="text-block text-center">
                                              {!! $package->translation->long_description !!}
                                         </div>
                                         <div class="bottom-block text-center">
                                              <h3 class="price">
                                                   {{$currency.' '.getConvertedPrice(1,$package->price)}}
                                              </h3>
                                              <p class="bottom-desc">
                                                   {!! $package->translation->short_description !!}
                                              </p>
                                              <form action="{!! route('front.cart.add') !!}" method="post">
                                                  @csrf
                                                  <input type="hidden" id="product_quantity" name="quantity" class="count-output" value="1">
                                                  <input type="hidden" name="product_id" value="{!! $package->id !!}">
                                              <button type="submit" class="btn btn--primary btn--animate">Buy Now</button>
                                              </form>
                                         </div>
                                    </div>
                               </div>
                          </div>
                          @empty
                          @endforelse
                     </div>

                     {!! $servicePackages->appends(request()->query())->links() !!}
                </div>
           </section>
    <!--/ Packages Section -->

@endsection