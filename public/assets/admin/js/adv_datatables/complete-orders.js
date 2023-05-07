var DatatableRemoteAjaxDemo = function () {
        var t = function () {
            var t = $(".manage-complete-orders").mDatatable({
                data: {
                    type: "remote",
                    source: {read: {url: window.Laravel.baseUrl+"list/complete-orders"}},
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
                        {field: "delivery_note", title: "Delivery Note",  width: 150},
                        {field: "package_list", title: "Package List",  width: 150},
                        {field: "vat", title: "VAT Tax%",  width: 150},
                        {field: "vat_amount", title: "Total VAT Tax",  width: 150},
                        {field: "total_amount", title: "Total Amount",  width: 150},
                        {field: "complete_date", title: "Complete Date",  width: 150},
                        {field: "created_at", title: "Created At",  width: 150},
                        {field: "updated_at", title: "Updated At",  width: 150},
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

                $('.m-datatable__table tbody').on('click', 'tr', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var elem = $(this).children(':nth-child(10)').find('a');
                    if (elem.length==1) {
                        window.location.href = $(elem[0]).attr('href');
                    }
                    return false;
                })
            });
            t.on('m-datatable--on-layout-updated' , function () {
                $('.select_onchange').change(function () {
                    orderStatus=$(this).val();
                    swal({
                            title: "Are you sure to Change Status?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Change",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                if(orderStatus) {
                                    document.location.href =orderStatus;
                                }
                            } else {
                                swal("Cancelled", "Your imaginary file is safe", "error");
                            }
                        });
                })
            })
            $("#manage-complete-order-search").on("submit", function (a) {
                a.preventDefault();
                var searchParams = $('#manage-complete-order-search').serializeObject();

                t.setDataSourceQuery(searchParams),
                    t.load()
            });
            $("#page-reset").on("click", function (a) {
                a.preventDefault();
                var dataTable = t.getDataSourceQuery();
                dataTable.packageList = '';
                dataTable.deliveryNote = '';
                dataTable.createdAt = '';
                dataTable.updatedAt = '';
                dataTable.completeDate = '';

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