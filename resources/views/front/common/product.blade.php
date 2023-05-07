
<div class="row tyres-detail-row mx-0">
    
        @if(!is_null($product->promotion))
        <div class="col-12 px-0 promotion-col">
            <p class="buy-three-text">
                {{$product->promotion->translation->title}}
            </p>
        </div>
        @endif
        <div class="col-12 col-md-3 tyre-img-col">
            <a class="card-link" href="{{route('front.product.detail', $product->slug)}}">
            <div class="img-block">
                <div class="brand-logo">
                <img src="{{imageUrl(url($product->brand->image),90,30,100,1)}}" alt="tyre-01"
                    class="img-fluid tyre-img">
                </div>
{{--                <img src="{{imageUrl($product->image,104,110,100,1)}}" alt="tyre-01"--}}
                <img src="{{$product->image}}" alt="tyre-01" style="height: 104px;"
                    class="img-fluid tyre-img">
            </div>
            </a>
        </div>
        <div class="col-12 col-md-7 center-col">
        <a class="card-link" href="{{route('front.product.detail', $product->slug)}}">
            <div class="center-block">
                <div class="price-name-block d-flex justify-content-between">
                    <div class="name-desc align-self-center">
                        <p class="tyre-name">
                            {{$product->translation->title}}<br>
                            @forelse($product->subAttributes as $attribute)
                                @if($attribute->name == 'Width'){{$attribute->value}}@endif
                            @empty
                            @endforelse
                            /
                            @forelse($product->subAttributes as $attribute)
                                @if($attribute->name == 'Height'){{$attribute->value}}@endif
                            @empty
                            @endforelse

                            @forelse($product->subAttributes as $attribute)
                                @if($attribute->name == 'RIM'){{$attribute->value}}@endif
                            @empty
                            @endforelse

                            @forelse($product->subAttributes as $attribute)
                                @if($attribute->name == 'Load/Speed Index'){{$attribute->value}}@endif
                            @empty
                            @endforelse

                            @forelse($product->subAttributes as $attribute)
                                @if($attribute->name == 'Pattern'){{$attribute->value}}@endif
                            @empty
                            @endforelse

                            <br>
                            {{$product->year}}
                        </p>
                    </div>
                    <div class="price-block">
                        <h3 class="price">
                            AED {{$product->price}}
                        </h3>
                    </div>
                    @if($product->vat == 1)
                    <p class="tyre-name d-md-none">
                        Incl. VAT Price per Tyre
                    </p>
                    @endif
                </div>
                <div class="country-name-block">
                    <h3 class="country-name">
                        @if($product->origin)
                            {{$product->origin->translation->title}}
                        @endif
                    </h3>
                </div>
            </div>
        </a>
        </div>
        <div class="col-12 col-md-2 last-col">
            <form action="{!! route('front.cart.add') !!}" id="buy-now-form-{{$product->slug}}" method="post" class="h-100 d-flex flex-column">
                @csrf
                <div class="counter-cart-icon-sm h-100">
                <div class="counter">
                    <a id="quantity-up-{{$product->slug}}" href="javascript:void(0)"><i class="fas fa-chevron-up"></i></a>
                    <a id="quantity-down-{{$product->slug}}" href="javascript:void(0)"><i class="fas fa-chevron-down"></i></a>
                    <span id="quantity-number-{{$product->slug}}" class="number">1</span>
                    <input type="hidden" id="product_quantity-{{$product->slug}}" name="quantity" class="count-output"
                        value="1" readonly>
                    <input type="hidden" name="product_id" value="{!! $product->id !!}">
                </div>
                <div class="cart-icon">
                    @if(isset($userData))
                    <a id="add-to-cart-{{$product->slug}}"  href="javascript:void(0)"><i class="fas fa-shopping-cart"></i></a>
                    @else
                        <a id="add-to-cart-button-{{$product->slug}}"  href="javascript:void(0)"><i class="fas fa-shopping-cart"></i></a>
{{--                        <button type="submit" id="add-to-cart-{{$product->slug}}"><i class="fas fa-shopping-cart"></i></button>--}}
                    @endif
                </div>
                </div>                

            <div class="buy-now-btn">
                <button type="submit" class="btn btn--primary btn--animate btn-round">Buy Now</button>
            </div>
            </form>

        </div>
    
</div>


@push('script-page-level')

<script>

    $('#buy-now-form-{{$product->slug}}').on('submit', function (event){
        event.preventDefault();
        let quantity = $("#product_quantity-{{$product->slug}}").val();
        let product_id = "{{$product->id}}"
        window.location  = window.Laravel.baseUrl + 'add-to-cart/'+ product_id +'/'+ quantity;
    });


    $('#add-to-cart-button-{{$product->slug}}').on('click', function (){
        let quantity = $("#product_quantity-{{$product->slug}}").val();
        let product_id = "{{$product->id}}"
        // console.log(window.Laravel.baseUrl + 'add-to-cart/'+ product_id +'/'+ quantity)
        window.location  = window.Laravel.baseUrl + 'add-to-cart/'+ product_id +'/'+ quantity;
    })

    $("#quantity-up-{{$product->slug}}").on("click", function (){
        var currentQuantity = $("#quantity-number-{{$product->slug}}").text()
        var updatedQuantity = Number(currentQuantity) + Number(1);
        if (updatedQuantity <= {{$product->quantity}}){
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

        @if(isset($userData))
    $("#add-to-cart-{{$product->slug}}").on("click", function (){
            var currentQuantity = $("#quantity-number-{{$product->slug}}").text()
            var product = {{$product->id}};
            console.log(window.Laravel.baseUrl + 'add-to-cart/' + product +'/'+ currentQuantity)
            $.ajax({
                url: window.Laravel.baseUrl + 'add-to-cart/' + product +'/'+ currentQuantity,
                success: function(data) {
                    console.log(data.message == 'Unauthenticated')
                    if (data.message == 'Unauthenticated'){
                        toastr.error('Please login')
                        window.location = window.Laravel.baseUrl + 'login'
                    }else{
                        toastr.success(data)
                        $.ajax({
                            headers: {

                                'Authorization': 'Bearer {!! $user['token'] !!}'
                            },
                            url: window.Laravel.apiUrl+"user/cart-count/"+ {{$user['id']}},
                            success:function (res) {
                                $("#cartCount").text(res.data.collection.count);
                            }
                        });
                    }

                },
                error: function(data) {
                    window.location = window.Laravel.baseUrl + 'login'
                }
            });

        });
        @endif

</script>
@endpush
