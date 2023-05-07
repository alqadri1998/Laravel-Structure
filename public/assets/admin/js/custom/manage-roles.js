
$(document).ready(function () {
    var manageRoles = $('#manage-roles').dataTable({
        processing: false,
        serverSide: true,
        bFilter: true,
        bAutoWidth: false,
        ajax: {
            url: window.Laravel.baseUrl+"admin/list/roles",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        },
        aoColumns: [
            {data: "title", sClass: "left"},
            {data: "modules", sClass: "left"},
            {data: "is_active", sClass: "center"},
            {data: "actions", sClass: "center"}
        ],
        aaSorting: [],
        aoColumnDefs: [
            {
                bSortable: false,
                aTargets: [1,3]
            }
        ],
//        fnPreDrawCallback: function () {
//            show loading icon
//            return true;
//        },
        fnDrawCallback: function (oSettings) {
            $('.delete-record-button').on('click', function(e){
                var url = $(this).data('url');
                if (url.length > 0) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': window.Laravel.csrfToken
                        }
                    })
                            .done(function(res){ manageRoles.fnFilter(); })
                            .fail(function(res){ alert('Something went wrong, please try later.'); });
                }
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
                            .done(function(res){ manageRoles.fnFilter(); })
                            .fail(function(res){ alert('Something went wrong, please try later.'); });
                }
            });
        }
    });
    
});
