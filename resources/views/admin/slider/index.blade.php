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
                            .fail(function(res){ toastr.success("Something went wrong."); location.reload();});
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
                       Slider Images
                        <small>
                            Here You Can Add or Delete slider Images
                        </small>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <span class=" mt-4 pt-1 d-inline-block mx-4 gothic-normel font-weight-bold" style="font-size: 13px;color:#000;text-transform:capitalize;    color: #256ab7;">Add slider image</span>
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <form action="{!! route('admin.slider.store') !!}" method="POST" enctype="multipart/form-data" id="product-images-form">
                            {!! csrf_field() !!}
                            <label class="choose-image mt-3">
                               Choose file
                            <input type="file" name="images[]" id="product-image-input" multiple accept="image/*">
                            </label>
                            <p class="mx-0 text-danger smaller-font-size">Recommended size 1920 x 600</p>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="container mt-5">
                <div class="row">
                    @php
                    $count = 0;
                    @endphp
                    @forelse($sliderImages as $key=>$slider)
                        <div class="col-sm-12 card  d-block p-0 mb-3">
                            <span class="index-styling ">
                            {!! $count = $count+1 !!}
                            </span>
                            <a  class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button trash-right"
                               href="javascript:{};" data-url="{!! route('admin.slider.destroy', $slider->id ) !!}"><i class="fa fa-trash"></i></a>
                               <div class="d-flex justify-content-center align-items-center mt-5 admin-slider">
                            <img src="{!! imageUrl(url($slider->image)) !!}" alt="" class="img-fluid">
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

