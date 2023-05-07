<div class="mt-3">


    <div class="slider-item d-flex align-items-center">
    <div class="shade">
    <a href="{!! route('front.sub-categories',$category->id) !!}">
    <div class="slider-item d-flex align-items-center justify-content-center">
   
      <div class="category-img">
      <img src="{{imageUrl(url($category->image),165,165,100,3)}}" alt="{!! $category->translation->name !!}" class="d-block m-auto img-fluid">
      </div>
      
    </div>
    </a>
    </div>
    </div>

  <p class="pt-3 text-capitalize truncate">{!! $category->translation->name !!}</p>
</div>