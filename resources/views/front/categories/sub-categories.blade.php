@extends('front.layouts.app')
@section('content')
@include('front.common.breadcrumb')

<!-- category-section -->
<section class="category category-section-page padding-to-sec">
    <div class="container text-center font-weight-bold">
        <div class="row">
            @foreach($subCategories as $key => $category)
           <div class="col-md-4 col-lg-2 mb-4">
               <div class="cat-des d-flex justify-content-center align-items-center">
               <div>
                   <a href="{!! route('front.product.index',['category' => $category->parent_id,'sub_category' => $category->id]) !!}">
                       <div class="slider-item d-flex align-items-center justify-content-center">
                           <div class="img-div category-img">
                           <img src="{{imageUrl(url($category->image),165,165)}}" alt="{!! $category->translation->name !!}" class="d-block m-auto img-fluid">
                           </div>
                          
                       </div>
                   </a>
                   </div>
                
               </div>
               <p class="pt-3 text-capitalize">{!! $category->translation->name !!}</p>
             
         
           </div>
            @endforeach
            {!! $subCategories->links() !!}
    </div>
    </div>
</section>
<!-- /category-section -->

@endsection