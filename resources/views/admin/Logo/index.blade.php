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
                        swal.close();
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
                      Partner Images
                        <small>
                            Here You Can Add or Delete Logo Images
                        </small>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <form action="{!! route('admin.partners.store') !!}" method="POST" enctype="multipart/form-data" id="product-images-form">
                            {!! csrf_field() !!}
                            <label class="choose-image">
                               Choose file
                            <input type="file" name="images[]" id="product-image-input" multiple accept="image/*">
                            </label>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body padding-to-logo">
            <div class="container">
                <div class="row">
                    @forelse($logoImages as $key=>$logo)
                        <div class="col-sm-3 card m-2 card-width-fixed">
                            <a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button trash-right"
                               href="javascript:{};" data-url="{!! route('admin.partners.destroy', $logo->id ) !!}"><i class="fa fa-trash"></i></a>
                               <div class="d-flex justify-content-center align-items-center">
                            <img src="{!! imageUrl(url($logo->image), 165,74,95,3) !!}" alt="" class="img-fluid">
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

