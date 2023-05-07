var DatatableRemoteAjaxDemo = function () {
    var t = function () {
        var t = $(".manage-subscriptions").mDatatable({
            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/subscriptions"}},
                pageSize: 10,
                saveState: {cookie: false, webstorage: false},
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
                    // {field: "id", title: "#", sortable: !1, width: 50, selector: {class: "m-checkbox--solid m-checkbox--brand"}, textAlign: "center"},
                    {field: "count", title: "#",  width: 30},
                    {field: "email", title: "Email",  width: 150},
                    {field: "updated_at", title: "Updated At",  width: 150},
                    // {field: "actions", title: "Action",  width: 150}
                ]
        });
        a = t.getDataSourceQuery();
        $("#manage-subscription-search").on("submit", function (a) {
            a.preventDefault();
            var searchParams = $('#manage-subscription-search').serializeObject();
            t.setDataSourceQuery(searchParams),
                t.load()
        });
        $("#subscription-reset").on("click", function (a) {
            a.preventDefault();
            var dataTable = t.getDataSourceQuery();
            dataTable.email = '';
            dataTable.createdAt = '';
            dataTable.updatedAt = '';
            dataTable.deletedAt = '';
            dataTable.subscriptionStatus = '';
            $("#show-subscription-status option:eq(0)").prop("selected", true);
            $(this).closest('form').find("input[type=text]").val("");
            t.setDataSourceQuery(dataTable);
            t.load()
        });

        $(".manage-subscriptions").on("m-datatable--on-check", function (e, a) {
            var l = t.setSelectedRecords().getSelectedRecords().length;
            var checkStatus = $('#show-trashed-subscriptions').is(':checked');
            if(checkStatus == true){
                $("#m_datatable_selected_subscription_restore").html(l), l > 0 && $("#m_datatable_group_action_form_subscription_restore").collapse("show")
            }else{
                $("#m_datatable_selected_subscription").html(l), l > 0 && $("#m_datatable_group_action_form_subscription").collapse("show")
            }
        }).on("m-datatable--on-uncheck m-datatable--on-layout-updated", function (e, a) {
            var l = t.setSelectedRecords().getSelectedRecords().length;
            var checkStatus = $('#show-trashed-subscriptions').is(':checked');
            if(checkStatus == true) {
                $("#m_datatable_selected_subscription_restore").html(l), 0 === l && $("#m_datatable_group_action_form_subscription_restore").collapse("hide")
            }else{
                $("#m_datatable_selected_subscription").html(l), 0 === l && $("#m_datatable_group_action_form_subscription").collapse("hide")
            }
        });
        $('#show-trashed-subscriptions').on('change', function(){
            $('#manage-subscription-search').submit();
            if ($(this).is(":checked")){
                $('#subscription-deleted-at').show(50,function(){
                    $('#subscription-created-at').hide('slow');
                    $('#subscription-updated-at').hide('slow');
                });
            }else{
                $('#subscription-deleted-at').hide(50,function(){
                    $('#subscription-created-at').show('slow');
                    $('#subscription-updated-at').show('slow');
                });
            }
        });
        $('#m_datatable_check_all_subscriptions').on('click', function(){
            var chkArray = [];

            /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
            $(".m-checkbox--solid input:checked").each(function() {
                chkArray.push($(this).val());
            });

            /* we join the array separated by the comma */
            var selected;
            selected = chkArray.join(',') ;

            /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
            if(selected.length > 0){

                swal({
                        title: "Are You Sure?",
                        text: "If you delete, it will be moved to trash and you will be able to restore.",
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
                                type: 'GET',
                                url: window.Laravel.baseUrl+"admin/bulk-delete/subscriptions/"+selected,
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

            }else{
                alert("Please at least one of the checkbox");
            }
        });



        $('#m_datatable_check_all_subscriptions_restore').on('click', function(){
            var chkArray = [];

            /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
            $(".m-checkbox--solid input:checked").each(function() {
                chkArray.push($(this).val());
            });

            /* we join the array separated by the comma */
            var selected;
            selected = chkArray.join(',');

            /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
            if(selected.length > 0){

                swal({
                        title: "Are You Sure?",
                        text: "If you restore, it will be undeleted instantly.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#4C8370",
                        confirmButtonText: "Restore",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                type: 'GET',
                                url: window.Laravel.baseUrl+"admin/bulk-restore/subscriptions/"+selected,
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                                }
                            })
                                .done(function(res){ swal.close(); toastr.success("Record restored successfully!"); t.reload(); })
                                .fail(function(res){ toastr.error("Something went wrong, please refresh");  });
                        } else {
                            swal("Cancelled", "No action taken.", "info");
                        }
                    });

            }else{
                alert("Please at least one of the checkbox");
            }
        });
        t.on('m-datatable--on-layout-updated', function(params){
            bindDeleteAction(t);
            bindRestoreAction(t);
            bindToggleAction(t);
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