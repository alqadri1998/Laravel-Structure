var DatatableRemoteAjaxDemo = function () {
        var t = function () {
            var t = $(".manage-credit-limits").mDatatable({
                data: {
                    type: "remote",
                    source: {read: {url: window.Laravel.baseUrl+"list/credit-limits"}},
                    pageSize: 10,
                    saveState: {cookie: !!0, webstorage: !!0},
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
                        {field: "full_name", title: "Full Name",  width: 150},
                        {field: "invoice_id", title: "Invoice Id",  width: 150},
                        {field: "credit_limit", title: "Credit Limit",  width: 150},
                        {field: "invoice_amount", title: "Invoice Amount",  width: 150},
                        {field: "created_at", title: "Created At",  width: 150}
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
            });
            $("#manage-product-search").on("submit", function (a) {
                a.preventDefault();
                var searchParams = $('#manage-product-search').serializeObject();

                t.setDataSourceQuery(searchParams),
                    t.load()
            });
            $("#page-reset").on("click", function (a) {
                a.preventDefault();
                var dataTable = t.getDataSourceQuery();
                dataTable.createdAt = '';
                dataTable.invoiceId = '';
                dataTable.admin_id = '';
                $('#admin_id').val('');
                $(this).closest('form').find("input[type=text]").val("");
                t.setDataSourceQuery(dataTable);
                t.reload();




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