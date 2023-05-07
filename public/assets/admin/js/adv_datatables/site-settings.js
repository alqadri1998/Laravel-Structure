DatatableRemoteAjaxDemo = function () {
    var t = function () {
        var t = $(".manage-settings").mDatatable({
            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/site-settings"}},
                pageSize: 10,
                saveState: {cookie: false, webstorage: false},
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
                    {field: "key", title: "Key",  width: 300},
                    {field: "value", title: "Value",  width: 450},
                    {field: "actions", title: "Action",  width: 150}
                ]
        });
        $("#manage-setting-search").on("submit", function (a) {
            a.preventDefault();
            var searchParams = $('#manage-setting-search').serializeObject();
            t.setDataSourceQuery(searchParams);
            t.load();
        });
        $("#setting-reset").on("click", function (a) {
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
                console.log(url);
                swal({
                        title: "Are You Sure?",
                        text: "If you delete, it will be deleted permanently.",
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
                                .done(function(res){ swal.close(); toastr.success("Record deleted successfully!"); t.reload(); })
                                .fail(function(res){ toastr.error("Something went wrong, please refresh."); });
                        } else {
                            swal("Cancelled", "No action taken.", "info");
                        }
                    });
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

