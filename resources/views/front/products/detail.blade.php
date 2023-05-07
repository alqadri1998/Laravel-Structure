@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <!-- Tyre Details html  -->
    <section class="tyre-detail spacing">
        <div class="container">
            <div class="row tyre-detail-row">
                <div class="col-md-4 col-lg-5 cols">
                    <div class="img-col">
{{--                        <img class="img-fluid" src="{{imageUrl($product->image, 399,445, 100, 1)}}"--}}
                        <img class="img-fluid" src="{{$product->image}}"
                             alt="tyre-detail-img">
                    </div>
                </div>
                <div class="col-md-8 col-lg-7 cols">
                    <div class="tyre-detail-col tyre-desc-col">
                        <div class="tyre-logo">
                            <img class="img-fluid" src="{{imageUrl($product->brand->image, 286,51, 100, 1)}}"
                                 alt="davanti-tyres-logo">
                        </div>
                        <div class="name-model">
                            <p class="tyre-name">
                                {{$product->translation->title}}
                            </p>
                            <p class="model">
                                {{$product->sku}}
                            </p>
                        </div>
                        <div class="tyre-desc-&-bottom-area">
                            <div
                                    class="tyre-types-inner-row d-flex justify-content-between align-items-center flex-wrap">
                                <div class="type-box mb-5">
                                    <ul class="types-ul mb-0">
                                        @foreach($attributes as $key => $attribute)
                                            <li class="type-items">
                                                {{isset($attribute['translation']) ? $attribute['translation']->name: 'Not provided'}}:
                                            </li>
                                        @endforeach
                                        <li class="type-items">
                                            Origin:
                                        </li>
                                        <li class="type-items">
                                            Manufacture Year:
                                        </li>
                                    </ul>
                                </div>
                                <div class="type-value-box mb-5">
                                    <ul class="types-value-ul mb-0">

                                        @foreach($attributes as $key => $attribute)
{{--                                            @if($attribute['id'] == 137)--}}
{{--                                                @dd($attribute)--}}
{{--                                                @dd($attribute['subAttributes'][0]['translation']->name)--}}
{{--                                                @endif--}}
                                            <li class="type-items">
                                                {{isset($attribute['subAttributes']) && !empty($attribute['subAttributes'][0]['translation']->name) ? $attribute['subAttributes'][0]['translation']->name: 'Not provided'}}
                                            </li>
                                        @endforeach
                                        <li class="type-items">
                                            @if(isset($product->origin)){{$product->origin->translation->title}}@else
                                                - @endif
                                        </li>
                                        <li class="type-items">
                                            @if(isset($product->year)){{$product->year}}@else - @endif
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <h3 class="price">
                                {{$currency.' '.getConvertedPrice(1,$product->price)}}
                            </h3>
                            @if($product->vat == 1)
                                <p class="price-b">
                                    Incl. VAT Price
                                </p>
                            @endif

                            <form action="{!! route('front.cart.add') !!}" id="buy-now-form-{{$product->slug}}" method="post">
                                @csrf
                                <div class="btn-and-counter d-flex justify-content-between align-items-center flex-wrap">
                                    <input type="hidden" id="product_quantity-{{$product->slug}}" name="quantity"
                                           class="count-output"
                                           value="1" readonly>
                                    <input type="hidden" name="product_id" value="{!! $product->id !!}">
                                    <div class="buy-now-btn">
                                        <button type="submit" class="btn btn--primary btn--animate">Buy Now</button>
                                    </div>
                                    <div class="quantity">
                                        <ul class="quantity-ul d-inline-flex">
                                            <li class="list-items">
                                                <button type="button" id="quantity-up-{{$product->slug}}"
                                                        class="increse-decrease-btn"><i class="fas fa-chevron-up"></i>
                                                </button>
                                            </li>
                                            <li class="list-items">
                                                <button type="button" id="quantity-number-{{$product->slug}}"
                                                        class="increse-decrease-btn border-x">1
                                                </button>
                                            </li>
                                            <li class="list-items">
                                                <button type="button" id="quantity-down-{{$product->slug}}"
                                                        class="increse-decrease-btn"><i class="fas fa-chevron-down"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-page-level')

    <script>
        $("#quantity-up-{{$product->slug}}").on("click", function () {
            var currentQuantity = $("#quantity-number-{{$product->slug}}").text()
            var updatedQuantity = Number(currentQuantity) + Number(1);
            if (updatedQuantity <= {{$product->quantity}}) {
                $("#quantity-number-{{$product->slug}}").text(updatedQuantity);
                $("#product_quantity-{{$product->slug}}").val(updatedQuantity);
            }
        });

        $("#quantity-down-{{$product->slug}}").on("click", function () {
            var currentQuantity = $("#quantity-number-{{$product->slug}}").text()
            var updatedQuantity = Number(currentQuantity) - Number(1);
            if (updatedQuantity >= 1) {
                $("#quantity-number-{{$product->slug}}").text(updatedQuantity);
                $("#product_quantity-{{$product->slug}}").val(updatedQuantity);
            }
        });

        $('#buy-now-form-{{$product->slug}}').on('submit', function (event){
            event.preventDefault();
            let quantity = $("#product_quantity-{{$product->slug}}").val();
            let product_id = "{{$product->id}}"
            window.location  = window.Laravel.baseUrl + 'add-to-cart/'+ product_id +'/'+ quantity;
        });


    </script>
@endpush