var DatatableRemoteAjaxDemo = function () {
    var t = function () {
        var t = $(".manage-users").mDatatable({
            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/users"}},
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
                    {field: "id", title: "#", sortable: !1, width: 50, selector: {class: "m-checkbox--solid m-checkbox--brand"}, textAlign: "center"},
                    {field: "first_name", title: " Name",  width: 150},
                    {field: "email", title: "Email",  width: 200},
                    {field: "is_active", title: "Active",  width: 200},
                    // {field: "user_phone", title: "Phone",  width: 200},
                    // {field: "account_type", title: "Account Type",  width: 100},
                    // {field: "gender", title: "Gender",  width: 70},
                    // {field : "email_verified", title: "Email Verified",  width: 100},
                    {field : "actions", title: "Action",  width: 200}
                ]
        });
        a = t.getDataSourceQuery();
        $("#manage-user-search").on("submit", function (a) {
            a.preventDefault();
            var searchParams = $('#manage-user-search').serializeObject();
            t.setDataSourceQuery(searchParams),
                t.load()
        });
        $("#user-reset").on("click", function (a) {
            a.preventDefault();
            var dataTable = t.getDataSourceQuery();
            dataTable.first_name = '';
            dataTable.last_name = '';
            dataTable.email = '';
            dataTable.userGender = '';
            dataTable.emailStatus = '';
            dataTable.createdAt = '';
            dataTable.updatedAt = '';
            dataTable.deletedAt = '';
            $("#show-email-status option:eq(0)").prop("selected", true);
            $("#show-user-gender option:eq(0)").prop("selected", true);
            $(this).closest('form').find("input[type=text]").val("");
            t.setDataSourceQuery(dataTable);
            t.load()
        });

        $(".manage-users").on("m-datatable--on-check", function (e, a) {
            var l = t.setSelectedRecords().getSelectedRecords().length;
            var checkStatus = $('#show-trashed-users').is(':checked');
            if(checkStatus == true){
                $("#m_datatable_selected_user_restore").html(l), l > 0 && $("#m_datatable_group_action_form_user_restore").collapse("show")
            }else{
                $("#m_datatable_selected_user").html(l), l > 0 && $("#m_datatable_group_action_form_user").collapse("show")
            }
        }).on("m-datatable--on-uncheck m-datatable--on-layout-updated", function (e, a) {
            var l = t.setSelectedRecords().getSelectedRecords().length;
            var checkStatus = $('#show-trashed-users').is(':checked');
            if(checkStatus == true) {
                $("#m_datatable_selected_user_restore").html(l), 0 === l && $("#m_datatable_group_action_form_user_restore").collapse("hide")
            }else{
                $("#m_datatable_selected_user").html(l), 0 === l && $("#m_datatable_group_action_form_user").collapse("hide")
            }
        });
        $('#show-trashed-users').on('change', function(){
            $('#manage-user-search').submit();
            if ($(this).is(":checked")){
                $('#user-deleted-at').show(50,function(){
                    $('#user-created-at').hide('slow');
                    $('#user-updated-at').hide('slow');
                });
            }else{
                $('#user-deleted-at').hide(50,function(){
                    $('#user-created-at').show('slow');
                    $('#user-updated-at').show('slow');
                });

            }
        });
        $('#m_datatable_check_all_users').on('click', function(){
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
                                url: window.Laravel.baseUrl+"admin/bulk-delete/users/"+selected,
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



        $('#m_datatable_check_all_users_restore').on('click', function(){
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
                                url: window.Laravel.baseUrl+"admin/bulk-restore/users/"+selected,
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