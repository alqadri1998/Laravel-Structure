@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script>
        $(document).ready(function () {
            // $('#car-image-input').hide();
            $('#add-product-image').on('click', function () {
                $('#product-image-input').click();
            });
        });
        $(document).on('change', '#product-image-input', function () {
            $('#product-images-form').submit();
        });

        $('.delete-record-button').on('click', function(e){
            var url = $(this).data('url');
            swal({
                    title: "Are You Sure You Want To Delete This?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Delete",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: 'delete',
                            url: url,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            }
                        })
                            .done(function(res){ toastr.success("You have deleted inquiry successfully!"); location.reload(); })
                            .fail(function(res){ toastr.success("You have deleted inquiry successfully!"); location.reload();  });
                    } else {
                        swal("Cancelled", "Your imaginary file is safe", "error");
                    }
                });
        });
    </script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Product Images
                        <small>
                            Here You Can Add or Delete Product Images
                        </small>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <form action="{!! route('admin.products.product-images.store',$productId) !!}" method="POST" enctype="multipart/form-data" id="product-images-form">
                            {!! csrf_field() !!}
                            <input type="file" name="images[]" id="product-image-input" multiple accept="image/*">
                            <input type="hidden" name="product_id" value="{!! $productId !!}">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="container">
                <div class="row">
                    @forelse($productImages as $key=>$product)
                        <div class="col-sm-4 card">
                            <a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button"
                               href="javascript:{};" data-url="{!! route('admin.products.product-images.destroy',['product' => $productId,'product_image' => $product->id] ) !!}"><i class="fa fa-trash"></i></a>
                               <div class="d-flex justify-contrent-center align-items-center">
                            <img src="{!! imageUrl(url($product->image), 262, 284, 100, 3) !!}" alt="" class="img-fluid">
                            </div>
                        </div>
                    @empty
                        No Record Found
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

