var DatatableRemoteAjaxDemo = function () {
        var t = function () {
            var t = $(".manage-delivery-types").mDatatable({
                data: {
                    type: "remote",
                    source: {read: {url: window.Laravel.baseUrl+"list/delivery-types"}},
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
                        {field: "title", title: "Title",  width: 150},
                        {field: "short_key", title: "Short Key",  width: 150},
                        {field: "created_at", title: "Created At",  width: 150},
                        {field: "actions", title: "Action",  width: 150}
                    ]
            });


            a = t.getDataSourceQuery();
            $("#manage-delivery-search").on("submit", function (a) {
                a.preventDefault();
                var searchParams = $('#manage-delivery-search').serializeObject();

                t.setDataSourceQuery(searchParams),
                    t.load()
            });
            $("#page-reset").on("click", function (a) {
                a.preventDefault();
                var dataTable = t.getDataSourceQuery();
                dataTable.title = '';
                dataTable.createdAt = '';
                dataTable.updatedAt = '';
                dataTable.deletedAt = '';
                $(this).closest('form').find("input[type=text]").val("");
                t.setDataSourceQuery(dataTable);
                t.load()
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