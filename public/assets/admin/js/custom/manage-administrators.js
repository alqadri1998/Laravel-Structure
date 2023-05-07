
$(document).ready(function () {
    var manageAdministrators = $('#manage-administrators').dataTable({
        processing: false,
        serverSide: true,
        bFilter: true,
        bAutoWidth: false,
        ajax: {
            url: window.Laravel.baseUrl+"admin/list/administrators",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        },
        aoColumns: [
            {data: "full_name", sClass: "left"},
            {data: "user_name", sClass: "left"},
            {data: "email", sClass: "left"},
            {data: "role_id", sClass: "left"},
            {data: "is_active", sClass: "center"},
            {data: "actions", sClass: "center"}
        ],
        aaSorting: [],
        aoColumnDefs: [
            {
                bSortable: false,
                aTargets: [5]
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
                            .done(function(res){ manageAdministrators.fnFilter(); })
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
                            .done(function(res){ manageAdministrators.fnFilter(); })
                            .fail(function(res){ alert('Something went wrong, please try later.'); });
                }
            });
        }
    });
    
});
