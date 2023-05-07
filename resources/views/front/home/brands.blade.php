@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <!-- Our Brands html -->
    <section class="spacing our-brands brands-page bg-white">
                 <div class="container">
                    <h2 class="headline">Brands We Trust</h2>
                    <p class="primary-text text-justify">
                         Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seldiyd diam nonumyii eirmod tempor invidunt ut labore et dolidodtiore magna lorem i aliquyam erat, sed aii diam voluptuaii At vero eos eklmifut accusam et justo lorem ipsum sit amret ain lorem ipsum diam enim uit amet laboreio
                         airomed tempor sit aamet concecuter ipsum diam enim uit amet laboreio.                                                            
                    </p>
                    <div class="brands-logo-grid">               
                         <div class="row sm-logo-row">
                              @forelse($brands as $brand)
                              <div class="col-6 col-sm-3 col-lg-3 cols cols">
                                   <div class="img-sec">
                                       <form action="{{route('front.product.index')}}" method="get" enctype="multipart/form-data" >
                                       <button type="submit" class="btn-submit-brand">
                                           <input hidden name="brand[{{$brand->id}}]">
                                           <input hidden name="search" value="1">                                       
                                           <img src="{!! imageUrl(url($brand->image),161,177,95,3) !!}" alt="brand-01" class="brand-logo img-fluid">
                                       </button>
                                       </form>
                                        {{--                                        <a href="#">--}}
                                        {{--                                             <img src="{!! imageUrl(url($brand->image),161,177,95,3) !!}" alt="brand-01" class="brand-logo img-fluid">--}}
                                        {{--                                        </a>--}}
                                   </div>
                              </div>
                              @empty
                              @endforelse
                         </div>
                    </div>
                 </div>                 
            </section>
    <!-- end Our Brands html -->

@endsection