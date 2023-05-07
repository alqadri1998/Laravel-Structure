var DatatableRemoteAjaxDemo = function () {
    var t = function () {
        var t = $(".manage-categories").mDatatable({
            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/branches"}},
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
                    {field: "id", title: "#",  width: 30 },
                    {field: "title", title: "Title",  width: 150},
                    {field: "address", title: "Address",  width: 150},
                    {field: "phone", title: "Phone",  width: 150},
                    {field: "timings", title: "Timings",  width: 150},
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