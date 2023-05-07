var DatatableRemoteAjaxDemo = function () {
        var t = function () {
            var t = $(".manage-templates").mDatatable({
                data: {
                    type: "remote",
                    source: {read: {url: window.Laravel.baseUrl+"list/templates"}},
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
                        {field: "title", title: "Email Title",  width: 150},
                        {field: "created_at", title: "Created At",  width: 150},
                        {field: "updated_at", title: "Updated At",  width: 150},
                        {field: "actions", title: "Action",  width: 150}
                    ]
            });
            a = t.getDataSourceQuery();
            $("#manage-template-search").on("submit", function (a) {
                a.preventDefault();
                var searchParams = $('#manage-template-search').serializeObject();
                t.setDataSourceQuery(searchParams),
                    t.load()
            });
            $("#template-reset").on("click", function (a) {
                a.preventDefault();
                var dataTable = t.getDataSourceQuery();
                dataTable.emailTitle = '';
                dataTable.createdAt = '';
                dataTable.updatedAt = '';
                dataTable.deletedAt = '';
                $(this).closest('form').find("input[type=text]").val("");
                t.setDataSourceQuery(dataTable);
                t.load()
            });

            $(".manage-templates").on("m-datatable--on-check", function (e, a) {
                var l = t.setSelectedRecords().getSelectedRecords().length;
                var checkStatus = $('#show-trashed-templates').is(':checked');
                if(checkStatus == true){
                    $("#m_datatable_selected_template_restore").html(l), l > 0 && $("#m_datatable_group_action_form_template_restore").collapse("show")
                }else{
                    $("#m_datatable_selected_template").html(l), l > 0 && $("#m_datatable_group_action_form_template").collapse("show")
                }
            }).on("m-datatable--on-uncheck m-datatable--on-layout-updated", function (e, a) {
                var l = t.setSelectedRecords().getSelectedRecords().length;
                var checkStatus = $('#show-trashed-templates').is(':checked');
                if(checkStatus == true) {
                    $("#m_datatable_selected_template_restore").html(l), 0 === l && $("#m_datatable_group_action_form_template_restore").collapse("hide")
                }else{
                    $("#m_datatable_selected_template").html(l), 0 === l && $("#m_datatable_group_action_form_template").collapse("hide")
                }
            });
            $('#show-trashed-templates').on('change', function(){
                $('#manage-template-search').submit();
                if ($(this).is(":checked")){
                    $('#template-deleted-at').show(50,function(){
                        $('#template-created-at').hide('slow');
                        $('#template-updated-at').hide('slow');
                    });
                }else{
                    $('#template-deleted-at').hide(50,function(){
                        $('#template-created-at').show('slow');
                        $('#template-updated-at').show('slow');
                    });
                }
            });
            $('#m_datatable_check_all_templates').on('click', function(){
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
                                    url: window.Laravel.baseUrl+"bulk-delete/templates/"+selected,
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



            $('#m_datatable_check_all_templates_restore').on('click', function(){
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
                                    url: window.Laravel.baseUrl+"bulk-restore/templates/"+selected,
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