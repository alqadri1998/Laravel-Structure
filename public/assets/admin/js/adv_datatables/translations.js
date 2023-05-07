DatatableRemoteAjaxDemo = function () {
    var t = function () {
        var t = $(".manage-translations").mDatatable({
            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/translations"}},
                pageSize: 20,
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
                    {field: "key", title: "Key",  width: 150},
                    {field: "en_value", title: "English Value",  width: 150},
                    {field: "ar_value", title: "Arabic Value",  width: 150},
                    {field: "actions", title: "Action",  width: 150}
                ]
        });
        $("#manage-leads-search").on("submit", function (a) {
            a.preventDefault();
            var searchParams = $('#manage-leads-search').serializeObject();
            t.setDataSourceQuery(searchParams),
                t.load()
            datatable[query][key] = "";
        });
        $("#reset").on("click", function (a) {
            a.preventDefault();
            var dataTable = t.getDataSourceQuery();
            dataTable.key = '';
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