
$(document).ready(function () {
    var manageUsers = $('#manage-users').dataTable({
        processing: false,
        serverSide: true,
        bFilter: true,
        bAutoWidth: false,
        ajax: {
            url: window.Laravel.baseUrl+"admin/list/users",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        },
        aoColumns: [
            {data: "first_name", sClass: "left"},
            {data: "last_name", sClass: "left"},
            {data: "email", sClass: "left"},
            {data: "mobile", sClass: "left"},
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
                            .done(function(res){ manageUsers.fnFilter(); })
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
                            .done(function(res){ manageUsers.fnFilter(); })
                            .fail(function(res){ alert('Something went wrong, please try later.'); });
                }
            });
        }
    });
    
});
