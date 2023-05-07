@extends('front.layouts.app')
@section('content')
@include('front.common.breadcrumb')
<!-- edit-profile -->
<section class="edit-profile padding-to-sec">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-3">
                @include('front.dashboard.common.left-navbar')
            </div>
            <div class="col-12 col-md-12 col-lg-9 mt-md-5 mt-lg-0">
               @if(count($notifications)> 0 )
                    <div class="setting-btn">
                        <a href='javascript:void(0)' class="clear-mt clear_all"><i class="fas fa-times"></i> {!! __('Clear All') !!}</a>
                    </div>
                @endif
                <div class="all-notifications-mt-mra">
                    <div class="row">
                        <div class="col-md-12">
                            @forelse($notifications as $key =>  $notification)
                                @php
                                    $orderId =  json_decode($notification->extras);

                                @endphp
                            @if(!isset($orderId->order_id))
                                    {!! $orderId->order_id = ''; !!}
                                @endif


                                <div class="d-flex align-items-center justify-content-between p">
                                    @if($orderId->order_id != '')
                                        <a href="{!! route('front.dashboard.order.detail',$orderId->order_id) !!}" class="dropdown-item border-top px-2 px-sm-4">
                                            @else
                                                <a href="javascript:void(0)" class="dropdown-item border-top px-2 px-sm-4">
                                                    @endif

                                                <div class="d-flex align-items-center w-100 not-text-area-mt">
                                        <div class="min-height-width">
                                        <img src="{{imageUrl(asset('assets/img/favicon.png'),53,53,95,3)}}" alt="cart">
                                        </div>
                                        <div class="text ml-2 w-100 po-relat">
                                            <p class="head-mt not-cl">{!! $notification->translation->title !!}</p>
                                            <p class="mb-0 detail pb-18">{!! $notification->translation->description!!}</p>
                                        </div>
                                    </div>
                                    </a>
                                    <div class="date d-flex flex-column align-items-end m-t-da">
                                        <small i18n>{!! $notification->time !!}</small>
                                        <button class="border-0 d-flex align-items-center justify-content-center mt-2 del_notification" data-id="{!! $notification->id !!}"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                @empty
                                <div class="col-md-6 col-xl-12 d-block m-auto pb-4">
                                    <div class="d-block m-auto">
                                        <div class="alert alert-danger">{!! __('No New Notification') !!}</div>
                                    </div>

                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                {!! $notifications->links() !!}
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
<!--/ edit-profile -->
@endsection
@push('script-page-level')
<script>
    $(document).ready(function () {
            $.ajax({
                headers: {
                    'Authorization': 'Bearer {!! $user['token'] !!}'
                },
                url: window.Laravel.apiUrl+"notification-seen",
                success: function (res) {
                    count();
                }
            });
        $(document).on('click','.clear_all',function () {
            swal({
                    title: "{!! __("Are you sure you want to delete this?") !!}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: window.Laravel.translations['yes'],
                    cancelButtonText: window.Laravel.translations['no'],
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            headers: {

                                'Authorization': 'Bearer {!! $user['token'] !!}'
                            },
                            url: window.Laravel.apiUrl+"notifications-clear",
                        })
                            .done(function(res){ toastr.success("");
                                location.reload();
                                swal.close()
                            })
                            .fail(function(res){ toastr.success("{!! __("All notifications deleted  successfully!") !!}"); swal.close()  });
                    } else {
                         swal.close();
                    }
                });

        });
        $(document).on('click','.del_notification',function () {
            let id =  $(this).attr('data-id');
            swal({
                    title: "{!! __("Are you sure you want to delete this?") !!}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText:  window.Laravel.translations['yes'],
                    cancelButtonText: window.Laravel.translations['no'],
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            headers: {

                                'Authorization': 'Bearer {!! $user['token'] !!}'
                            },
                            url: window.Laravel.apiUrl+"notification-delete/"+id,
                        })
                            .done(function(res){ toastr.success("{!! __("You Have Deleted NOTIFICATION  Successfully!") !!}");
                                swal.close()
                                location.reload();
                            })
                            .fail(function(res){ toastr.success("{!! __("You have deleted inquiry successfully!") !!}"); swal.close()  });
                    } else {
                         swal.close();
                    }
                });


        })
        function count() {
            $.ajax({
                headers: {

                    'Authorization': 'Bearer {!! $user['token'] !!}'
                },
                url: window.Laravel.apiUrl+"notifications-count",
                success:function (res) {
                    $(".bell-span").text(res.data.collection.count);
                }
            });

        }
    })
</script>
    @endpush
