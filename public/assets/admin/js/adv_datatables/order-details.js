var orderId = $('#order_id').data('field-id');
var DatatableRemoteAjaxDemo = function () {



    var t = function () {
        var t = $(".manage-order-details").mDatatable({

            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/orders/"+orderId+"/order-details"}},  pageSize: 10,
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
                    {field: "store_title", title: "title",  width: 150},
                    {field: "product_name", title: "Product Title",  width: 150},
                    {field: "quantity", title: "Quantity",  width: 150},
                    {field: "amount", title: "Amount",  width: 150},
                    {field: "item_status", title: "Item Status",  width: 150},
                    {field: "actions", title: "Action",  width: 200}
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
                             swal.close();
                        }
                    });
            });
            $('.toggle-status-button').on('click', function(e) {
                console.log(1);
                var url = $(this).data('url');
                if (url.length > 0) {
                    $.ajax({
                        url: url,
                        type: 'Put',
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