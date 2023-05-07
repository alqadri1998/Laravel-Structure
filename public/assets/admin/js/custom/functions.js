
/*
 * ADMIN ROLES SCRIPT
 */


var roleSubModules;

/*
 *
 * @returns {unresolved}
 * Grab all selected checkbox values
 *
 */
function get_jqbox_values() {
    var items = $('#jqxTree').jqxTree('getCheckedItems');
    var temp = [];
    var checkedParentItems = new Array();
    for (var i = 0; i < items.length; i++) {
        var parentI = $('#jqxTree').jqxTree('getItem', items[i].parentElement);
        if (parentI == null) {
            checkedParentItems.push(items[i]);
        } else if (parentI && parentI.checked != true) {
            checkedParentItems.push(items[i]);
        }
        ;
    }
    ;
    var checkboxes = $('#jqxTree').jqxTree('checkboxes');
    var my_mod = [];
    $.each(checkedParentItems, function (key, value) {
        if (value.level == 0 && value.checked == true) {
            var id = value.value;
            my_mod.push(value);
            temp.push({'sub_module_id': id, 'mp_create': 1, 'mp_read': 1, 'mp_update': 1, 'mp_delete': 1});
        }
        else {
            if (value.level == 1 && value.checked == true) {
                var childParentID = $(value.parentElement).data('id');
                // Check: either id exist or not into the temp array
                var result = $.grep(temp, function (e) {
                    return e.sub_module_id == childParentID;
                });
                if (result.length == 0)
                {   // not found
                    temp.push({'sub_module_id': childParentID, 'mp_create': 0, 'mp_read': 0, 'mp_update': 0, 'mp_delete': 0});
                }
                for (var i in temp) {
                    if (temp[i].sub_module_id == childParentID) {
                        if (value.label == "Create")
                        {
                            temp[i].mp_create = 1;
                        }
                        else if (value.label == "Read")
                        {
                            temp[i].mp_read = 1;
                        }
                        else if (value.label == "Update")
                        {
                            temp[i].mp_update = 1;
                        }
                        else if (value.label == "Delete")
                        {
                            temp[i].mp_delete = 1;
                        }
                        break; //Stop this loop, we found it!
                    }
                }
            }
        }
    });// end loop here
    roleSubModules = temp;
}

// Get method for module permission
function getRoleSubModules() {
    return roleSubModules;
}


function bindDeleteAction(t){
    $('.delete-record-button').on('click', function(e){
        var url = $(this).data('url');
        swal({
                title: "Are You Sure?",
                text: "If you delete, it will be moved to trash and you will be able to restore.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true
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

}

function bindRestoreAction(t){

    $('.restore-record-button').on('click', function(e){
        var url = $(this).data('url');
        swal({
                title: "Are You Sure?",
                text: "If you restore, it will be undeleted instantly.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4C8370",
                confirmButtonText: "Restore",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type: 'GET',
                        url: url,
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
    });
}

function bindToggleAction(t){

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
                .done(function(res){
                    console.log(res.msg);
                    toastr.success(res.msg); t.reload();
                })
                .fail(function(res){ toastr.error("Something went wrong, please refresh."); });
        }
    });
}

$('.clear-cache-button').on('click', function(e){
    var url = $(this).data('url');
    swal({
            title: "Are You Sure?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Clear",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                    }
                })
                    .done(function(res){ swal.close(); toastr.success("Cleared successfully!"); })
                    .fail(function(res){  toastr.error("Something went wrong, please refresh.");  });
            } else {
                swal("Cancelled", "No action taken.", "error");
            }
        });
});




function imageUrl(path, width, height, quality, crop) {
    if (typeof (width) === 'undefined')
        width = null;
    if (typeof (height) === 'undefined')
        height = null;
    if (typeof (quality) === 'undefined')
        quality = null;
    if (typeof (crop) === 'undefined')
        crop = null;

    var basePath = window.Laravel.base;
    var url = null;
    if (!width && !height) {
        url = path;
    } else {
        url = basePath + '/images/timthumb.php?src=' + path;
        if (width !== null) {
            url += '&w=' + width;
        }
        if (height !== null && height > 0) {
            url += '&h=' + height;
        }
        if (crop !== null) {
            url += "&zc=" + crop;
        } else {
            url += "&zc=1";
        }
        if (quality !== null) {
            url += '&q=' + quality + '&s=1';
        } else {
            url += '&q=95&s=1';
        }
    }
    return url;
}
