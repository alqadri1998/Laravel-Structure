@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection



@push('script-page-level')
    <script>
        $('.delete-record-button').on('click', function(e){
            var url = $(this).data('url');
            swal({
                    title: "Are you sure to delete this?",
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
    <!-- edit-profile -->
    <section class="edit-profile">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(count($notifications)> 0 )
                        <div class="setting-btn">
                            <a href='javascript:void(0)' class="clear-mt clear_all"><i class="fas fa-times"></i> Clear All</a>
                        </div>
                    @endif
                    <div class="all-notifications-mt-mra">
                        <div class="row">
                            <div class="col-md-12">
                                @forelse($notifications as $key =>  $notification)
                                    @php
                                    $orderId =  json_decode($notification->extras);


                                    @endphp
                                        <div class="d-flex align-items-center justify-content-between dropdown-item border-top px-2 px-sm-4">
                                            <a href="{!! route('admin.orders.order-detail',$orderId->order_id) !!}" class="dropdown-item border-top px-2 px-sm-4">

                                            <div class="d-flex align-items-center w-100 not-text-area-mt">
                                                <img src="{{asset('assets/img/favicon.png')}}" alt="sdtyres">
                                                <div class="text ml-2 w-100">
                                                    <p class="head-mt">{!! $notification->translation->title !!}</p>
                                                    <p class="mb-0 detail">{!! $notification->translation->description!!}</p>
                                                </div>
                                            </div>
                                            </a>

                                            <div class="date d-flex flex-column align-items-end ">
                                                <small i18n>{!! $notification->time !!}</small>
                                                <button class="border-0 d-flex align-items-center justify-content-center mt-2 del_notification" data-id="{!! $notification->id !!}"><i class="fa fa-times" aria-hidden="true"></i></button>
                                            </div>
                                        </div>

                                @empty
                                    <div class="col-md-6 col-xl-4 d-block m-auto pb-4">
                                        <div class="d-block m-auto">
                                            <div class="alert alert-danger">No New Notification</div>
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
                    'Authorization': 'Bearer {!! $admin['token'] !!}'
                },
                url: window.Laravel.apiUrl+"admin/notification-seen",
                success: function (res) {
                    count();
                }
            });
            $(document).on('click','.clear_all',function () {
                swal({
                        title: "Are You Sure You Want To Delete This?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        showLoaderOnConfirm: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                headers: {

                                    'Authorization': 'Bearer {!! $admin['token'] !!}'
                                },
                                url: window.Laravel.apiUrl+"admin/notifications-clear",
                            })
                                .done(function(res){ toastr.success("All Notifications deleted  successfully!");
                                    swal.close();
                                    location.reload();
                                })
                                .fail(function(res){ toastr.success("All Notifications deleted successfully!"); swal.close()  });
                        } else {
                            swal.close();
                        }
                    });
            });
            $(document).on('click','.del_notification',function () {

                let id =  $(this).attr('data-id');
                swal({
                        title: "Are You Sure You Want To Delete This?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        showLoaderOnConfirm: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                headers: {

                                    'Authorization': 'Bearer {!! $admin['token'] !!}'
                                },
                                url: window.Laravel.apiUrl+"admin/notification-delete/"+id,
                            })
                                .done(function(res){ toastr.success("You have deleted notification successfully!");
                                    swal.close();
                                    location.reload();
                                })
                                .fail(function(res){ toastr.success("You have deleted notification successfully!"); swal.close()  });
                        } else {
                            swal.close();
                        }
                    });
            })
            function count() {
                $.ajax({
                    headers: {

                        'Authorization': 'Bearer {!! $admin['token'] !!}'
                    },
                    url: window.Laravel.apiUrl+"admin/notifications-count",
                    success:function (res) {
                        $(".bell-icon").text(res.data.collection.count);
                    }
                });

            }
        })
    </script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('myKey', {
            auth: {
                headers: {
                    {{--'X-CSRF-Token': '{{ csrf_token() }}',--}}
                    'calledFrom': 'admin',
                    'Authorization': 'Bearer '+'{{$admin['token']}}'
                }
            },
            wsHost: window.location.hostname,
            wsPort: 6001,
            authEndpoint: '/en/broadcasting/auth',
        });

        var channel = pusher.subscribe('private-sd-tyres-admin-'+{{$admin['id']}});
        channel.bind('pusher:subscription_succeeded', function(members) {
            console.log('Connected');
        });
        channel.bind('newNotificationEvent', function(data) {
            location.reload();
        });
    </script>

@endpush



