
<!-- Stop & Go breadcrumb-banner -->
<section class="breadcrumbs-sec">
   <div class="banner breadcrumbs-sec-inner">
      <div class="container">
         <div class="banner-box">
            <h1 class="primary-headline">
               {!! $breadcrumbTitle !!}
            </h1>
         </div>
      </div>
   </div>


<div class="navigate-sec" id="scroll-to-breadcrumbs">
   <div class="container">
      <div class="navigate d-flex justify-content-between align-items-center flex-wrap">
         <div class="breadcrumbs-links">
            <ul class="breadcrumb mb-0 bg-light p-0">
               <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{route('front.index')}}">Home</a></li>
               <li class="breadcrumb-item px-3">></li>
              @foreach($breadcrumbs as $url => $bc)
                  @if(!$loop->last)
                     <li class="breadcrumb-item"><a class="breadcrumb-link" href="{!! $url !!}">{!! $bc['title'] !!}</a></li>
                     <li class="breadcrumb-item px-3">></li>
                  @else
                     <li class="breadcrumb-item"><a class="breadcrumb-link" href="{!! $url !!}">{!! $bc['title'] !!}</a></li>
                  @endif
                     @endforeach
            </ul>
         </div>
         <div class="breadcrumbs-desc ">
            <p class="desc mb-0">
               We are here to provide 100% services to our customer
            </p>
         </div>
      </div>
   </div>
</div>
</section>

<!--/ Stop & Go breadcrumb-banner -->

@push('script-page-level')
<script>
   $(document).ready(function (){
      var page = $("html, body");

      page.animate({
         scrollTop: $('#scroll-to-breadcrumbs').offset().top
      }, '100000');

      page.on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function(){
         page.stop();
      });
   });

</script>
@endpush