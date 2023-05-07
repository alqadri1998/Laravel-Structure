var DatatableRemoteAjaxDemo = function () {
    var t = function () {
        var t = $(".manage-orders").mDatatable({
            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/orders-detail/"+id}},
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
                    {field: "id", title: "#",  width: 150},
                    {field: "item_status", title: "Status",  width: 150},
                    {field: "product_id", title: "Product Id",  width: 150},
                    {field: "name", title: "Name",  width: 150},
                    {field: "quantity", title: "Quantity",  width: 150},
                    {field: "extras", title: "Extras",  width: 150},
                    {field: "created_at", title: "Created At",  width: 150},
                    {field: "updated_at", title: "Updated At",  width: 150},
                    {field: "actions", title: "Action",  width: 150}
                ]
        });
        t.on('m-datatable--on-layout-updated', function(params){
            $('.status-record-button').on('click', function(e){
                var id = $(this).data('id');
                var status = $(this).data('status');
                var url = window.Laravel.baseUrl+"order-detail/"+id+"/status/"+status;
                swal({
                        title: "Are you sure  ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        showLoaderOnConfirm: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                type: 'get',
                                url: url,
                            })
                                .done(function(res){
                                    if (res == 'failed'){
                                        toastr.error("payment did not refund for product!");
                                        t.reload();
                                        swal.close();
                                        location.reload();

                                    }
                                    if (res == 'canceled'){
                                        toastr.success("Order canceled successfully!");
                                        t.reload();
                                        swal.close()
                                    }
                                    if (res == 'completed'){
                                        toastr.success("Order completed successfully!");
                                        t.reload();
                                        swal.close()
                                    }
                                    if (res == 'status'){
                                        toastr.success("status change successfully!");
                                        swal.close()
                                        location.reload();
                                    }
                                    if (res == ''){
                                        toastr.success("status change successfully!");
                                        swal.close()
                                        location.reload();
                                    }
                                })
                                .fail(function(res){ toastr.success("item status changed successfully!"); t.reload(); });
                        } else {
                            swal("Cancelled", "Your  Request is Cancelled", "error");
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
    DatatableRemoteAjaxDemo.init()




});