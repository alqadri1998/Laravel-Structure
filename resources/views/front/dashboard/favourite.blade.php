
@extends('front.layouts.app')
@section('content')
@include('front.common.breadcrumb')
<!-- favourit -->
<section class="favourit padding-to-sec">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-3">
                @include('front.dashboard.common.left-navbar')
            </div>
            <div class="col-md-12 col-lg-9 mt-4 mt-lg-0">
        <div class="row">
        @forelse($products->shuffle() as $key => $product)
          <div class="col-md-6 col-xl-4 pb-4">
                <div class="d-block m-auto">
                @include('front.common.product',['product' => $product])
                </div>
          </div>
            @empty
                <div class="col-md-12 col-xl-12 d-block m-auto pb-4">
                    <div class="d-block m-auto">
                        <div class="alert alert-danger"> {!! __('Favorites List is empty') !!}!</div>
                    </div>

                </div>
            @endforelse
        </div>
      </div>
        </div>
    </div>
</section>
<!-- /favourit -->
@endsection
@push('script-page-level')
<script>
    $(document).ready(function () {
        $('.see-info-share').hide();
        $('.bars').click(function () {
            $('.see-info-share').toggle();
        })
        $(document).on("click", '#favorite',function () {
            let user = "{{$user['id']}}";
            let id = $(this).attr('data-id');
            if (user){
                $.ajax({
                    url : window.Laravel.baseUrl+'favorites/'+id,
                    success:function (data) {
                        let  fav =$("<i class='fa fa-heart secondary-color' id='un_favorite' data-id='"+id+"' ></i>")
                        $("#favorite_product").empty();
                        $("#favorite_product").append(fav);
                        toastr.success("{!! __('Product Added To Favorites') !!}");
                        window.location = window.Laravel.baseUrl+'favorites'
                    },
                    error: function (data) {
                        window.location = window.Laravel.baseUrl+'login'
                    }
                });
            }
            else{
                window.location = window.Laravel.baseUrl+'login'
            }


        });
        $(document).on('click', '#un_favorite',function () {
            console.log(1);
            let id = $(this).attr('data-id');
            $.ajax({
                url : window.Laravel.baseUrl+'un-favorites/'+id,
                success:function (data) {
                    let  fav =$("<i class='fa fa-heart-o' id='favorite' data-id='"+id+"' ></i>")
                    $("#favorite_product").empty();
                    $("#favorite_product").append(fav);
                    toastr.success("{!! __('Product Removed From Favorites') !!}");
                    location.reload();
                },
                error: function (data) {
                    toastr.error('something went wrong');

                }

            })

        });
    });

</script>
@endpush