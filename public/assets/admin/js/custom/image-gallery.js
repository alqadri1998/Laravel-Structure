$(document).ready(function () {
    foldersDir();
    $('#select-image-button').attr('disabled', 'true').addClass('disabled');
    $(document).on('click', '.folder-image', function () {
        $('#select-image-button').removeAttr('disabled').removeClass('disabled'); //Set Select button disable false
        $('.folder-image').parent().removeClass('select-folder-image'); //make images unselected except clicked one
        $('.selected-image').attr('src', imageUrl($(this).attr('src'), 120, 120, 100, 1));
        $(this).parent().toggleClass('select-folder-image'); //make image selected
        var selectedImageSrc = $(this).attr('src').replace(window.Laravel.base+'/', '');//getting image path and trim base url
        $('.public_select_image').val(selectedImageSrc); //set image path to input typ hidden
    });
    /*==========================================DELETE IMAGE===========================================*/
    $(document).on('click', '.delete-image', function () {
        var folderName = $(this).prev().data('folder-name');
        var imagePath = $(this).prev().attr('src').replace(window.Laravel.base+'/', '');
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
                        type: 'GET',
                        url: window.Laravel.baseUrl+"delete-public-image?image_path="+imagePath+"&folder_name="+folderName,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': window.Laravel.csrfToken
                        }
                    })
                        .done(function(res){
                            swal.close();
                            folderOnclick(folderName);
                            toastr.success('success','Image Deleted Successfully');
                        })
                        .fail(function(res){ toastr.error("Something went wrong, please refresh."); });
                } else {
                    swal("Cancelled", "Your imaginary file is safe", "error");
                }
            });
    });
});
/*==========================================DELETE IMAGE===========================================*/
/*=========================GETTING ALL FOLDERS FROM UPLOADS FOLDER=================================*/
function foldersDir() {
    $('.thumbnail').empty();
    $('div.backButton').empty();
    var directory = $('#directory').data('directory');
    var foldersHtml = '';
    $(folders).each(function (index, value) {
        if (index > 1){
            foldersHtml += '<div class="col-md-3" style="padding-top: 10px" class="folders">' +
                '<div class="thumbnail">' +
                '<img onclick="folderOnclick(\''+value+'\')" src="'+window.Laravel.base+'/images/download.png'+'" alt="" style="height: 100px;width: 100px">' +
                '<div class="caption">' +
                '<p>'+value+'</p>' +
                '</div></div></div>';
        }
    });
    $('.thumbnail').append(foldersHtml);
}
/*=========================GETTING ALL FOLDERS FROM UPLOADS FOLDER=================================*/
/*===========================GETTING ALL IMAGES OF CLICKED FOLDER==================================*/
function folderOnclick(folderName) {
    var url = window.Laravel.baseUrl+'get-public-images?folder='+folderName;
    if (url.length > 0) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        })
            .done(function(response){
                $('.thumbnail').empty();
                $('div.backButton').html('<i class="fa fa-home"></i> <a href="#" class="m-nav__link" onclick="foldersDir()"><span class="m-nav__link-text"> Home</span></a>');
                var html = '';
                $(response.data).each(function (index, data) {
                    if (index > 1){
                        if (typeof data.extension !== 'undefined'){
                            html += '<div class="col-md-3" style="padding-top: 10px" class="folders"><div class="thumbnail img-wrapper">' +
                                '<img class="folder-image img-responsive" src="'+window.Laravel.base+'/uploads/'+folderName+'/'+data.basename+'" data-folder-name="'+folderName+'" alt="" style="height: 150px;width: 150px">' +
                                '<a href="#" class="delete-image"><span class="cross" aria-hidden="true" style="color: #ffffff">×</span></a>' +
                                '</div></div>';
                        }else{
                            html += '<div class="col-md-3" class="folders" style="padding-top: 10px" class="folders"><div class="thumbnail">' +
                                '<img onclick="folderOnclick(\''+folderName+'/'+data.filename+'\')" src="'+window.Laravel.base+'/images/download.png" alt="" style="height: 150px;width: 150px">' +
                                '</div><div class="caption">' +
                                '<p>'+data.filename+'</p>\n' +
                                '</div></div>';
                        }
                    }
                });
                $('.thumbnail').append(html);
            })
            .fail(function(res){ alert('Something went wrong, please try later.'); });
    }
}
/*===========================GETTING ALL IMAGES OF CLICKED FOLDER==================================*/
/*===========================UPLOAD IMAGE==================================*/
$('.upload-image').on('click', function () {
    $(this).next().click();
});

$('.upload_image_input').on('change', function () {
    var fileData = $(this).prop("files")[0];
    var formData = new FormData();
    formData.append("image", fileData);
    var url = window.Laravel.baseUrl+'upload-image';
    if (url.length > 0) {
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data : formData,
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        })
            .done(function (res) {
                foldersDir();
                $('.public_select_image').val(res.data);
                $('.selected-image').attr('src', imageUrl(window.Laravel.base+res.data, 120, 120, 100, 1));
                if (res.success == false ) {
                    toastr.error(res.message, 'Error');
                }
                else {
                    $(".select_image").show();
                    toastr.success(res.message, 'Success');
                }
                $('button.close').click();
            })
            .fail(function (res) {
                alert('Something went wrong, please try later.');
            });
    }
});