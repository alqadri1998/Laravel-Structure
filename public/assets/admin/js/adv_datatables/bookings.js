var DatatableRemoteAjaxDemo = function () {
        var t = function () {
            var t = $(".manage-bookings").mDatatable({
                data: {
                    type: "remote",
                    source: {read: {url: window.Laravel.baseUrl+"admin/list/bookings"}},
                    pageSize: 10,
                    saveState: {cookie: !0, webstorage: !0},
                    serverPaging: !0,
                    serverFiltering: !0,
                    serverSorting: !0,

                },
                layout: {theme: "default", class: "", scroll: !1, footer: !1},
                sortable: !0,
                filterable: !1,
                pagination: !0,
                columns:
                    [
                        {field: "pickup_date", title: "pickup_date",  width: 150},
                        {field: "pickup_time", title: "pickup_time",  width: 150},
                        {field: "dropoff_date", title: "dropoff_date",  width: 150},
                        {field: "dropoff_time", title: "dropoff_time",  width: 150},
                        {field: "pickup_location", title: "pickup_location",  width: 150},
                        {field: "dropoff_location", title: "dropoff_location",  width: 150},
                        {field: "type", title: "type",  width: 150},
                        {field: "actions", title: "Action",  width: 150}
                    ]
            });
            t.on('m-datatable--on-layout-updated', function(params){
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
                                    .fail(function(res){ toastr.success("You have deleted inquiry successfully!"); t.reload();  });
                            } else {
                                swal("Cancelled", "Your imaginary file is safe", "error");
                            }
                        });
                });
                $('.toggle-status-button').on('click', function(e) {
                    var url = $(this).data('url');
                    if (url.length > 0) {
                        $.ajax({
                            url: url,
                            type: 'PUT',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            }
                        })
                            .done(function(res){ toastr.success("Your action is successfully!"); t.reload(); })
                            .fail(function(res){ toastr.success("Your action is successfully!"); t.reload(); });
                    }
                });
            });
        };
        return {
            init: function () {
                t()
            }
        }
    }();
    jQuery(document).ready(function () {
        DatatableRemoteAjaxDemo.init()
    });