
$(document).ready(function () {
    var manageLotteries = $('#manage-lotteries').dataTable({
        processing: false,
        serverSide: true,
        bFilter: true,
        bAutoWidth: false,
        ajax: {
            url: window.Laravel.baseUrl+"admin/list/lotteries",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        },
        aoColumns: [
            {data: "prize_amount", sClass: "left"},
            {data: "ticket_price", sClass: "left"},
            {data: "tickets_sold", sClass: "left"},
            {data: "draw_date", sClass: "left"},
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
                            .done(function(res){ manageLotteries.fnFilter(); })
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
                            .done(function(res){ manageLotteries.fnFilter(); })
                            .fail(function(res){ alert('Something went wrong, please try later.'); });
                }
            });
        }
    });
    
});
