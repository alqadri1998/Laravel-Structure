{{--{!! dd($product->favorites) !!}--}}
<div class="flip-card mx-auto">
  
    <div class="prod-img-box card-border h-border">
        <div class="flip-card-inner">
            <div class="flip-card-front d-flex justify-content-center align-items-center">
                <div class="slider-item">
                    <a href="{{route('front.product.detail',['slug' => $product->slug])}}">
                        <img src="{{imageUrl(url($product->image),262,284,95,3)}}" alt="{!! $product->translation->title !!}" class="d-block m-auto img-fluid"></a>
                        <div class="pos">
                    @if($user && count($product->favorites)> 0 )
                    <i class="fa fa-heart cursor-pointer no-clr" data-id="{!! $product->id !!}" id="un_favorite"></i>
                    @else

                    <i class="fa fa-heart-o heart-clr" data-id="{!! $product->id !!}" id="favorite"></i>
                    @endif
                    <div class="bars cursor-pointer">
                        <span></span><span></span><span></span>
                    </div>
                    </div>
                </div>
            </div>
            <div class="flip-card-back">
            <div class="pos">
                @if($user && count($product->favorites)> 0)
                <i class="fa fa-heart cursor-pointer no-clr" data-id="{!! $product->id !!}" id="un_favorite"></i>
                @else
                <i class="fa fa-heart-o heart-clr clr-change-k" data-id="{!! $product->id !!}" id="favorite"></i>
                @endif
                <div class="bars cursor-pointer">
                    <span></span><span></span><span></span>
                </div>
         

                <div class="see-info-share">
                    <span class="pr-5">
                        <a href="http://www.facebook.com/sharer.php?u={!! url()->current() !!}" target="_blank" class="same change-1  d-block">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/share?url={{url()->current()}}&amp;text={{$product->translation->title}}&amp;hashtags={{$product->translation->title}}" target="_blank" class="same  change-2 d-block my-1">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a alt="Whatsapp" href="https://wa.me/whatsappphonenumber/?text={!! url()->current() !!}" data-text="share"  target="_blank" class="same change-3 d-block my-1">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </span>
                </div>
                </div>
                <a href="{{route('front.product.detail',['slug' => $product->slug])}}">
                    <div class="flip-back">
                    <div class="module card-truncate">
                        <p class="pt-3 text-capitalize px-2 gothic-normel cpa p-color">{!! $product->translation->long_description !!}
                        </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
     
    </div>
 
    <div class="card-text text-uppercase pt-4 text-center">
        <h4 class="card-heading-clr gothic-normel latest-p-heading truncate">
            <a class="card-heading-clr gothic-normel latest-p-heading" href="{{route('front.product.detail',['slug' => $product->slug])}}">{!! $product->translation->title !!}</a>
        </h4>
        <div class="d-flex justify-content-center align-items-center">
        
            <p class="secondary-color gothic-bold px-2 latest-p-price">
                {!! ($product->offer == '1')?$currency.' '. getConvertedPrice($product->currency_id,$product->discount): $currency.' '.getConvertedPrice($product->currency_id,$product->price) !!}
            </p>
          
            @if($product->offer == '1')
            <del class="disc">
                <span class="gothic-bold px-2 cross-disc is-offer-m-top"> {{$currency.' '.getConvertedPrice($product->currency_id,$product->price)}}</span>
            </del>
            @endif
        </div>
        <form action="{!! route('front.cart.add') !!}" method="post">
            @csrf
            <input type="hidden" id="product_quantity" name="quantity" class="count-output"
                   value="1" readonly>
            <input type="hidden" name="product_id" value="{!! $product->id !!}">
            <button type="submit"
                    class="text-uppercase text-white text-center mt-btn-primary ml-0 customize-btn res">
                    <i class="fa fa-shopping-cart cart-icon mr-1" aria-hidden="true"></i>add to cart
            </button>
        </form>
{{--        <a href="{!! route('front.product.detail',['slug'=> $product->slug]) !!}" class="custom-card-btn mt-3 mb-3">--}}
{{--           Add To Cart--}}
{{--        </a>--}}
    </div>
 
</div>