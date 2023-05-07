var DatatableRemoteAjaxDemo = function () {
        var t = function () {
            var t = $(".manage-orders").mDatatable({
                data: {
                    type: "remote",
                    source: {read: {url: window.Laravel.baseUrl+"list/orders/"+status}},
                    pageSize: 10,
                    saveState: {cookie: !0, webstorage: !0},
                    serverPaging: !0,
                    serverFiltering: !0,
                    serverSorting: !0,

                },
                layout: {theme: "default", class: "", scroll: !1, footer: !1},
                sortable: false,
                ordering: false,
                filterable: !1,
                pagination: !0,
                columns:
                    [
                        {field: "id", title: "#",  width: 30},
                        {field: "name", title: "Name",  width: 150},
                        {field: "order_number", title: "Order Number",  width: 150},
                        {field: "payment_method", title: "Payment Method",  width: 150},
                        // {field: "amount", title: "Amount",  width: 150},
                        // {field: "currency", title: "currency",  width: 150},
                        {field: "total_amount", title: "Total Amount",  width: 150},
                        {field: "coupon_code", title: "Coupon Code ",  width: 150},
                        // {field: "coupon_percent", title: "Percent",  width: 150},
                        {field: "created_at", title: "Order Placed At",  width: 170},
                        {field: "actions", title: "Action",  width: 150}
                    ]
            });
            t.on('m-datatable--on-layout-updated', function(params){
                $('.delete-record-button').on('click', function(e){
                    var url = $(this).data('url');
                    swal({
                            title: "Are you sure to delete this ?",
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
                                 swal.close();
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
            t.on('m-datatable--on-layout-updated' , function () {
                $('.change-status').on('click', function(e){
                    var url = $(this).data('url');
                    swal({
                            title: "Are you sure you want to change status to Delivered?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                if(url) {
                                    document.location.href =url;
                                }
                            } else {
                                swal("Cancelled", "Your Order Status is safe", "error");
                            }
                        });
                })
            })
            $("#manage-product-search").on("submit", function (a) {
                a.preventDefault();
                var searchParams = $('#manage-product-search').serializeObject();

                t.setDataSourceQuery(searchParams),
                    t.load()
            });
            $("#page-reset").on("click", function (a) {
                a.preventDefault();
                var dataTable = t.getDataSourceQuery();
                dataTable.order_number = '';
                dataTable.order_status = '';
                dataTable.createdAt = '';
                dataTable.updatedAt = '';
                dataTable.payment_method = '';
                $(this).closest('form').find("input[type=text]").val("");
                t.setDataSourceQuery(dataTable);
                t.load()
            });
        };
        return {
            init: function () {
                t()
            }
        }
    }();
    jQuery(document).ready(function () {
        console.log(status);
        DatatableRemoteAjaxDemo.init()




    });