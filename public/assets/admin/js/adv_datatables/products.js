var DatatableRemoteAjaxDemo = function () {
        var t = function () {
            var t = $(".manage-products").mDatatable({
                data: {
                    type: "remote",
                    source: {read: {url: window.Laravel.baseUrl+"list/products"}},
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
                        {field: "id", title: "#",  width: 20 },
                        {field: "title", title: "Title",  width: 150},
                        {field: "price", title: "Price",  width: 50},
                        {field: "category", title: "Category",  width: 150},
                        {field: "quantity", title: "Quantity",  width: 70},
                        {field: "discount", title: "Discount",  width: 150},
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
                                swal.close()
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
                    var elem = $(this).children(':nth-child(8)').find('a');
                    if (elem.length==1) {
                        e.preventDefault();
                        e.stopPropagation();
                        window.location.href = $(elem[0]).attr('href');
                        return false;
                    }
                })

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
                dataTable.itemCode = '';
                dataTable.title = '';
                dataTable.createdAt = '';
                dataTable.updatedAt = '';
                dataTable.speedIndex = 0;
                $('#speedIndex').val(0);
                $('#brand').val(0);
                dataTable.brand = 0;
                dataTable.carModelId = 0;
                $('#carModelId').val(0);
                $('#vehicle').val(0);
                dataTable.vehicle = 0;
                dataTable.size = '';
                dataTable.season = '';
                $('#season').val('');
                dataTable.trashedPages=null;
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


