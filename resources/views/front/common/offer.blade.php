<!-- <div class="col-12 col-md-6">
    <div class="offer-parent text-uppercase mb-5">
        <div class="row">
            <div class="col-12 col-md-8">
                <h4 class="offer-heading gothic-normel pb-3">{!! $offer->translation->title !!}</h4>
                <p class="offer-para pb-3 text-lowercase">{!! $offer->translation->short_description !!}</p>
                <h5 class="secondary-color pb-3 gothic-bold">{!!$currency.' '.getConvertedPrice($offer->currency_id,$offer->price)!!}
                </h5>
                <a href="{!! route('front.offer.detail',['slug'=> $offer->slug]) !!}" class="offer-link gothic-bold card-heading-clr">shop now</a>
            </div>

            <div class="col-md-4">
                <div class="custom-pos">
                    <img src="{{imageUrl(url($offer->image),'263','230',95,3)}}" alt="{!! $offer->translation->title !!}" class="img-fluid">
                </div>
f-w-p 
            </div>
        </div>
    </div>
</div> -->
<div class="col-12 col-md-6 pb-xs-5 pb-lg-0 on-475-m">
           <div class="offer-box d-flex flex-wrap">
                <div class="in-text">
                        <h4 class="offer-heading gothic-bold mb-3 truncate">{!! $offer->translation->title !!}</h4>
                        <div class="f-w-para text-multiline-truncate">
                        <p class="offer-para pb-3 text-lowercase">{!! $offer->translation->short_description !!}</p>
                        </div>
                        <h5 class="secondary-color pb-3 pt-3 gothic-bold offer-h5">{!!$currency.' '.getConvertedPrice($offer->currency_id,$offer->price)!!}</h5>
                        <a href="{{route('front.offer.detail',['slug' => $offer->slug])}}" class="d-block offer-link gothic-bold card-heading-clr text-uppercase hover-c-i">{!! __("shop now") !!}</a>
                     
                   </div>
                  <div class="f-text d-flex justify-content-end align-items-center">
                  <img src="{{imageUrl(url($offer->image),263,230,95,3)}}" alt="{!! $offer->translation->title !!}" class="img-fluid max-height">
                  </div>
           </div>
        </div>